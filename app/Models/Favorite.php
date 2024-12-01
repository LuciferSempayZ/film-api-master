<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    // Указываем таблицу, если она отличается от стандартного наименования
    protected $table = 'favorites';

    // Указываем поля, которые могут заполняться через массовое присваивание
    protected $fillable = [
        'users_id',
        'movies_id',
    ];

    // Определяем связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Определяем связь с фильмом
    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movies_id');
    }
}
