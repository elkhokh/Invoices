<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $fillable = [
        'Product_name' ,'section_id', 'description','created_by', 'created_at','updated_at'
    ];

    protected $casts = [
    //vip in api
    // 'created_at'=>'',
    ];

    public function section()
{
    return $this->belongsTo(sections::class);
}

}
