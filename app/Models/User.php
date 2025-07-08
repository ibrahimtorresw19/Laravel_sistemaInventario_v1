<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'code_verification',
        'code_expiration',
        'is_verified',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'code_verification',
        'code_expiration'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'code_expiration' => 'datetime'
    ];
                            
    public function getCodeVerification()
    {
        $this->code_verification = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->code_expiration = now()->addMinutes(30);
        $this->save();
        return $this->code_verification;
    }

    public function isCodeExpired()
    {
        return now()->gt($this->code_expiration);
    }

    // app/Models/User.php
public function categorias()
{
    return $this->hasMany(Categorias::class);
}

public function almacenes()
{
    return $this->hasMany(Almacen::class);
}
}