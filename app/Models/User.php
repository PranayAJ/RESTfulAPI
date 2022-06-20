<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    const VERIFIED_USER = 1;
    const UNVERIFIED_USER = 0;

    const ADMIN_USER = 1;
    const REGULAR_USER = 0;

    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isVerified(){
        return $this->verified = User::VERIFIED_USER;
    }
    public function isAdmin(){
        return $this->admin = User::ADMIN_USER;
    }
    public static function generateVerificationCode(){
        return Str::random(40);
    }

    /*Accessors*/
    public function getNameAttribute(){
        return ucwords($this->attributes['name']);

    }

    /*Mutators*/
    public function setNameAttribute($name){
        $this->attributes['name'] = strtolower($name);
    }
    public function setEmailAttribute($email){
        $this->attributes['email'] = strtolower($email);
    }
}
