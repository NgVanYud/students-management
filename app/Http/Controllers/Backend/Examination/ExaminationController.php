<?php

namespace App\Http\Controllers\Backend\Examination;

use App\Exceptions\GeneralException;
use App\Http\Requests\Backend\Examination\ManageExaminationRequest;
use App\Http\Requests\Backend\Examination\StoreExaminationRequest;
use App\Http\Requests\Backend\Examination\StoreFormatTestRequest;
use App\Http\Requests\Backend\Examination\StoreTestNumRequest;
use App\Http\Requests\Backend\Examination\UpdateExaminationRequest;
use App\Models\Auth\User;
use App\Models\Examination;
use App\Models\Test;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\ExaminationRepository;
use App\Repositories\Backend\QuestionRepository;
use App\Repositories\Backend\SubjectRepository;
use App\Repositories\Backend\TestRepository;
use App\Repositories\ChapterRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Excel;
use Torann\GeoIP\Console\Update;

class ExaminationController extends Controller
{
    protected $subjectRepository;
    protected $examinationRepository;
    protected $userRepository;
    protected $testRepository;
    protected $chapterRepository;
    protected $questionRepository;

    public function __construct(
        SubjectRepository $subjectRepository,
        ExaminationRepository $examinationRepository,
        UserRepository $userRepository,
        TestRepository $testRepository,
        ChapterRepository $chapterRepository,
        QuestionRepository $questionRepository
    )
    {
        $this->subjectRepository = $subjectRepository;
        $this->examinationRepository = $examinationRepository;
        $this->userRepository = $userRepository;
        $this->testRepository = $testRepository;
        $this->chapterRepository = $chapterRepository;
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManageExaminationRequest $request)
    {
        $examinations = $this->examinationRepository
            ->orderBy('created_at', 'desc')
            ->paginate(25);
        return view('backend.examinations.index')
            ->with(['examinations' => $examinations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ManageExaminationRequest $request)
    {
        $subjects = $this->subjectRepository->getActive(['slug', 'name'], 'name', 'asc');
        $subjects_arr = $subjects->pluck('name', 'slug')->toArray();
        return view('backend.examinations.create', [
            'subjects' => $subjects_arr
        ]);
    }

    public function store (StoreExaminationRequest $request) {
        try {
            \DB::transaction(function() use ($request){
                $examination = $this->storeGeneralInfo($request);
                if($examination) {
                    $this->storeProctors($request, $examination);
                    $this->storeStudents($request, $examination);
                }
            });
            return redirect()->route('admin.examination.index')
                ->withFlashSuccess(__('alerts.backend.examinations.created'));
        } catch (\Exception $ex) {
//            throw new GeneralException($ex->getMessage());
            throw new GeneralException(__('exceptions.backend.examinations.uncreated'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeGeneralInfo(StoreExaminationRequest $request)
    {
        $subject = $this->subjectRepository->getAllWithCondition(['slug' => $request->subject])->first();
        if($subject) {
            $examination = new Examination();
            $examination->name = $request->name;
//            $examination->subject_id = $subject->id;
            $examination->is_actived = intval($request->is_actived);
            $examination->code = $request->code;
            $examination->note = $request->note;
            $examination->setBeginTime($request->begin_date, $request->begin_time);
            $saved = $subject->examinations()->save($examination);
            if($saved) {
                return $examination;
            }
        } else {
            return null;
        }
    }

    public function storeProctors(Request $request, Examination $examination)
    {
        $selected_file = $request->proctors_file;

        if($this->validateFile($selected_file, ['xlsx', 'xls', 'csv'])) {
            $data = $this->getExcelData($selected_file);

            if (!empty($data) && $data->count()) {
                /*$row tương đương với từng sheet trong excel, có dạng Collection*/
                try {
                    \DB::transaction(function () use ($data, $examination){
                        $proctors_in_exam = collect();
                        foreach ($data as $key => $sheet) {
                            foreach ($sheet as $row) {
                                $current_proctor = $this->userRepository->getByColumn($row['username'], 'username', ['*']);
                                if($current_proctor) {
                                    $this->activeUserWithRoles($current_proctor, [config('access.users.proctor_role'), config('access.users.teacher_role')]);
                                    $proctors_in_exam->push($current_proctor);
                                } else {
                                    dd('moi: '.$row);
                                    $roles = [config('access.users.proctor_role'), config('access.users.teacher_role')];
                                    $new_proctor = $this->createUserFromExcel($row, $roles);

                                    if(!$new_proctor) {
                                        return redirect()->back()->with([
                                            'tab_type' => Examination::TAB_TYPES['proctors']
                                            ])->withFlashError(__('alerts.backend.examinations.uncreated_proctors'));
                                    } else {
                                        $proctors_in_exam->push($new_proctor);
                                    }
                                }
                            }
                        }
                        $examination->proctors()->sync($proctors_in_exam->pluck('id')->toArray());
                    });
                } catch (\Exception $ex) {
                    throw new GeneralException($ex->getMessage());
//                    throw new GeneralException(__('exceptions.backend.examinations.uncreated_proctors'));
                }
            } else {
                throw new GeneralException(__('exceptions.backend.examinations.uncreated_proctors'));
            }
        }
    }

    public function storeStudents(Request $request, Examination $examination){
        $selected_file = $request->students_file;

        if($this->validateFile($selected_file, ['xlsx', 'xls', 'csv'])) {
            $data = $this->getExcelData($selected_file);

            if (!empty($data) && $data->count()) {
                /*$row tương đương với từng sheet trong excel, có dạng Collection*/
                try {
                    \DB::transaction(function () use ($data, $examination){
                        $students_in_exam = collect();
                        foreach ($data as $key => $sheet) {
                            foreach ($sheet as $row) {
                                $current_student = $this->userRepository->getByColumn($row['username'], 'username', ['*']);
                                if($current_student) {
                                    $this->activeUserWithRoles($current_student, [config('access.users.student_role')]);
                                    $students_in_exam->push($current_student);
                                } else {
                                    $roles = [config('access.users.student_role')];
                                    $new_student = $this->createUserFromExcel($row, $roles);

                                    if(!$new_student) {
                                        return redirect()->route('admin.examination.create')
                                            ->with([
                                                'tab_type' => Examination::TAB_TYPES['students'],
                                            ])->withFlashError(__('alerts.backend.examinations.uncreated_students'));
                                    } else {
                                        $students_in_exam->push($new_student);
                                    }
                                }
                            }
                        }
                        $examination->students()->sync($students_in_exam->pluck('id')->toArray());
                    });
                } catch (\Exception $ex) {
                    throw new GeneralException($ex->getMessage());
//                    throw new GeneralException(__('exceptions.backend.examinations.uncreated_students'));
                }
            }
        } else {
            throw new GeneralException(__('exceptions.backend.examinations.uncreated_students'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ManageExaminationRequest $request, Examination $examination, $tab_type = null)
    {
        $tab_type = (isset($tab_type) && in_array($tab_type, Examination::TAB_TYPES))
        ? $tab_type : Examination::TAB_TYPES['general_info'];

        $subjects = $this->subjectRepository->getActive(['slug', 'name'], 'name', 'asc');
        $subjects_arr = $subjects->pluck('name', 'slug')->toArray();

        return view('backend.examinations.edit', [
            'tab_type' => $tab_type,
            'examination' => $examination,
            'subjects' => $subjects_arr
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function updateGeneralInfo(UpdateExaminationRequest $request, Examination $examination) {
        $subject = $this->subjectRepository->getAllWithCondition(['slug' => $request->subject])->first();

        if($subject) {
            try {
                \DB::transaction(function() use ($examination, $request, $subject){
                    $examination->name = $request->name;
                    $examination->is_actived = intval($request->is_actived);
                    $examination->code = $request->code;
                    $examination->note = $request->note;
                    $examination->setBeginTime($request->begin_date, $request->begin_time);
                    $subject->examinations()->save($examination);
                });
                return redirect()->route('admin.examination.edit', [
                    'examination' => $examination,
                ])->withFlashSuccess(__('alerts.backend.examinations.updated_general_info'));
            } catch (\Exception $ex) {
//                throw new GeneralException($ex->getMessage());
                throw new GeneralException(__('exceptions.backend.examinations.unupdated_general_info'));
            }
        }
        return redirect()->route('admin.examination.edit', [
            'examination' => $examination,
        ])->withFlashError(__('alerts.backend.examinations.unupdated_general_info'));
    }

    public function updateStudents(UpdateExaminationRequest $request, Examination $examination) {
        $this->storeStudents($request, $examination);
        return redirect()->route('admin.examination.edit', [
            'examination' => $examination,
            'tab_type' => Examination::TAB_TYPES['students']
        ])->withFlashSuccess(__('alerts.backend.examinations.updated_students'));
    }

    public function updateProctors(UpdateExaminationRequest $request, Examination $examination) {
        $this->storeProctors($request, $examination);
        return redirect()->route('admin.examination.edit', [
            'examination' => $examination,
            'tab_type' => Examination::TAB_TYPES['proctors']
        ])->withFlashSuccess(__('alerts.backend.examinations.updated_proctors'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getExcelData($uploadedFile) {
        $path = $uploadedFile->getRealPath();
        $data = Excel::load($path, function ($reader) {
            $reader->ignoreEmpty();
        })->get();
        return $data;
    }

    public function validateFile($uploadedFile, $valid_extensions) {
        $extension = File::extension($uploadedFile->getClientOriginalName());
        if(in_array($extension, $valid_extensions)) {
            return true;
        }
        return false;
    }

    /**
     * @param $user: User
     * @param $col: array
     * @param $role: array
     */
    public function activeUserWithRoles($user, $roles) {
        \DB::transaction(function() use ($user, $roles){
            if($user) {
                if(!$user->isActive()) {
                    $user->update(['active' => User::ACTIVE_CODE]);
                }
                if(is_array($roles)) {
                    foreach ($roles as $role)
                        if(!$user->hasRole($role)) {
                            $user->assignRole($role);
                        }
                }
            }
        });
    }

    public function createUserFromExcel($row, $roles) {
        $row['identity'] = intval($row['identity']);
        $row['gender'] = isset($row['gender']) ? intval($row['gender']) : 0;
        $row['active'] = User::ACTIVE_CODE;
        $row['confirmed'] = 0;
        $row['phone_number'] = isset($row['phone_number']) ? $row['phone_number'] : '';
        $row['roles'] = $roles;
        $row['password'] = config('access.users.default_password');
        $row = $row->toArray();
        $user = $this->userRepository->create($row);
        return $user;
    }

    public function deleteStudent(ManageExaminationRequest $request, Examination $examination, User $student) {

    }

    public function formatTest(ManageExaminationRequest $request, Examination $examination) {
//        dd(json_decode($examination->format_test, true));
        return view('backend.examinations.tests.format', [
            'examination' => $examination
        ]);
    }

    public function storeFormatTest(StoreFormatTestRequest $request, Examination $examination) {
        $arr_chapters = $request->except(['_token', 'timeout']);
        unset($arr_chapters['_token']);
        $total_questions = array_sum($arr_chapters);
        $examination->update([
            'format_test' => json_encode($arr_chapters),
            'question_num' => $total_questions,
            'timeout' => $request->timeout
        ]);
        return redirect()->route('admin.examination.index')
            ->withFlashSuccess(__('alerts.backend.examinations.create_format_test'));
    }

    public function createTestNum(ManageExaminationRequest $request, Examination $examination) {
        return view('backend.examinations.tests.test-num', [
            'examination' => $examination
        ]);
    }

    public function storeTests(StoreTestNumRequest $request, Examination $examination) {
        if($examination->is_published || empty($examination->format_test))
            return redirect()->back()
                ->withFlashError(__('alerts.backend.examinations.uncreate_test_num'));

        try {
            \DB::transaction(function() use ($examination, $request){
                $test_num = $request->test_num;
                $updated = $examination->update(['test_num' => $test_num]);
                $subject = $examination->subject;

                $top_exams = $this->examinationRepository
                    ->getTopNearlyExamination(config('examination.previous_terms_num'), $subject);

                /*
                 * 10 kỳ trước đó
                 * array: [
                 *  'slug-chapterter1' => array([id_question]),
                 *  'slug-chapterter2' => array([id_question])
                 * ]
                 */
                $questions_in_chapter = [];
                foreach ($top_exams as $exam) {
                    $temp_question = $this->examinationRepository->getQuestionWithChapter($top_exams);
                    $questions_in_chapter = array_merge_recursive($questions_in_chapter, $temp_question);
                }
                if($updated) {
                    /**
                     * Tạo tất cả test cho exam
                     */
                    $examination = $this->examinationRepository->createMutipleTest($examination);
                    $format_question = json_decode($examination->format_test, true);
                    $all_tests = $examination->tests;
                    $all_chapters = $subject->chapters;
                    foreach ($all_tests as $test) {
                        foreach ($all_chapters as $chapter) {

                            $existed_questions_id = isset($questions_in_chapter[$chapter->slug]) ? $questions_in_chapter[$chapter->slug] : [];
                            $unexisted_question = $chapter->questions->whereNotIn('id', $existed_questions_id);

                            /*
                             * Tất cả các question trong $chaper trong 10 đợt thi gần đây
                             */
                            $existed_questions = $this->questionRepository->whereIn('id', $existed_questions_id)->get();

                            $needed_questions_num = $format_question[$chapter->slug];
                            $reuse_questions_num = intval(floor(($existed_questions->count()) * config('examination.duplicated_percent') / 100));
                            $new_questions_num = $needed_questions_num - $reuse_questions_num;

                            /**
                             * Thêm các question từ kỳ $chapter trong các kỳ trk vào đề thi
                             */
                            $random_questions = $this->questionRepository->getRandomQuestions($existed_questions, $reuse_questions_num);
                            $test->questions()->attach($random_questions->pluck('id')->toArray());

                            /**
                             * Thêm các question không
                             */
                            $random_questions = $this->questionRepository->getRandomQuestions($unexisted_question, $new_questions_num);
                            $test->questions()->attach($random_questions->pluck('id')->toArray());
                        }
                    }
                    /*
                     * Phát đề thi cho từng thí sinh
                     */
                    $this->examinationRepository->allocateTests($examination);
                    }
            });
            return redirect()->route('admin.examination.index')
                        ->withFlashSuccess(__('alerts.backend.examinations.create_test_num'));
        } catch (\Exception $ex) {
            throw new GeneralException('This number of tests was not created successfully because of some errors');
        }
        return redirect()->route('admin.examination.index')
            ->withFlashError('This examination is can not edit');
    }
}
