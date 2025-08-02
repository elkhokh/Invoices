<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceDetailFactory> */
    use HasFactory;

    // protected $guarded ;
    protected $fillable = [
    'invoice_id' ,
    'invoice_number' ,
    'product'        ,
    'section'        ,
    'status'         ,
    'value_status'  ,
    'note'          ,
    'user'       ,

    ];

    public function invoice(){
        return $this->belongsTo(invoices::class);
    }
}

