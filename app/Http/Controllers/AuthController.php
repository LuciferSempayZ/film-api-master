<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Регистрация нового пользователя
     */
    public function register(RegisterRequest $request)
    {

        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $data['roles_id'] = 2; // Роль по умолчанию

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create($data);

        return response()->json(['message' => 'Регистрация успешна.', 'user' => $user], 201);
    }

    /**
     * Вход пользователя в систему
     */
    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Неверные учетные данные.'], 401);
        }

        $user = Auth::user();

        return response()->json([
            'message' => 'Вы успешно вошли в систему.',
            'user' => $user,
            'token' => $user->createToken('authToken')->plainTextToken,
        ], 200);
    }


    /**
     * Выход пользователя из системы
     */
    public function logout(Request $request)
    {
        // Удалить текущий токен
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Выход выполнен успешно.'], 200);
    }
}
