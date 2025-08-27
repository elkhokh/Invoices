<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invoices extends Model
{
    use HasFactory , SoftDeletes ; 
        protected $fillable = [
            'invoice_number',
            'invoice_date',
            'due_date',
            'section_id' ,
            'product'    ,
            'amount_collection',
            'amount_commission',
            'discount'      ,
            'rate_vat'   ,
            'value_vat',
            'total'  ,
            'note' ,
            'status',
            'value_status',
            'user_id',
            'payment_date',
    ];
    // protected $guarded =[] ;
    protected $casts = [
    // 'created_at'=>'',
    ];

    public function section(){
        return $this->belongsTo(sections::class);
    }

    public function invoiceAttachment(){
        return $this->hasMany(InvoiceAttachment::class,'invoice_id');
    }
    public function invoiceDetail(){
        return $this->hasMany(InvoiceDetail::class,'invoice_id');
    }
}
