<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPermissionRequest extends FormRequest
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
            'display_name'=> 'required',
        ];
    }

    public function messages()
    {
        return [
            'role.required' => trans('msg.roleRequired')
        ];
    }
}
