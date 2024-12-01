<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        return response()->json(User::all(), 200);
    }

    public function show($id) {
        $user = User::find($id);
        return $user ? response()->json($user, 200) : response()->json(['message' => 'User not found'], 404);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'roles_id' => 'nullable|exists:roles,id',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'avatar' => 'nullable|url',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $validated['password'] = Hash::make($validated['password']); // Хэшируем пароль
        $user = User::create($validated);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function update(Request $request, $id) {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'roles_id' => 'nullable|exists:roles,id',
            'username' => 'nullable|string|max:255|unique:users,username,' . $id,
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'avatar' => 'nullable|url',
            'gender' => 'nullable|in:male,female,other',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']); // Хэшируем пароль
        }

        $user->update($validated);

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }

    public function destroy($id) {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
