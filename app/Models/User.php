<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasFactory, HasApiTokens; // Подключаем оба трейта

    protected $fillable = [
        'roles_id', 'username', 'email', 'password', 'avatar', 'gender',
    ];
    // Устанавливаем значение по умолчанию для roles_id
    protected $attributes = [
        'roles_id' => 2, // Пользователь по умолчанию
    ];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Movie::class, 'favorites')->withTimestamps();
    }
}
