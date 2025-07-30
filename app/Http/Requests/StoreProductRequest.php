<?php
// using form rquest
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'section_id' => 'required|exists:sections,id',
            'description'  => 'required|string',
            "Product_name" => ["required" , "string" , "max:100" , function($attribute,$value,$fail){
                // Closure-based Custom Validation Rule
                if(str_contains($value,"laravel")){
                    $fail(" $attribute  ميتفعش تضيف كلام فيه الكلمة دي");
                }
            }],
        ];
    }

    public function messages(): array
    {
        return [
        'Product_name.required' => 'اسم المنتج مطلوب',
        'section_id.required'   => 'اختيار القسم مطلوب',
        'section_id.exists'     => 'القسم غير موجود في قاعدة البيانات',
        'description.required'  => 'الوصف مطلوب',
    ];
    }
}
