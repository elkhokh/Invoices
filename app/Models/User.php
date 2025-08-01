<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

        /**
     * Get the user's first name. accessor and mutator make by me
     */
    protected function Name(): Attribute
    {
        //strtolower() lcfirst() ucfirst() ucwords()
        return Attribute::make(
            get: fn (string $value) => ucfirst($value), // accessor
            set: fn (string $value) => lcfirst($value), // mutator
        );
    }
    //     public function profile(){
    //     //one to one relation
    //     // return $this->hasOne(Profile::class ,'user_id','id');//or if name conventional is false
    //     return $this->hasOne(Profile::class );
    // }
    public function sections(){
        //many to many relation
        return $this->hasMany(Sections::class);
    }
    // public function users(){
    //     //many to many relation
    //     return $this->hasMany(User::class);
    // }
}

