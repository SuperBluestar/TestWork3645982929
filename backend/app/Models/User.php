<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// sanctum
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ADMIN     = 0b1111111111;
    const USER     = 0b0000000001;
    const EDITOR    = 0b0000000010;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Role
     */
    public function isAdmin(): bool
    {
        return ($this->role & User::ADMIN) == User::ADMIN;
    }

    public function isUser(): bool
    {
        return ($this->role & User::USER) == User::USER;
    }

    public function isEditor(): bool
    {
        return ($this->role & User::EDITOR) == User::EDITOR;
    }

    public function hasRole($role): bool
    {
        return ($this->role & $role) == $role;
    }
}
