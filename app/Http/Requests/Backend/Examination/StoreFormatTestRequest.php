<?php

namespace App\Http\Requests\Backend\Examination;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormatTestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $chapters = $this->examination->subject->chapters;
        $rules_arr = [];
        foreach ($chapters as $chapter) {
            $rules_arr[$chapter->slug] = 'required|numeric|min:0|max:200';
        }
        $rules_arr['timeout'] = 'required|numeric|min:15|max:300';
        return $rules_arr;
    }
}
