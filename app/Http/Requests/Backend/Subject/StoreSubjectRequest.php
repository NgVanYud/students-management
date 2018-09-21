<?php

namespace App\Http\Requests\Backend\Subject;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use App\Exceptions\GeneralException;

class StoreSubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $action = Route::getCurrentRoute()->getActionMethod();
        if ($action == "store") {
            return [
                'name' => 'required|min:2|max:250|unique:subjects,name',
                'abbreviation' => 'required|min:2|max:10|unique:subjects,abbreviation',
                'credit' => 'required|numeric|min:1|max:15'
            ];
        } else if ($action == "update") {
            return [
                'name' => 'required|min:2|max:250|unique:subjects,name,' . $this->subject->id,
                'abbreviation' => 'required|min:2|max:10|unique:subjects,abbreviation,' . $this->subject->id,
                'credit' => 'required|numeric|min:1|max:15'
            ];
        }
    }

    protected function failedAuthorization()
    {
        throw new GeneralException(__('exceptions.general.not_permission'));
    }
}
