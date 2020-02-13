<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => 'required',
            'new_password' => 'required',
            'password_confirmation' => 'required|same:new_password'
        ];
    }

    public function messages()
    {
        return [
          'old_password.required' => 'كلمة المرور القديمة مطلوبة'  ,
            'new_password.required' => 'الرجاء كتابة كلمة المرور الجديدة',
            'password_confirmation.required' => 'الرجاء كتابة تأكيد كلمة المرور',
            'password_confirmation.same' => 'كلمة المرور غير متطابقة'
        ];
    }
}
