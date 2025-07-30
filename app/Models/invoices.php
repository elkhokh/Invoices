<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invoices extends Model
{
    use HasFactory;
        protected $fillable = [
        // 'section_name', 'description','created_by', 'created_at','updated_at'
    ];

    protected $casts = [
    //vip in api
    // 'created_at'=>'',
    ];
}
