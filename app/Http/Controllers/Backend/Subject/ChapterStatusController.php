<?php

namespace App\Http\Controllers\Backend\Subject;

use App\Http\Requests\Backend\Subject\ManageChapterRequest;
use App\Models\Chapter;
use App\Models\Subject;
use App\Repositories\ChapterRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\SubjectRepository;

class ChapterStatusController extends Controller
{
    protected $subjectRepository;
    protected $chapterRepository;

    /**
     * SubjectStatusController constructor.
     * @param $subjectRepository
     */
    public function __construct(ChapterRepository $chapterRepository, SubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
        $this->chapterRepository = $chapterRepository;
    }

    public function active(ManageChapterRequest $request, Subject $subject, Chapter $chapter) {
        $this->chapterRepository->active($subject, $chapter);
        return redirect()->back()->withFlashSuccess(__('alerts.backend.subjects.chapters.actived'));
    }

    public function inactive(ManageChapterRequest $request, Subject $subject, Chapter $chapter) {
        $this->chapterRepository->inactive($subject, $chapter);
        return redirect()->back()->withFlashSuccess(__('alerts.backend.subjects.chapters.inactived'));
    }
//
//    /**
//     * @param ManageUserRequest $request
//     *
//     * @return mixed
//     */
//    public function getDeactivated(ManageSubjectRequest $request)
//    {
//        return view('backend.auth.user.deactivated')
//            ->withUsers($this->userRepository->getInactivePaginated(25, 'id', 'asc'));
//    }
//
//    /**
//     * @param ManageUserRequest $request
//     *
//     * @return mixed
//     */
//    public function getDeleted(ManageSubjectRequest $request)
//    {
//        return view('backend.subjects.deleted')
//            ->withSubjects($this->subjectRepository->getDeletedPaginated(25, 'deleted_at', 'desc'));
//    }
//
//    public function delete(ManageSubjectRequest $request, Subject $deletedSubject)
//    {
//        dd('xu ly sau');
//        $this->subjectRepository->forceDelete($deletedSubject);
//
//        return redirect()->route('admin.subject.deleted')
//            ->withFlashSuccess(__('alerts.backend.subjects.deleted_permanently'));
//    }
//
    public function restore(ManageChapterRequest $request, Subject $subject, Chapter $chapter)
    {
        $tab_type = Subject::TAB_TYPES['chapters'];
        $this->chapterRepository->restore($subject, $chapter);
        return redirect()->route('admin.subject.show', [$subject, $tab_type])
            ->withFlashSuccess(__('alerts.backend.subjects.chapters.restored'));
    }
}
