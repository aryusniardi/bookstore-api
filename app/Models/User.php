<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'username', 'roles', 'address', 'city_id', 'province_id', 'phone', 'avatar','api_token', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateToken() {
        $this->api_token = Str::random(60);
        $this->save();
        return $this->api_token;
    }
}
