<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActorRequest extends FormRequest
{
    // Проверка прав доступа для этого запроса
    public function authorize()
    {
        // Вернуть true, если запрос разрешен для всех пользователей
        return true;
    }

    // Определение правил валидации
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255', // Имя актера обязательно
            'last_name' => 'required|string|max:255',  // Фамилия актера обязательна
            'birth_date' => 'nullable|date',           // Дата рождения может быть пустой и должна быть в формате даты
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Фото может быть пустым, если оно есть, то должно быть изображением
            'biography' => 'nullable|string',          // Биография может быть пустой
        ];
    }

    // Сообщения об ошибках
    public function messages()
    {
        return [
            'first_name.required' => 'Имя актера обязательно для заполнения.',
            'last_name.required' => 'Фамилия актера обязательна для заполнения.',
            'first_name.string' => 'Имя актера должно быть строкой.',
            'last_name.string' => 'Фамилия актера должна быть строкой.',
            'first_name.max' => 'Имя актера не должно превышать 255 символов.',
            'last_name.max' => 'Фамилия актера не должна превышать 255 символов.',
            'birth_date.date' => 'Дата рождения должна быть в формате даты.',
            'photo.image' => 'Фото должно быть изображением.',
            'photo.mimes' => 'Фото должно быть одного из следующих форматов: jpeg, png, jpg, gif.',
        ];
    }
}
