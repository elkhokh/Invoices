<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sections extends Model
{
    //protected $table = "sections"; // if name is not conventail
   //   protected $guarded; // add in all
    //   protected $fillable=['name']; //add in title and content just
    protected $fillable = [
        'section_name', 'description','created_by', 'created_at','updated_at'
    ];

    protected $casts = [
    //vip in api
    // 'created_at'=>'',
    ];
}
