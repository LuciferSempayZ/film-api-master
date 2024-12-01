<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'release_year', 'duration', 'description', 'photo', 'studio_id', 'age_rating_id',
    ];

    public function Genre()
    {
        return $this->belongsToMany(Genre::class, 'movie_genres'); // Указываем промежуточную таблицу movie_genres
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'movie_actors', 'movie_id', 'actor_id');
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function AgeRating()
    {
        return $this->belongsTo(AgeRating::class, 'age_rating_id'); // Убедитесь, что поле называется age_rating_id
    }

    public function rating()
    {
        return $this->hasMany(Rating::class, 'movies_id'); // Указываем правильное имя внешнего ключа
    }
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }
}

