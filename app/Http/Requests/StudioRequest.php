<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudioRequest extends FormRequest
{
    public function rules() {
        return [
            'name' => 'required|string|max:255|unique:studios,name,' . $this->route('studio'),
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Название студии обязательно для заполнения.',
            'name.string' => 'Название студии должно быть строкой.',
            'name.max' => 'Название студии не должно превышать :max символов.',
            'name.unique' => 'Студия с таким названием уже существует.',
        ];
    }
}
