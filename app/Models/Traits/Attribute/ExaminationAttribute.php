<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/17/2018
 * Time: 8:30 PM
 */

namespace App\Models\Traits\Attribute;


trait ExaminationAttribute
{
    public function getSetTestNumButtonAttribute() {
        return '<a href="' . route('admin.examination.create_test_num', $this) . '" class="btn btn-success"><i class="fas fa-list" data-toggle="tooltip" data-placement="top" title="' . __('buttons.backend.examinations.set_test_num') . '"></i></a>';
    }

    public function getFormatTestButtonAttribute() {
        return '<a href="' . route('admin.examination.format_test', $this) . '" class="btn btn-info"><i class="fas fa-file-word" data-toggle="tooltip" data-placement="top" title="' . __('buttons.backend.examinations.format_test') . '"></i></a>';
    }
    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="' . route('admin.examination.edit', $this) . '" class="btn btn-primary"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.edit') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="' . route('admin.examination.destroy', $this) . '"
                 data-method="delete"
                 data-trans-button-cancel="' . __('buttons.general.cancel') . '"
                 data-trans-button-confirm="' . __('buttons.general.crud.delete') . '"
                 data-trans-title="' . __('strings.backend.general.are_you_sure') . '"
                 class="btn btn-danger">' . '<i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.delete') . '"></i>' . '</a> ';
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
        return '<a href="' . route('admin.examination.restore', $this) . '" name="confirm_item" class="btn btn-info"><i class="fas fa-refresh" data-toggle="tooltip" data-placement="top" title="' . __('buttons.backend.subjects.restore_subject') . '"></i></a> ';
    }

    public function getShowButtonAttribute()
    {
        return '<a href="' . route('admin.examination.show', $this) . '" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.view') . '" class="btn btn-info"><i class="fas fa-eye"></i></a>';
    }

    public function getActivedLabelAttribute()
    {
        if ($this->isActived()) {
            return '<a href="' . route('admin.examination.inactive',
                    $this
                ) . '" data-toggle="tooltip" data-placement="top" title="' . __('buttons.backend.subjects.inactive') . '" name="confirm_item"><span class="badge badge-success" style="cursor:pointer">' . __('labels.general.yes') . '</span></a>';

        }

        return '<a href="' . route('admin.examination.active', $this) . '" data-toggle="tooltip" data-placement="top" title="' . __('buttons.backend.subjects.active') . '" name="confirm_item"><span class="badge badge-danger" style="cursor:pointer">' . __('labels.general.no') . '</span></a>';
    }

    public function getPublishedLabelAttribute()
    {
        if ($this->isReadyToPublish()) {
            return '<a href="' . route('admin.examination.publish',
                    $this
                ) . '" data-toggle="tooltip" data-placement="top" title="' . __('buttons.backend.examinations.publish') . '" name="confirm_item"><span class="badge badge-danger" style="cursor:pointer">' . __('labels.general.no') . '</span></a>';

        }

        return '';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {

        if ($this->trashed()) {
            return '
				<div class="btn-group" role="group" aria-label="Examination Actions">
				  ' . $this->restore_button . '
				  ' . $this->delete_permanently_button . '
				</div>';
        } else if($this->isFormatTest()) {
            return '<div class="btn-group btn-group-sm" role="group" aria-label="Examination Actions">
              ' . $this->show_button . '
			  ' . $this->edit_button . '
              ' . $this->format_test_button . '
              ' . $this->set_test_num_button . '
              ' . $this->delete_button . '
			</div>';
        } else {
            return '<div class="btn-group btn-group-sm" role="group" aria-label="Examination Actions">
              ' . $this->show_button . '
			  ' . $this->edit_button . '
              ' . $this->format_test_button . '
              ' . $this->delete_button . '
			</div>';
        }


    }

    public function getNumberProctorsAttribute() {
        return count($this->proctors);
    }
    public function getNumberStudentsAttribute() {
        return count($this->students);
    }

}