<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required|string|min:3|max:255|regex:/^[a-zA-Z0-9_-]+$/|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:255|confirmed',
            'gender' => 'nullable|string|in:male,female,other',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Поле "Имя пользователя" обязательно для заполнения.',
            'username.string' => 'Поле "Имя пользователя" должно быть строкой.',
            'username.min' => 'Поле "Имя пользователя" должно содержать не менее :min символов.',
            'username.max' => 'Поле "Имя пользователя" должно содержать не более :max символов.',
            'username.regex' => 'Поле "Имя пользователя" может содержать только латинские буквы, цифры, дефисы и подчеркивания.',
            'username.unique' => 'Пользователь с таким именем уже существует.',

            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.string' => 'Поле "Email" должно быть строкой.',
            'email.email' => 'Поле "Email" должно быть действительным email адресом.',
            'email.max' => 'Поле "Email" должно содержать не более :max символов.',
            'email.unique' => 'Пользователь с таким email уже существует.',

            'password.required' => 'Поле "Пароль" обязательно для заполнения.',
            'password.string' => 'Поле "Пароль" должно быть строкой.',
            'password.min' => 'Поле "Пароль" должно содержать не менее :min символов.',
            'password.max' => 'Поле "Пароль" должно содержать не более :max символов.',
            'password.confirmed' => 'Пароли не совпадают.',

            'gender.string' => 'Поле "Пол" должно быть строкой.',
            'gender.in' => 'Поле "Пол" может быть только одним из следующих значений: male, female, other.',

            'avatar.image' => 'Поле "Аватар" должно быть изображением.',
            'avatar.mimes' => 'Поле "Аватар" должно быть в формате: jpeg, png, jpg, gif.',
            'avatar.max' => 'Размер файла "Аватар" не должен превышать 2048 Кб.',
        ];
    }
}
