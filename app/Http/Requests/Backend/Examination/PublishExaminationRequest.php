<?php

namespace App\Http\Requests\Backend\Examination;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Auth;

class PublishExaminationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $examination = $this->examination;
        $user = Auth::user();
        return $user->isProctorForExamination($examination);
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
