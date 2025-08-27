<?php

namespace App\Exports;

use App\Models\invoices;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    //     return invoices::all();

    // }
            return Invoices::select(
            // 'id',
            'invoice_number','invoice_date','due_date',
            'section_id','product','amount_collection',
            'amount_commission','discount','rate_vat',
            'value_vat','total','status','value_status',
            'user_id','created_at','updated_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            // 'ID',
            'Invoice Number','Invoice Date','Due Date',
            'Section','Product','Amount Collection',
            'Amount Commission','Discount','Rate VAT','Value VAT',
            'Total','Status','Value Status','User ID',
            'Created At','Updated At',
        ];
    }
}
