<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class UserRequest extends FormRequest
{
    public function rules() {
        return [
            'roles_id' => 'nullable|exists:roles,id',
            'username' => 'required|string|max:255|unique:users,username,' . $this->route('id'),
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->route('id'),
            'password' => 'nullable|string|min:8',
            'avatar' => 'nullable|url',
            'gender' => 'nullable|in:male,female,other',
        ];
    }

    public function messages() {
        return [
            'roles_id.exists' => 'Указанная роль не найдена.',
            'username.required' => 'Имя пользователя обязательно.',
            'username.unique' => 'Имя пользователя уже занято.',
            'email.required' => 'Email обязателен.',
            'email.unique' => 'Этот email уже используется.',
            'password.min' => 'Пароль должен быть не менее 8 символов.',
            'avatar.url' => 'Аватар должен быть валидным URL.',
            'gender.in' => 'Пол должен быть male, female или other.',
        ];
    }
}

