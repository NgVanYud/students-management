<?php

namespace App\Http\Controllers\Backend\Question;

use App\Http\Requests\Backend\Question\ManageQuestionRequest;
use App\Models\Question;
use App\Repositories\Backend\QuestionRepository;
use App\Repositories\Backend\SubjectRepository;
use App\Repositories\ChapterRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    protected $questionRepository;
    protected $subjectRepository;
    protected $chapterRepository;

    public function __construct(
        QuestionRepository $questionRepository,
        SubjectRepository $subjectRepository,
        ChapterRepository $chapterRepository
    )
    {
        $this->questionRepository = $questionRepository;
        $this->subjectRepository = $subjectRepository;
        $this->chapterRepository = $chapterRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManageQuestionRequest $request)
    {
        $questions = $this->questionRepository->getActivePaginated();
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

        return view('backend.questions.index',
            [
                'question' => $questions,
                'subjects_info' => $subjects_info
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ManageQuestionRequest $request)
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
        return view('backend.questions.create',[
           'subjects_info' => $subjects_info
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
