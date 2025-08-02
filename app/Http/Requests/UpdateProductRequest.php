<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'Product_name' => 'required|string',
            'description'  => 'required|string',
            'section_id'   => 'required|exists:sections,id',
        ];
    }

    public function messages(): array
    {
        return [
            'Product_name.required' => 'اسم المنتج مطلوب',
            'description.required'  => 'الوصف مطلوب',
            'section_id.required'   => 'القسم مطلوب',
            // 'section_id.exists'     => 'القسم غير موجود',
        ];
    }
}
