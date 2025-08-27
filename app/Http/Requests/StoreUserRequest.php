<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
 public function rules(): array
    {
        return [
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users,email',
            'password'   => 'required|string|min:8|confirmed',
            'status'     => 'required|in:1,0',
            'roles_name' => 'required|array|min:1',
        ];
    }

    /**
     * Custom messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required'       => 'اسم المستخدم مطلوب.',
            'name.string'         => 'الاسم يجب أن يكون نص فقط.',
            'name.max'            => 'الاسم لا يجب أن يزيد عن 255 حرف.',

            'email.required'      => 'البريد الإلكتروني مطلوب.',
            'email.email'         => 'يجب إدخال بريد إلكتروني صحيح.',
            'email.unique'        => 'هذا البريد الإلكتروني مسجل بالفعل.',

            'password.required'   => 'كلمة المرور مطلوبة.',
            'password.min'        => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
            'password.confirmed'  => 'كلمة المرور غير متطابقة.',

            'status.required'     => 'الحالة مطلوبة.',
            'status.in'           => 'الحالة يجب أن تكون إما مفعلة أو غير مفعلة.',

            'roles_name.required' => 'يجب اختيار صلاحية واحدة على الأقل.',
            'roles_name.array'    => 'الصلاحيات يجب أن تكون في شكل مصفوفة.',
            'roles_name.min'      => 'اختر صلاحية واحدة على الأقل.',
        ];
    }
}
