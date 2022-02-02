<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    const ADMIN   = 0b1111111111;
    const USER    = 0b0000000001;
    const CLIENT  = 0b0000000010;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'avatar',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'role' => 'integer',
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin(): bool
    {
      return ($this->role and ADMIN) == ADMIN;
    }

    public function isUser(): bool
    {
      return ($this->role and USER) == USER;
    }

    public function isClient(): bool
    {
      return ($this->role and CLIENT) == CLIENT;
    }

    public function messages()
    {
      return $this->hasMany(Message::class);
    }
}
