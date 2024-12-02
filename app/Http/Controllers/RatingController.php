<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Http\Requests\RatingRequest;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Получить список всех отзывов
     */
    public function index() {
        $ratings = Rating::with(['movie', 'user'])->get(); // Загружаем связанные фильмы и пользователей
        return response()->json($ratings, 200);
    }

    /**
     * Показать конкретный отзыв
     */
    public function show($id) {
        $rating = Rating::with(['movie', 'user'])->find($id);

        return $rating
            ? response()->json($rating, 200)
            : response()->json(['message' => 'Отзыв не найден'], 404);
    }

    /**
     * Создать новый отзыв
     */
    public function addRating(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'movies_id' => 'required|exists:movies,id',
            'rating' => 'required|numeric|min:0|max:5',
            'review_text' => 'nullable|string|max:1000', // Отзыв не обязателен, максимум 1000 символов
        ]);

        // Получение текущего пользователя
        $user = $request->user();

        // Создание или обновление рейтинга
        $rating = Rating::updateOrCreate(
            ['movies_id' => $validated['movies_id'], 'users_id' => $user->id],
            [
                'rating' => $validated['rating'],
                'review_text' => $validated['review_text'] ?? null, // Сохраняем отзыв, если он предоставлен
            ]
        );

        return response()->json([
            'message' => 'Рейтинг и отзыв успешно добавлены',
            'rating' => $rating,
        ], 200);
    }
    /**
     * Удалить отзыв
     */
    public function deleteRating(Request $request)
    {
        $validated = $request->validate([
            'movies_id' => 'required|exists:movies,id',
        ]);

        // Получение текущего пользователя
        $user = $request->user();

        // Попытка найти и удалить рейтинг
        $rating = Rating::where('movies_id', $validated['movies_id'])
            ->where('users_id', $user->id)
            ->first();

        if (!$rating) {
            return response()->json([
                'message' => 'Рейтинг или отзыв не найден',
            ], 404);
        }

        $rating->delete();

        return response()->json([
            'message' => 'Рейтинг и отзыв успешно удалены',
        ], 200);
    }
    /**
     * Обновить существующий отзыв
     */
    public function update(RatingRequest $request, $id) {
        $rating = Rating::find($id);

        if (!$rating) {
            return response()->json(['message' => 'Отзыв не найден'], 404);
        }

        $rating->update($request->validated());
        return response()->json(['message' => 'Отзыв успешно обновлен', 'rating' => $rating], 200);
    }

    /**
     * Удалить отзыв
     */
    public function destroy($id) {
        $rating = Rating::find($id);

        if (!$rating) {
            return response()->json(['message' => 'Отзыв не найден'], 404);
        }

        $rating->delete();
        return response()->json(['message' => 'Отзыв успешно удален'], 200);
    }
}
