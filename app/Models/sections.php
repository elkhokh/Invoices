<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class sections extends Model
{
    use HasFactory;
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

    public function Products()
    {
        return $this->hasMany(Product::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function invoices(){
        return $this->hasmany(invoices::class);
    }
}
