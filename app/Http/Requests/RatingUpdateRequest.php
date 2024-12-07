<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingUpdateRequest extends FormRequest
{
    public function rules() {
        return [
            'movies_id' => 'nullable|exists:movies,id',
            'rating' => 'required|numeric|min:0|max:10|regex:/^\d(\.\d{1})?$/',  // Разрешаем числа с плавающей запятой до 1 знака после запятой
            'review_text' => 'nullable|string|max:1000',
        ];
    }

    public function messages() {
        return [
            'movies_id.exists' => 'Указанный фильм не найден.',
            'rating.required' => 'Рейтинг обязателен.',
            'rating.numeric' => 'Рейтинг должен быть числом.',
            'rating.min' => 'Рейтинг должен быть не меньше :min.',
            'rating.max' => 'Рейтинг должен быть не больше :max.',
            'rating.regex' => 'Рейтинг может быть числом с одной цифрой после запятой.',
            'review_text.string' => 'Отзыв должен быть строкой.',
            'review_text.max' => 'Отзыв не должен превышать :max символов.',
        ];
    }
}
