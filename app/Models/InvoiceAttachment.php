<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceAttachment extends Model
{
    // protected $guarded;
            protected $fillable = [
                'file_name',
                'invoice_number',
                'invoice_id' ,
                'created_by',
    ];

    public function invoice(){
    return $this->belongsTo(invoices::class);
    }
}
