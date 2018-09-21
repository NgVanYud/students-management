<?php

namespace App\Http\Requests\Backend\Subject;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\GeneralException;

class ShowSubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $check = false;
        if(isset($this->subject)) {
            $subject = $this->subject;
            $check = $this->user()->isTeacherForSubject($subject) &&
                !$this->user()->isProctor() &&
                !$this->user()->isCurator() ||
                $this->user()->isAdmin();
        } else {
            $check = $this->user()->isTeacher() &&
                !$this->user()->isProctor() &&
                !$this->user()->isCurator() ||
                $this->user()->isAdmin();
        }
        return $check;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    protected function failedAuthorization()
    {
        throw new GeneralException(__('exceptions.general.not_permission'));
    }
}
