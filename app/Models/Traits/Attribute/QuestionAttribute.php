<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/13/2018
 * Time: 2:43 PM
 */

namespace App\Models\Traits\Attribute;


trait QuestionAttribute
{
    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="' . route('admin.chapter.question.edit', [$this->chapter, $this]) . '" class="btn btn-primary"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.edit') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="' . route('admin.chapter.question.destroy', [$this->chapter, $this]) . '"
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

    public function getActivedLabelAttribute()
    {
        if ($this->isActived()) {
            return '<a href="' . route('admin.question.inactive', $this )
                . '" data-toggle="tooltip" data-placement="top" title="'
                . __('buttons.backend.questions.inactive')
                . '" name="confirm_item"><span class="badge badge-success" style="cursor:pointer">'
                . __('labels.general.yes') . '</span></a>';

        }

        return '<a href="' . route('admin.question.active', $this)
            . '" data-toggle="tooltip" data-placement="top" title="'
            . __('buttons.backend.questions.active')
            . '" name="confirm_item"><span class="badge badge-danger" style="cursor:pointer">'
            . __('labels.general.no') . '</span></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {

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
                ' . $this->delete_button . '
                </div>
              </div>
			</div>';
    }
}