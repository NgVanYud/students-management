<?php

namespace App\Http\Requests\Backend\Subject;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\GeneralException;

class ManageChapterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $subject = $this->subject;
        return $this->user()->isValidQuizMaker($subject);
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
