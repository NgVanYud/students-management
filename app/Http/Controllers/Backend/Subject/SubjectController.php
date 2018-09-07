<?php

namespace App\Http\Controllers\Backend\Subject;

use App\Http\Requests\Backend\Subject\StoreSubjectRequest;
use App\Models\Subject;
use App\Repositories\Backend\SubjectRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Subject\ManageSubjectRequest;
use Illuminate\Support\Facades\Route;

class SubjectController extends Controller
{
    protected $subjectRepository;

    public function  __construct(SubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    public function index() {
        return view('backend.subjects.index')
            ->withSubjects($this->subjectRepository
                ->orderBy('name', 'asc')
                ->paginate(25));
    }

    public function create(ManageSubjectRequest $request) {
        return view('backend.subjects.create');
    }

    public function store(StoreSubjectRequest $request) {
        $this->subjectRepository->create($request->only('name', 'abbreviation', 'credit'));

        return redirect()->route('admin.subject.index')->withFlashSuccess(__('alerts.backend.subjects.created'));
    }

    public function show() {

    }

    public function destroy(ManageSubjectRequest $request, Subject $subject) {
        $this->subjectRepository->deleteById($subject->id);

        return redirect()->route('admin.subject.deleted')->withFlashSuccess(__('alerts.backend.subjects.deleted'));
    }

    public function edit(Subject $subject) {
        return view('backend.subjects.edit')
            ->withSubject($subject);
    }

    public function update(StoreSubjectRequest $request, Subject $subject) {
        $subject->update($request->only(['name', 'credit', 'abbreviation']));
        return redirect()->route('admin.subject.index')->withFlashSuccess(__('alerts.backend.subjects.updated'));
    }
}
