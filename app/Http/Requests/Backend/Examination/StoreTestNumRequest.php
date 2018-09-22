<?php

namespace App\Http\Requests\Backend\Examination;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\GeneralException;

class StoreTestNumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isCurator();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'test_num' => 'required|numeric|min:1|max:100'
        ];
    }

    protected function failedAuthorization()
    {
        throw new GeneralException(__('exceptions.general.not_permission'));
    }
}
