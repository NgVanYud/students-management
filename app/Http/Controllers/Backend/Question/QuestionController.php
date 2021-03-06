<?php

namespace App\Http\Controllers\Backend\Question;

use App\Http\Controllers\Traits\ControllerTrait;
use App\Http\Requests\Backend\Question\ValidationQuizMakerRequest;
use App\Http\Requests\Backend\Question\ManageQuestionRequest;
use App\Http\Requests\Backend\Question\ShowQuestionRequest;
use App\Http\Requests\Backend\Question\StatusQuestionRequest;
use App\Http\Requests\Backend\Question\StoreQuestionRequest;
use App\Models\Answer;
use App\Models\Auth\User;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Traits\Method\QuestionMethod;
use App\Repositories\Backend\AnswerRepository;
use App\Repositories\Backend\QuestionRepository;
use App\Repositories\Backend\SubjectRepository;
use App\Repositories\ChapterRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

class QuestionController extends Controller
{
    use ControllerTrait;

    protected $questionRepository;
    protected $subjectRepository;
    protected $chapterRepository;
    protected $answerRepository;

    public function __construct(
        QuestionRepository $questionRepository,
        SubjectRepository $subjectRepository,
        ChapterRepository $chapterRepository,
        AnswerRepository $answerRepository
    )
    {
        $this->questionRepository = $questionRepository;
        $this->subjectRepository = $subjectRepository;
        $this->chapterRepository = $chapterRepository;
        $this->answerRepository = $answerRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ShowQuestionRequest $request)
    {
        $user = Auth::user();
        if($user->isAdmin()) {
            $questions = $this->questionRepository->getAllPaginated(25, ['*']);
            $subjects = $this->subjectRepository->getActive(['id', 'name', 'slug'], 'name', 'asc');
        } else if($user->isQuizMaker()) {
            $subjects = $this->paginate($user->subjects, 25)->setPath(Paginator::resolveCurrentPath());
            $questions = $this->paginate($this->questionRepository->getBySubjects($subjects), 25)->setPath(Paginator::resolveCurrentPath());
        }

//        $chapters = $this->chapterRepository->getActive(['name', 'slug'], 'name', 'asc');
        /**
         * $subject_info
         *  [
         *      'name_subject1' => [
         *              'name_chapter1' => 'slug_chapter1'
         *              'name_chapter2' => 'slug_chapter2'
         *              'name_chapter3' => 'slug_chapter3'
         *      ],
         *      'name_subject2' => [
         *              'name_chapter1' => 'slug_chapter1'
         *              'name_chapter2' => 'slug_chapter2'
         *      ]
         *  ]
         */
        $subjects_info = [];
        foreach ($subjects as $subject) {
            $subjects_info[$subject->name] = $subject->chapters->pluck('name', 'slug')->toArray();
        }

        if ($request->ajax()) {

            if(isset($request->chapter_slug)) {
                $chapter = $this->chapterRepository->getByColumn($request->chapter_slug, 'slug');
                if(isset($request->status_code)) {
                    $questions = $chapter->questions()
                        ->where('is_actived', $request->status_code)
                        ->orderBy('created_at', 'asc')
                        ->paginate(25);
                } else {
                    $questions = $chapter->questions()->orderBy('created_at', 'asc')->paginate(25);
                }
            } else {
                if(isset($request->status_code)) {
                    $questions = $this->questionRepository->getIsActivePaginated($request->status_code, ['*'], '25');
                }
            }
            return Response::json(View::make('backend.questions.includes.load-list', array('questions' => $questions))->render());
        }

        return view('backend.questions.index',
            [
                'questions' => $questions,
                'subjects_info' => $subjects_info
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ValidationQuizMakerRequest $request)
    {
        $user = Auth::user();
        if($user->isAdmin()) {
            $subjects = $this->subjectRepository->getActive(['id', 'name', 'slug'], 'name', 'asc');
        } else if($user->isQuizMaker()) {
            $subjects = $user->subjects;
        }
//        $chapters = $this->chapterRepository->getActive(['name', 'slug'], 'name', 'asc');
        /**
         * $subject_info
         *  [
         *      'name_subject1' => [
         *              'name_chapter1' => 'slug_chapter1'
         *              'name_chapter2' => 'slug_chapter2'
         *              'name_chapter3' => 'slug_chapter3'
         *      ],
         *      'name_subject2' => [
         *              'name_chapter1' => 'slug_chapter1'
         *              'name_chapter2' => 'slug_chapter2'
         *      ]
         *  ]
         */
        $subjects_info = [];
        foreach ($subjects as $subject) {
            $subjects_info[$subject->name] = $subject->chapters->pluck('name', 'slug')->toArray();
        }
        return view('backend.questions.create', [
            'subjects_info' => $subjects_info
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        $creater = Auth::check() ? Auth::user() : null;
        $chapter = $this->chapterRepository->getByColumn($request->chapters, 'slug');
        $subject = $chapter->subject;
        if ($subject && $chapter && $creater) {
            $question_info = $request->only(['content', 'is_actived']) +
                [
                    'subject_id' => $subject->id,
                    'creater_id' => $creater->id,
                    'chapter_id' => $chapter->id
                ];
            DB::transaction(function() use ($question_info, $request){
                $created_question = $this->questionRepository->create($question_info);
                if($created_question) {
                    $options = $request->options;
                    $correct_options = $request->correct_options;
                    $all_answers = [];
                    foreach ($options as $key => $option) {
                        $all_answers[] = [
                            'content' => $option,
                            'question_id' => $created_question->id,
                            'is_correct' => in_array($key, $correct_options, false) ? Answer::CODE_CORRECT : Answer::CODE_INCORRECT
                        ];
                    }
                    $created_answers = $this->answerRepository->createMultiple($all_answers);
                    if($created_answers) {
                        return redirect()->back()
                            ->withFlashSuccess(__('alerts.backend.questions.created'));
                    }
                }
            });

        }
        return redirect()->back()
            ->withFlashError(__('alerts.backend.questions.uncreated'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(ManageQuestionRequest $request, Chapter $chapter)
    {
//        $questions = $chapter->questions()->orderBy('created_at', 'asc')->paginate(25);
//        if ($request->ajax()) {
//            return Response::json(View::make('backend.questions.includes.load-list', array('questions' => $questions))->render());
//        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ManageQuestionRequest $request, Chapter $chapter, Question $question)
    {
        $subjects = $this->subjectRepository->getActive(['id', 'name', 'slug'], 'name', 'asc');
//        $chapters = $this->chapterRepository->getActive(['name', 'slug'], 'name', 'asc');
        /**
         * $subject_info
         *  [
         *      'name_subject1' => [
         *              'name_chapter1' => 'slug_chapter1'
         *              'name_chapter2' => 'slug_chapter2'
         *              'name_chapter3' => 'slug_chapter3'
         *      ],
         *      'name_subject2' => [
         *              'name_chapter1' => 'slug_chapter1'
         *              'name_chapter2' => 'slug_chapter2'
         *      ]
         *  ]
         */
        $subjects_info = [];
        foreach ($subjects as $subject) {
            $subjects_info[$subject->name] = $subject->chapters->pluck('name', 'slug')->toArray();
        }
        return view('backend.questions.edit', [
            'subjects_info' => $subjects_info,
            'chapter' => $chapter,
            'question' => $question,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, Chapter $chapter, Question $question)
    {
        $creater = Auth::check() ? Auth::user() : null;
        $subject = $chapter->subject;
        if(($chapter->is($question->chapter)) && $subject && $creater) {
            DB::transaction(function () use ($request, $question) {
                $updated_question = $question->update($request->only(['content', 'is_actived']));
                if ($updated_question) {
                    $options = $request->options;
                    $correct_options = $request->correct_options;
                    $all_answers = $question->answers;
                    foreach ($all_answers as $key => $option) {
                        $option->update(['content' => $options[$key], 'is_correct' =>
                            in_array($key, $correct_options, false) ? Answer::CODE_CORRECT : Answer::CODE_INCORRECT]);
                    }
                }
            });
            return redirect()->route('admin.chapter.question.index')
                ->withFlashSuccess(__('alerts.backend.questions.updated'));
        }
        return redirect()->route('admin.chapter.question.index')
            ->withFlashError(__('alerts.backend.questions.unupdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageQuestionRequest $request, Chapter $chapter, Question $question)
    {

    }

    public function active(StatusQuestionRequest $request, Question $question) {
        $this->questionRepository->active($question);
        return redirect()->back()->withFlashSuccess(__('alerts.backend.questions.actived'));
    }

    public function inactive(StatusQuestionRequest $request, Question $question) {
        $this->questionRepository->inactive($question);
        return redirect()->back()->withFlashSuccess(__('alerts.backend.questions.inactived'));
    }

    public function restore(StatusQuestionRequest $request, Question $question) {

    }

    public function getDeleted(ValidationQuizMakerRequest $request) {
        return view('backend.subjects.deleted')
            ->withSubjects($this->subjectRepository->getDeletedPaginated(25, 'deleted_at', 'desc'));
    }


    /**
     * @param ManageUserRequest $request
     *
     * @return mixed
     */
    public function getDeactivated(ShowQuestionRequest $request)
    {
        return view('backend.auth.user.deactivated')
            ->withUsers($this->userRepository->getInactivePaginated(25, 'id', 'asc'));
    }
}
