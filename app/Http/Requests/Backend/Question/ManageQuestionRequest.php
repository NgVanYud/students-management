<?php

namespace App\Http\Requests\Backend\Question;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\GeneralException;

class ManageQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $chapter = $this->chapter;
        return $this->user()->isValidQuizMaker($chapter->subject);
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
