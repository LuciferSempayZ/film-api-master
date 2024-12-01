<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'rating';  // Указываем правильное имя таблицы

    protected $fillable = [
        'movies_id', 'rating', 'review_text', 'users_id',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movies_id'); // Указываем правильное имя внешнего ключа
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
