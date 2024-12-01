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
    public function store(RatingRequest $request) {
        $rating = Rating::create($request->validated());
        return response()->json(['message' => 'Отзыв успешно добавлен', 'rating' => $rating], 201);
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
