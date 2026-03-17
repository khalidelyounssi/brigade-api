<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'dietary_tags',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dietary_tags' => 'array',
        ];
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }

    public function plats()
    {
        return $this->hasMany(Plat::class);
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }
}