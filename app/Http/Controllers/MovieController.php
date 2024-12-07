<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Movie;
use App\Http\Requests\MovieRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    /**
     * Получить список всех фильмов
     */
    public function index() {
        $movies = Movie::with(['genres', 'actors', 'studio', 'ageRating', 'rating'])->get();
        return response()->json($movies, 200);
    }

    /**
     * Показать конкретный фильм
     */
    public function show($id) {
        $movie = Movie::with(['genres', 'actors', 'studio', 'ageRating', 'rating'])->find($id);

        return $movie
            ? response()->json($movie, 200)
            : response()->json(['message' => 'Фильм не найден'], 404);
    }

    /**
     * Создать новый фильм
     */
    public function store(MovieRequest $request)
    {
        $data = $request->validated();
// Проверяем наличие файла изображения
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('movies/photos', 'public');
        }

        $movie = Movie::create($data);

        return response()->json(['message' => 'Фильм успешно добавлен.', 'movie' => $movie], 201);
    }
    /**
     * Обновить существующий фильм
     */
    public function update(Request $request, $id)
    {
        // Найти фильм по ID
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Фильм не найден'], 404);
        }

        // Получить все данные из запроса
        $data = $request->all();

        // Если передан файл изображения, обработать его
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('movies/photos', 'public');
        }

        // Обновление данных фильма
        $movie->update($data);

        // Обновление жанров, если переданы
        if ($request->has('genres')) {
            $movie->genres()->sync($request->input('genres'));
        }

        // Обновление актёров, если переданы
        if ($request->has('actors')) {
            $movie->actors()->sync($request->input('actors'));
        }

        return response()->json([
            'message' => 'Фильм успешно обновлён',
            'movie' => $movie->load(['genres', 'actors', 'studio', 'ageRating', 'rating']),
        ], 200);
    }


    /**
     * Удалить фильм
     */
    public function destroy($id) {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Фильм не найден'], 404);
        }

        $movie->delete();
        return response()->json(['message' => 'Фильм успешно удален'], 200);
    }
    /**
     * Добавление в избранное
     */
    public function addToFavorites($id)
    {
        $user = auth()->user();

        // Проверяем, есть ли фильм уже в избранном
        $exists = DB::table('favorites')
            ->where('users_id', $user->id)
            ->where('movies_id', $id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Movie is already in favorites'], 400);
        }

        // Добавляем фильм в избранное
        DB::table('favorites')->insert([
            'users_id' => $user->id,
            'movies_id' => $id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Movie added to favorites'], 200);
    }

    public function favorites(Request $request)
    {
        $user = $request->user();

        // Проверяем наличие данных
        $favorites = Favorite::where('users_id', $user->id)
            ->with('movie') // Загружаем связанные фильмы
            ->get();

        // Если избранное пустое
        if ($favorites->isEmpty()) {
            return response()->json(['message' => 'Нет избранных фильмов'], 404);
        }

        // Возвращаем список фильмов
        return response()->json($favorites->pluck('movie'), 200);
    }
    /**
     * Удаление из избранного
     */
    public function removeFromFavorites($id)
    {
        $user = auth()->user();

        // Проверяем, есть ли фильм в избранном
        $exists = DB::table('favorites')
            ->where('users_id', $user->id)
            ->where('movies_id', $id)
            ->exists();

        if (!$exists) {
            return response()->json(['message' => 'Movie not found in favorites'], 404);
        }

        // Удаляем фильм из избранного
        DB::table('favorites')
            ->where('users_id', $user->id)
            ->where('movies_id', $id)
            ->delete();

        return response()->json(['message' => 'Movie removed from favorites'], 200);
    }
}
