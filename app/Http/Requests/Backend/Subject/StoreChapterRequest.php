<?php

namespace App\Http\Requests\Backend\Subject;

use App\Exceptions\GeneralException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class StoreChapterRequest extends FormRequest
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
        $subject = $this->subject;
        $name = $this->name;
        $action = Route::getCurrentRoute()->getActionMethod();
        if($action == "store") {
            return [
                'name' => [
                    'required',
                    'min:5',
                    'max:191',
                    Rule::unique('chapters')->where(function ($query) use($subject, $name) {
                        return $query->where('subject_id', $subject->id)
                            ->where('name', $name);
                    }),
                ]
            ];
        } else if($action == "update") {
            return [
                'name' => 'required|min:5|max:191|unique:chapters,name,'.$this->chapter->id,
            ];
        }
        throw new GeneralException(__('exceptions.backend.subjects.chapters.validate_error'));
    }

    protected function failedAuthorization()
    {
        throw new GeneralException(__('exceptions.general.not_permission'));
    }
}
