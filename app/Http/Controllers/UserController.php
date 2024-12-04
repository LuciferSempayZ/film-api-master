<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Получить данные текущего пользователя
     */
    public function show(Request $request)
    {
        // Получаем аутентифицированного пользователя
        $user = $request->user();

        // Если пользователя нет (не аутентифицирован)
        if (!$user) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }

        return response()->json([
            'user' => $user,
        ], 200);
    }

    /**
     * Обновление профиля текущего пользователя.
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user(); // Получаем текущего аутентифицированного пользователя

        // Валидация данных
        $validated = $request->validate([
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,  // Уникальность username
            'email' => 'nullable|email|unique:users,email,' . $user->id,  // Уникальность email
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Аватар пользователя
            'gender' => 'nullable|string|in:male,female,other',  // Пол
            'password' => 'nullable|string|min:8|confirmed',  // Новый пароль
        ]);

        // Обновление данных профиля, если они предоставлены
        if ($request->has('username')) {
            $user->username = $validated['username'];
        }

        if ($request->has('email')) {
            $user->email = $validated['email'];
        }

        if ($request->has('gender')) {
            $user->gender = $validated['gender'];  // Обновление gender
        }

        if ($request->has('password')) {
            $user->password = Hash::make($validated['password']);  // Хэширование пароля
        }

        // Обработка аватара
        if ($request->hasFile('avatar')) {
            // Сохраняем аватар в public storage
            $avatarPath = $request->file('avatar')->store('avatar', 'public');
            $user->avatar = $avatarPath;
        }

        // Сохранение обновленных данных
        $user->save();

        // Возвращаем успешный ответ
        return response()->json([
            'message' => 'Профиль успешно обновлен',
            'user' => $user,
        ], 200);

    }
}
