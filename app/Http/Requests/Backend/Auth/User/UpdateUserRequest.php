<?php

namespace App\Http\Requests\Backend\Auth\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateUserRequest.
 */
class UpdateUserRequest extends FormRequest
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
        return [
            'email' => 'required|email|max:191',
            'first_name'  => 'required|max:191',
            'last_name'  => 'required|max:191',
            'roles' => 'required|array',
            'username' => 'required|min:2|max:50|unique:users,username,'.$this->user->id,
            'gender' => 'required|digits_between:0,1',
            'identity' => 'required|min:5|max:20|unique:users,identity,'.$this->user->id,
            'birthday' => 'required|date',
        ];
    }
}
