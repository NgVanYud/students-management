<?php

namespace App\Http\Controllers\Backend\Subject;

use App\Repositories\Backend\SubjectRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Subject\ManageSubjectRequest;
use App\Models\Subject;
use Illuminate\Support\Facades\Route;

class SubjectStatusController extends Controller
{
    protected $subjectRepository;

    /**
     * SubjectStatusController constructor.
     * @param $subjectRepository
     */
    public function __construct(SubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }


    public function active(ManageSubjectRequest $request, Subject $subject) {
        $this->subjectRepository->active($subject);
        return redirect()->back()->withFlashSuccess(__('alerts.backend.subjects.actived'));
    }

    public function inactive(ManageSubjectRequest $request, Subject $subject) {
        $this->subjectRepository->inactive($subject);
        return redirect()->back()->withFlashSuccess(__('alerts.backend.subjects.inactived'));
    }

    /**
     * @param ManageUserRequest $request
     *
     * @return mixed
     */
    public function getDeactivated(ManageSubjectRequest $request)
    {
        return view('backend.auth.user.deactivated')
            ->withUsers($this->userRepository->getInactivePaginated(25, 'id', 'asc'));
    }

    /**
     * @param ManageUserRequest $request
     *
     * @return mixed
     */
    public function getDeleted(ManageSubjectRequest $request)
    {
        return view('backend.subjects.deleted')
            ->withSubjects($this->subjectRepository->getDeletedPaginated(25, 'deleted_at', 'desc'));
    }

    public function delete(ManageSubjectRequest $request, Subject $deletedSubject)
    {
        dd('xu ly sau');
        $this->subjectRepository->forceDelete($deletedSubject);

        return redirect()->route('admin.subject.deleted')
            ->withFlashSuccess(__('alerts.backend.subjects.deleted_permanently'));
    }

    public function restore(ManageSubjectRequest $request, Subject $subject)
    {
        $this->subjectRepository->restore($subject);
        return redirect()->route('admin.subject.index')
            ->withFlashSuccess(__('alerts.backend.subjects.restored'));
    }
}
