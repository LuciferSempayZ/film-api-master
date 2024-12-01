<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
{
    public function rules() {
        return [
            'movie_id' => 'required|exists:movies,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:10',
            'review_text' => 'nullable|string|max:1000',
        ];
    }

    public function messages() {
        return [
            'movie_id.required' => 'ID фильма обязателен.',
            'movie_id.exists' => 'Указанный фильм не найден.',
            'user_id.required' => 'ID пользователя обязателен.',
            'user_id.exists' => 'Указанный пользователь не найден.',
            'rating.required' => 'Рейтинг обязателен.',
            'rating.integer' => 'Рейтинг должен быть числом.',
            'rating.min' => 'Рейтинг должен быть не меньше :min.',
            'rating.max' => 'Рейтинг должен быть не больше :max.',
            'review_text.string' => 'Отзыв должен быть строкой.',
            'review_text.max' => 'Отзыв не должен превышать :max символов.',
        ];
    }
}
