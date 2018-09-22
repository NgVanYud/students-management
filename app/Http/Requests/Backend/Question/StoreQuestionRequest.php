<?php

namespace App\Http\Requests\Backend\Question;

use App\Models\Chapter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use App\Exceptions\GeneralException;
use Illuminate\Validation\Rule;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $chapter = Chapter::where('slug', '=', $this->chapters)->first();
        $subject = $chapter->subject;
        return $this->user()->isValidQuizMaker($subject);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $chapter = Chapter::where('slug', '=', $this->chapters)->first();
        $content = $this->content;
        $action = Route::getCurrentRoute()->getActionMethod();
        if($action == "store") {
            return [
                'chapters' => 'required',
//                'content' => 'required|min:5|unique:questions,content',
                'content' => [
                    'required',
                    'min:5',
                    Rule::unique('questions')->where(function ($query) use($chapter, $content) {
                        return $query->where('chapter_id', $chapter->id)
                            ->where('content', $content);
                    }),
                ],
                'options.*' => 'required|min:1',
                "correct_options"    => "required|array|min:1",
                "correct_options.*"  => "required|string|distinct|size:1|in:".implode(",", array_keys(create_question_options(config('question.options_num')))),
            ];
        } elseif ($action == "update") {
            return [
//                'chapters' => 'required',
                'content' => 'required|min:5|unique:questions,content,'. $this->question->id,
                'options.*' => 'required|min:1',
                "correct_options"    => "required|array|min:1",
                "correct_options.*"  => "required|string|distinct|size:1|in:".implode(",", array_keys(create_question_options(config('question.options_num'))))
            ];
        }
        return [

        ];
    }

    protected function failedAuthorization()
    {
        throw new GeneralException(__('exceptions.general.not_permission'));
    }
}
