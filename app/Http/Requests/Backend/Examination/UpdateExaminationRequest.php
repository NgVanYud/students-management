<?php

namespace App\Http\Requests\Backend\Examination;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use App\Exceptions\GeneralException;

class UpdateExaminationRequest extends FormRequest
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
        if(Request::is('*examination/*/edit/general-info*') && $_SERVER['REQUEST_METHOD'] == 'POST') {
            return [
                'name' => 'required|min:2|max:191|unique:examinations,name,' . $this->examination->id,
                'code' => 'required|min:2|max:25|unique:examinations,code,' . $this->examination->id,
                'subject' => 'required',
                'begin_date' => 'required|date|after:today',
                'begin_time' => 'required',
            ];
        } else if(Request::is('*examination/*/edit/proctor*') && $_SERVER['REQUEST_METHOD'] == 'POST') {
            return [
                'proctors_file' => 'required|max:50000'
            ];
        } else if(Request::is('*examination/*/edit/student*') && $_SERVER['REQUEST_METHOD'] == 'POST') {
            return [
                'students_file' => 'required|max:50000'
            ];
        }
    }

    protected function failedAuthorization()
    {
        throw new GeneralException(__('exceptions.general.not_permission'));
    }
}
