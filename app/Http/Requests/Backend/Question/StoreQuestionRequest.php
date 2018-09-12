<?php

namespace App\Http\Requests\Backend\Question;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

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
                'content' => 'required|min:5|unique:questions,content',
                'options.*' => 'required|min:1',
                "correct_options"    => "required|array|min:1",
                "correct_options.*"  => "required|string|distinct|size:1|in:".implode(",", array_keys(create_question_options(config('question.options_num')))),
            ];
        } elseif ($action == "update") {
            return [
                'chapters' => 'required',
                'content' => 'required|min:20|unique:questions,content,'. $this->question->id,
                'options.*' => 'required|min:1',
                "correct_options"    => "required|array|min:1",
                "correct_options.*"  => "required|string|distinct|size:1|in:".implode(",", array_keys(create_question_options(config('question.options_num'))))
            ];
        }
        return [

        ];
    }
}
