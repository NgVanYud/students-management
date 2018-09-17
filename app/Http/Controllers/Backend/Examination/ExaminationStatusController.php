<?php

namespace App\Http\Controllers\Backend\Examination;

use App\Http\Requests\Backend\Examination\ManageExaminationRequest;
use App\Models\Examination;
use App\Repositories\Backend\ExaminationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExaminationStatusController extends Controller
{
    protected $examinationRepository;

    public function __construct(ExaminationRepository $examinationRepository)
    {
        $this->examinationRepository = $examinationRepository;
    }


    public function active(ManageExaminationRequest $request, Examination $examination)
    {
        $this->examinationRepository->active($examination);
        return redirect()->back()->withFlashSuccess(__('alerts.backend.examinations.actived'));
    }

    public function inactive(ManageExaminationRequest $request, Examination $examination)
    {
        $this->examinationRepository->inactive($examination);
        return redirect()->back()->withFlashSuccess(__('alerts.backend.examinations.inactived'));
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
