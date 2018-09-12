<?php

namespace App\Http\Requests\Backend\Question;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
        $action = Route::getCurrentRoute()->getActionMethod();
        if($action == "store") {
            return [
                'chapters' => 'required',
                'content' => 'required|min:20|unique:questions,content',
                'option1' => 'required|min:1',
                'option2' => 'required|min:1',
                'option3' => 'required|min:1',
                'option4' => 'required|min:1',
                'true_option' => 'required',
            ];
        } elseif ($action == "update") {
            return [
                'chapters' => 'required',
                'content' => 'required|min:20|unique:questions,content,'. $this->question->id,
                'option1' => 'required|min:1',
                'option2' => 'required|min:1',
                'option3' => 'required|min:1',
                'option4' => 'required|min:1',
                'true_option' => 'required',
            ];
        }
    }
}
