<?php

namespace App\Http\Controllers\Backend\Subject;

use App\Http\Controllers\Traits\ControllerTrait;
use App\Http\Requests\Backend\Subject\ShowSubjectRequest;
use App\Http\Requests\Backend\Subject\StoreSubjectRequest;
use App\Models\Subject;
use App\Repositories\Backend\SubjectRepository;
use App\Repositories\ChapterRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Subject\ManageSubjectRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator;

class SubjectController extends Controller
{
    use ControllerTrait;

    protected $subjectRepository;
    protected $chapterRepository;

    public function __construct(ChapterRepository $chapterRepository, SubjectRepository $subjectRepository)
    {
        $this->chapterRepository = $chapterRepository;
        $this->subjectRepository = $subjectRepository;
    }

    public function index(ShowSubjectRequest $request)
    {
        $user = Auth::user();
        /*
         * $user là giáo viên bộ môn hoặc là nguời ra đề
         */
        $subjects = $this->subjectRepository
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        if(!$user->isAdmin()) {
            $subjects = $this->paginate($user->subjects, 25)->setPath(Paginator::resolveCurrentPath());
        }
        return view('backend.subjects.index')
            ->with([
                'subjects' => $subjects
            ]);
    }

    public function create(ManageSubjectRequest $request)
    {
        return view('backend.subjects.create');
    }

    public function store(StoreSubjectRequest $request)
    {
        $this->subjectRepository->create($request->only('name', 'abbreviation', 'is_actived', 'credit'));
        return redirect()->route('admin.subject.index')
            ->withFlashSuccess(__('alerts.backend.subjects.created'));
    }

    public function show(ShowSubjectRequest $request, Subject $subject, $tab_type = null)
    {
        if(!(isset($tab_type) && in_array($tab_type, array_values(Subject::TAB_TYPES)))) {
            $tab_type = Subject::TAB_TYPES['subjects'];
        }
        $deleted_chapters = $this->chapterRepository
            ->getDeletedPaginatedByModelParent($subject,25, 'deleted_at', 'desc');
        return view('backend.subjects.show')
            ->with('tab_type', $tab_type)
            ->with('deleted_chapters', $deleted_chapters)
            ->withSubject($subject);
    }

    public function destroy(ManageSubjectRequest $request, Subject $subject)
    {
        $this->subjectRepository->deleteById($subject->id);
        return redirect()->route('admin.subject.deleted')
            ->withFlashSuccess(__('alerts.backend.subjects.deleted'));
    }

    public function edit(Subject $subject)
    {
        return view('backend.subjects.edit')
            ->withSubject($subject);
    }

    public function update(StoreSubjectRequest $request, Subject $subject)
    {
        $subject->update($request->only(['name', 'credit', 'abbreviation']));
        return redirect()->route('admin.subject.index')
            ->withFlashSuccess(__('alerts.backend.subjects.updated'));
    }
}
