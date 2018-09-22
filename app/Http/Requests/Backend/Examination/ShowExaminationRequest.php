<?php

namespace App\Http\Requests\Backend\Examination;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\GeneralException;

class ShowExaminationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        $check = $user->isProctor() || $user->isQuizMaker() || $user->isCurator();
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
