<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionRequest extends FormRequest
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
            'name'=>'required'
        ];
        /*return [
            'name' => [
                'required',
                Rule::unique('permissions')->ignore($this->permission,'id'),
            ],
            'display_name'=> 'required',
        ];*/
    }

    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب'
        ];
        /*return [
            'display_name.required' => 'الاسم للعرض مطلوب',
            'name.unique' => 'اسم الصلاحية موجودة مسبقا'
        ];*/
    }
}
