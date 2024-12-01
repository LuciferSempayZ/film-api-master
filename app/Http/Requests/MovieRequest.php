<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'release_year' => 'required|integer|min:1888|max:' . date('Y'),
            'duration' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'studio_id' => 'required|exists:studios,id',
            'age_rating_id' => 'required|exists:age_rating,id',
            'actors' => 'nullable|array',
            'actors.*' => 'exists:actors,id',
        ];
    }

    public function messages() {
        return [
            'title.required' => 'Название фильма обязательно.',
            'title.string' => 'Название фильма должно быть строкой.',
            'title.max' => 'Название фильма не должно превышать :max символов.',
            'release_year.required' => 'Год выпуска обязателен.',
            'release_year.integer' => 'Год выпуска должен быть числом.',
            'release_year.min' => 'Год выпуска должен быть не меньше :min.',
            'release_year.max' => 'Год выпуска не может быть больше текущего года.',
            'duration.required' => 'Продолжительность фильма обязательна.',
            'duration.integer' => 'Продолжительность фильма должна быть числом.',
            'duration.min' => 'Продолжительность фильма должна быть не менее :min минут.',
            'photo.image' => 'Загруженный файл должен быть изображением.',
            'photo.max' => 'Размер изображения не должен превышать :max килобайт.',
            'studio_id.required' => 'ID студии обязателен.',
            'studio_id.exists' => 'Указанная студия не найдена.',
            'age_rating_id.required' => 'Возрастной рейтинг обязателен.',
            'age_rating_id.exists' => 'Указанный возрастной рейтинг не найден.',
            'actors.array' => 'Актеры должны быть массивом.',
            'actors.*.exists' => 'Указанный актер не найден.',
        ];
    }
}
