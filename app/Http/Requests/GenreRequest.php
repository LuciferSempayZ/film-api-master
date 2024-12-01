<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenreRequest extends FormRequest
{
    public function rules() {
        return [
            'name' => 'required|string|max:255|unique:genres,name',
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Название жанра обязательно.',
            'name.string' => 'Название жанра должно быть строкой.',
            'name.max' => 'Название жанра не должно превышать :max символов.',
            'name.unique' => 'Жанр с таким названием уже существует.',
        ];
    }
}
