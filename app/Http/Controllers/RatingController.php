<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingUpdateRequest;
use App\Models\Rating;
use App\Http\Requests\RatingRequest;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Получить список всех отзывов
     */
    public function index()
    {
        $ratings = Rating::with(['movie', 'user'])->get(); // Загружаем связанные фильмы и пользователей
        return response()->json($ratings, 200);
    }

    /**
     * Показать конкретный отзыв
     */
    public function show($id)
    {
        $rating = Rating::with(['movie', 'user'])->find($id);

        return $rating
            ? response()->json($rating, 200)
            : response()->json(['message' => 'Отзыв не найден'], 404);
    }

    /**
     * Добавить новый отзыв
     */
    public function store(RatingRequest $request)
    {
        // Получаем аутентифицированного пользователя через токен
        $user = auth()->user();

        // Если пользователь не найден, возвращаем ошибку
        if (!$user) {
            return response()->json(['message' => 'Пользователь не авторизован.'], 401);
        }

        // Получаем данные из запроса после валидации
        $validated = $request->validated();


        // Добавляем текущего пользователя в данные отзыва
        $validated['users_id'] = $user->id;  // Используем users_id вместо user_id

        // Проверим данные перед созданием
        // dd($validated);  // Можно использовать для отладки, чтобы увидеть данные, если нужно

        // Создаем новый отзыв
        try {
            $rating = Rating::create($validated);  // Создание отзыва в базе
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ошибка при добавлении отзыва', 'error' => $e->getMessage()], 500);
        }

        return response()->json([
            'message' => 'Отзыв успешно добавлен.',
            'rating' => $rating,
        ], 201);
    }

    /**
     * Обновить существующий отзыв
     */
    public function update(RatingUpdateRequest $request, $id)
    {

        $validated = $request->validated();  // Получаем данные после валидации

        $rating = Rating::find($id);

        if (!$rating) {
            return response()->json(['message' => 'Отзыв не найден'], 404);
        }

        // Обновляем отзыв
        $rating->update($validated);

        return response()->json([
            'message' => 'Отзыв успешно обновлён.',
            'rating' => $rating,
        ], 200);
    }

    /**
     * Удалить отзыв
     */
    public function destroy($id)
    {
        $rating = Rating::find($id);

        if (!$rating) {
            return response()->json(['message' => 'Отзыв не найден'], 404);
        }

        $rating->delete();

        return response()->json(['message' => 'Отзыв успешно удалён.'], 200);
    }
}
