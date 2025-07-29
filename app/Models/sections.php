<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sections extends Model
{
   //   protected $guarded; // add in all
    //   protected $fillable=['name']; //add in title and content just
    protected $fillable = [
        'section_name', 'description','created_by', 'created_at'
    ];

    protected $casts = [

    // 'created_at'=>'',
    ];
}
