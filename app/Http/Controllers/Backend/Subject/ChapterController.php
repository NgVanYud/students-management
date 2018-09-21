<?php

namespace App\Http\Controllers\Backend\Subject;

use App\Http\Requests\Backend\Subject\ShowChapterRequest;
use App\Http\Requests\Backend\Subject\ShowSubjectRequest;
use App\Http\Requests\Backend\Subject\StoreChapterRequest;
use App\Http\Requests\Backend\Subject\StoreSubjectRequest;
use App\Http\Requests\Backend\Subject\ManageChapterRequest;
use App\Models\Chapter;
use App\Models\Subject;
use App\Models\Traits\Method\ChapterMethod;
use App\Repositories\ChapterRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChapterController extends Controller
{

    protected $chapterRepository;

    public function __construct(ChapterRepository $chapterRepository)
    {
        $this->chapterRepository = $chapterRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ShowChapterRequest $request, Subject $subject)
    {
//        $tab_type = Subject::TAB_TYPES['chapters'];
//        return redirect()->route('admin.subject.show', [$subject, $tab_type]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ManageChapterRequest $request, Subject $subject)
    {
        return view('backend.subjects.chapters.create')
            ->withSubject($subject);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChapterRequest $request, Subject $subject)
    {
        $chapter = $this->chapterRepository->create(
            array_merge([
                'subject_id' => $subject->id],
                $request->only(['name', 'is_actived'])
            ));
        return redirect()->back()->withFlashSuccess(__('alerts.backend.subjects.chapters.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(ManageChapterRequest $request, Subject $subject)
    {
        $is_chapter = true;
        return view('backend.subjects.show')
            ->with('is_chapter', $is_chapter)
            ->withSubject($subject);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ManageChapterRequest $request, Subject $subject, Chapter $chapter)
    {
        return view('backend.subjects.chapters.edit')
            ->withChapter($chapter)
            ->withSubject($subject);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreChapterRequest $request, Subject $subject, Chapter $chapter)
    {
        $tab_type = Subject::TAB_TYPES['chapters'];
        $chapter->update(array_merge([
            'is_actived' => intval($request->is_actived)],
            $request->only(['name',]))
        );
        return redirect()->route('admin.subject.show', [$subject, $tab_type])
            ->withFlashSuccess(__('alerts.backend.subjects.chapters.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageChapterRequest $request, Subject $subject, Chapter $chapter)
    {
        $tab_type = Subject::TAB_TYPES['deleted_chapters'];
        $this->chapterRepository->deleteById($chapter->id);
        return redirect()->route('admin.subject.show', [$subject, $tab_type])
            ->withFlashSuccess(__('alerts.backend.subjects.chapters.deleted'));
    }
}
