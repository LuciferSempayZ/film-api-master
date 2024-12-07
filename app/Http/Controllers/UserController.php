<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
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
        $user = $request->user();

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
    public function updateProfile(UserRequest $request)
    {
        $user = $request->user(); // Получаем текущего аутентифицированного пользователя

        $validated = $request->validated();

        // Обновление данных профиля
        if (isset($validated['username'])) {
            $user->username = $validated['username'];
        }

        if (isset($validated['email'])) {
            $user->email = $validated['email'];
        }

        if (isset($validated['gender'])) {
            $user->gender = $validated['gender'];
        }

        if (isset($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Обработка аватара
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatar', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        return response()->json([
            'message' => 'Профиль успешно обновлен',
            'user' => $user,
        ], 200);
    }
}
