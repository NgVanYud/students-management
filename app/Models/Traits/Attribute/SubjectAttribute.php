<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/6/2018
 * Time: 11:19 PM
 */

namespace App\Models\Traits\Attribute;

use App\Models\Auth\User;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use function PHPSTORM_META\type;

trait SubjectAttribute
{
    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="' . route('admin.subject.edit', $this) . '" class="btn btn-primary"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.edit') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="' . route('admin.subject.destroy', $this) . '"
                 data-method="delete"
                 data-trans-button-cancel="' . __('buttons.general.cancel') . '"
                 data-trans-button-confirm="' . __('buttons.general.crud.delete') . '"
                 data-trans-title="' . __('strings.backend.general.are_you_sure') . '"
                 class="dropdown-item">' . __('buttons.general.crud.delete') . '</a> ';
    }

    /**
     * @return string
     */
    public function getDeletePermanentlyButtonAttribute()
    {
        return '<a href="' . route('admin.subject.delete-permanently', $this) . '" name="confirm_item" class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="' . __('buttons.backend.subjects.delete_permanently') . '"></i></a> ';
    }

    /**
     * @return string
     */
    public function getRestoreButtonAttribute()
    {
        return '<a href="' . route('admin.subject.restore', $this) . '" name="confirm_item" class="btn btn-info"><i class="fas fa-refresh" data-toggle="tooltip" data-placement="top" title="' . __('buttons.backend.subjects.restore_subject') . '"></i></a> ';
    }

    public function getShowButtonAttribute()
    {
        return '<a href="' . route('admin.subject.show', $this) . '" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.view') . '" class="btn btn-info"><i class="fas fa-eye"></i></a>';
    }

    public function getAddChapterButtonAttribute()
    {
        return '<a href="' . route('admin.subject.chapter.create', $this) . '" class="dropdown-item">' . __('buttons.backend.subjects.chapters.add') . '</a> ';
    }

    public function getActivedLabelAttribute()
    {
        if ($this->isActived()) {
            return '<a href="' . route('admin.subject.inactive',
                    $this
                ) . '" data-toggle="tooltip" data-placement="top" title="' . __('buttons.backend.subjects.inactive') . '" name="confirm_item"><span class="badge badge-success" style="cursor:pointer">' . __('labels.general.yes') . '</span></a>';

        }

        return '<a href="' . route('admin.subject.active', $this) . '" data-toggle="tooltip" data-placement="top" title="' . __('buttons.backend.subjects.active') . '" name="confirm_item"><span class="badge badge-danger" style="cursor:pointer">' . __('labels.general.no') . '</span></a>';
    }

    public function getLecturersListButtonAttribute() {
        return '<a href="' . route('admin.subject.show', [$this, Subject::TAB_TYPES['lecturers']]) . '"
                 class="dropdown-item">' . __('buttons.backend.subjects.lecturers.list') . '</a> ';
    }

    public function getAddLecturerButtonAttribute() {
        return '<a href="' . route('admin.subject.lecturer.create', $this) . '"
                 class="dropdown-item">' . __('buttons.backend.subjects.lecturers.add') . '</a> ';
    }
    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        $user = Auth::user();
        if(!$user->isAdmin()) {
            if($user->isValidQuizMaker($this)) {
                return '<div class="btn-group btn-group-sm" role="group" aria-label="Subject Actions">
              ' . $this->show_button . '
			  <div class="btn-group btn-group-sm" role="group">
                <button id="subjectActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  More
                </button>
                <div class="dropdown-menu" aria-labelledby="subjectActions">
                ' . $this->add_chapter_button . '
                </div>
              </div>
			</div>';
            } else if($user->isTeacherForSubject($this)) {
                return '<div class="btn-group btn-group-sm" role="group" aria-label="Subject Actions">
              ' . $this->show_button . '
			</div>';
            }
        } else {
            if ($this->trashed()) {
                return '
				<div class="btn-group" role="group" aria-label="Subject Actions">
				  ' . $this->restore_button . '
				  ' . $this->delete_permanently_button . '
				</div>';
            }
            return '<div class="btn-group btn-group-sm" role="group" aria-label="Subject Actions">
              ' . $this->show_button . '
			  ' . $this->edit_button . '
			  <div class="btn-group btn-group-sm" role="group">
                <button id="subjectActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  More
                </button>
                <div class="dropdown-menu" aria-labelledby="subjectActions">
                ' . $this->add_chapter_button . '
                ' . $this->lecturers_list_button . '
                ' . $this->add_lecturer_button . '
                ' . $this->delete_button . '
                </div>
              </div>
			</div>';
        }
        return '';
    }
}