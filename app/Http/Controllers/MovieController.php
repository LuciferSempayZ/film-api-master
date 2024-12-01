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
    public function store(Request $request)
    {
        try {
            // Валидация запроса
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'release_year' => 'required|regex:/^\d{4}$/',
                'duration' => 'required|integer',
                'description' => 'required|string',
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'studio_id' => 'required|exists:studios,id',
                'age_rating_id' => 'required|exists:age_rating,id',
            ]);

            // Логирование всех данных запроса
            \Log::info('Request data:', $request->all());

            // Проверка, загружен ли файл
            if ($request->hasFile('photo')) {
                // Сохранение фото в storage/public/movies_photos
                $photoPath = $request->file('photo')->store('movies_photos', 'public');
                \Log::info('Photo uploaded successfully', ['path' => $photoPath]);
            } else {
                // Возвращаем ошибку, если фото не загружено
                return response()->json(['message' => 'No photo uploaded'], 422);
            }

            // Логирование данных, прошедших валидацию
            \Log::info('Validated Data:', $validated);

            // Создание нового фильма в базе данных
            $movie = Movie::create([
                'title' => $validated['title'],
                'release_year' => $validated['release_year'],
                'duration' => $validated['duration'],
                'description' => $validated['description'],
                'photo' => $photoPath,
                'studio_id' => $validated['studio_id'],
                'age_rating_id' => $validated['age_rating_id'],
            ]);

            // Проверка, что фильм был создан
            if ($movie) {
                \Log::info('Movie created successfully:', $movie->toArray());
                return response()->json($movie, 201);  // Возвращаем фильм с кодом 201 (создано)
            } else {
                \Log::error('Failed to create movie');
                return response()->json(['message' => 'Failed to create movie'], 500);  // Ошибка при создании фильма
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Обработка ошибок валидации
            \Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);  // Возвращаем ошибки валидации
        } catch (\Exception $e) {
            // Обработка всех других исключений
            \Log::error('Unexpected error occurred', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Unexpected error occurred', 'error' => $e->getMessage()], 500);  // Ошибка на сервере
        }
    }

    /**
     * Обновить существующий фильм
     */
    public function update(MovieRequest $request, $id) {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Фильм не найден'], 404);
        }

        $data = $request->validated();

        // Загрузка нового изображения, если предоставлено
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('movies', 'public');
        }

        $movie->update($data);

        // Обновление связей с жанрами и актерами
        if ($request->has('genres')) {
            $movie->genres()->sync($request->input('genres'));
        }

        if ($request->has('actors')) {
            $movie->actors()->sync($request->input('actors'));
        }

        return response()->json(['message' => 'Фильм успешно обновлен', 'movie' => $movie], 200);
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
