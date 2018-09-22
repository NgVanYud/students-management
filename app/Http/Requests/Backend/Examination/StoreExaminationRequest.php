<?php

namespace App\Http\Requests\Backend\Examination;

use App\Models\Examination;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use App\Exceptions\GeneralException;

class StoreExaminationRequest extends FormRequest
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
        $name = $this->name;
        $temp_examp = new Examination();
        $begin_time = $temp_examp->setBeginTime($this->begin_date, $this->begin_time);
        if ($action == "store") {
            return [
                'name' => [
                    'required',
                    'min:2',
                    'max:191',
                    Rule::unique('examinations')->where(function ($query) use($name, $begin_time) {
                        return $query->where('name', $name)
                            ->where('begin_time', $begin_time);
                    }),
                ],
                'code' => 'required|min:2|max:25|unique:examinations,code',
                'subject' => 'required',
//                'begin_date' => 'required|date|after:today',
                'begin_date' => 'required|date',
                'begin_time' => 'required',
                'proctors_file' => 'required||max:50000',
                'students_file' => 'required|max:50000',
            ];
        }
    }

    protected function failedAuthorization()
    {
        throw new GeneralException(__('exceptions.general.not_permission'));
    }
}
