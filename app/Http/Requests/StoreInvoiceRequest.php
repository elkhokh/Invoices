<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'invoice_number' => 'required|string|unique:invoices',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',//check due date
            'section_id' => 'required|exists:sections,id',
            'product' => 'required|string',
            'amount_collection' => 'required|numeric',
            'amount_commission' => 'required|numeric',
            'discount' => 'nullable|numeric|lte:amount_commission',
            'rate_vat' => 'required|numeric|in:5,10,15',
            'value_vat' => 'required|numeric',
            'total' => 'required|numeric', // is not required
            'note'       =>   'nullable|string', // is not required
            'file_name'  => 'nullable|file|mimes:jpg,jpeg,png|max:2048',

        ];
    }
    public function messages()
    {
        return [
            'invoice_number.required'   => 'رقم الفاتورة مطلوب',
            'invoice_number.unique'   => 'رقم الفاتورة موجود بالفعل',
            'invoice_date.required' => 'تاريخ الفاتورة مطلوب',
            'due_date.required'        => 'تاريخ الاستحقاق مطلوب',
            'due_date.after_or_equal'     => 'تاريخ الاستحقاق يجب أن يكون بعد أو يساوي تاريخ الفاتورة',
            'section_id.required'      => 'القسم مطلوب',
            'section_id.exists'         => 'القسم غير موجود',
            'product.required'         => 'اسم المنتج مطلوب',
            'amount_collection.required'  => 'مبلغ التحصيل مطلوب',
            'amount_collection.numeric'   => 'مبلغ التحصيل يجب أن يكون رقمًا',
            'amount_commission.required'   => 'مبلغ العمولة مطلوب',
            // 'amount_commission.lte'        => 'العمولة يجب أن تكون أقل من أو تساوي مبلغ التحصيل',
            'discount.numeric'      => 'الخصم يجب أن يكون رقمًا',
            'discount.lte' => 'الخصم لا يمكن أن يتجاوز مبلغ العمولة',
            'rate_vat.required'         => 'نسبة الضريبة مطلوبة',
            'rate_vat.in'             => 'نسبة الضريبة يجب أن تكون 5% أو 10% أو 15%',
            'value_vat.required'      => 'قيمة الضريبة مطلوبة',
            'total.required'        => 'الإجمالي مطلوب',
            'note.string'        => 'الملاحظات تكون كلام ',
            'file_name.mimes' => 'يجب أن يكون الملف من نوع jpg أو jpeg أو png أو pdf فقط',
            'file_name.max' => 'يجب ألا يتجاوز حجم الملف 2 ميجابايت',
            'file_name.file' => 'يجب اختيار ملف صالح',
        ];
    }
}
