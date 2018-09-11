<?php

namespace App\Http\Controllers\Backend\Subject;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\ControllerTrait;
use App\Http\Requests\Backend\Lecturer\ManageLecturerRequest;
use App\Http\Requests\Backend\Subject\ManageSubjectRequest;
use App\Models\Auth\User;
use App\Models\Subject;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\SubjectRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Lecturer\StoreLecturerRequest;

class LecturerController extends Controller
{
    use ControllerTrait;

    protected $subjectRepository;
    protected $userRepository;

    public function __construct(UserRepository $userRepository, SubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
        $this->userRepository = $userRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManageSubjectRequest $request, Subject $subject)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ManageSubjectRequest $request, Subject $subject)
    {
        /*
         * Lấy tất cả user có role là teacher, kể cả user đang dạy chính $subject này
         */
        $all_lecturers = $this->userRepository
            ->getByRole(config('access.users.teacher_role'));
        /*
         * Lấy user là giáo viên nhưng chưa từng giảng dạy $subject trong số các $all_lecturers
         */
        $lecturers_to_add = $all_lecturers->reject(function ($lecturer, $key) use ($subject) {
            /*
             * Tất cả môn học mà $lecturer này đang dạy
             */
            $subjects_teaching = $lecturer->subjects->toArray();
            return in_array($subject->id, array_column($subjects_teaching, 'id'));
        });

        $lecturers_to_add = $this->paginate($lecturers_to_add, 25)->setPath('total');
        return view('backend.subjects.lecturers.add')
            ->withSubject($subject)
            ->withLecturers($lecturers_to_add);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLecturerRequest $request, Subject $subject)
    {
        $lecturers = $this->userRepository->get(['id', 'uuid'])->whereIn('uuid', $request->selected_lecturers);
        if (!$lecturers) {
            return redirect()->back()->withFlashDanger(__('alerts.backend.subjects.lecturers.invalid_lecturers'));
        } else {
            $subject->lecturers()->attach($lecturers->pluck('id'));
            return redirect()->back()->withFlashSuccess(__('alerts.backend.subjects.lecturers.added'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageLecturerRequest $request, Subject $subject, User $lecturer)
    {
        /*
         * Check $lecturer có phải người dạy $subject này không
         */
        $tab_type = Subject::TAB_TYPES['lecturers'];
        if ($lecturer->subjects->contains($subject->id)) {
            $subject->lecturers()->detach($lecturer->id);
            return redirect()->route('admin.subject.show', [$subject, $tab_type])
                ->withFlashSuccess(__('alerts.backend.subjects.lecturers.deleted'));
        }
        return redirect()->route('admin.subject.show', [$subject, $tab_type])
            ->withFlashSuccess(__('alerts.backend.subjects.lecturers.undeleted'));
    }

    public function total(ManageLecturerRequest $request)
    {
        $subjects = $this->subjectRepository
            ->getAllWithCondition(['is_actived' => Subject::ACTIVE_CODE])
            ->pluck('name', 'slug');
        $lecturers = $this->userRepository
            ->getByRole(config('access.users.teacher_role'));
        $lecturers = $this->paginate($lecturers, 2)->setPath('total');
        return view('backend.subjects.lecturers.index')
            ->withSubjects($subjects)
            ->withLecturers($lecturers);
    }
}
