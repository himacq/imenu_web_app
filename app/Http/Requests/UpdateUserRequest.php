<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        return [
            'name' => 'required|min:3',
            'password'=> 'nullable',
            'username' => [
                'required',
                    Rule::unique('users')->ignore($this->user,'id'),
                'min:5'
                ],
          //  'role'=> 'required'
        ];
    }

    public function messages()
    {
        return [
            'role.required' => 'الرجاء اختيار مجموعة للصلاحية'
        ];
    }
}
