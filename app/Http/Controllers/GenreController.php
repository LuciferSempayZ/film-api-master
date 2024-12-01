<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Http\Requests\GenreRequest;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Получить список всех жанров
     */
    public function index() {
        $genres = Genre::with('movies')->get();
        return response()->json($genres, 200);
    }

    /**
     * Показать конкретный жанр
     */
    public function show($id) {
        $genre = Genre::with('movies')->find($id);

        return $genre
            ? response()->json($genre, 200)
            : response()->json(['message' => 'Жанр не найден'], 404);
    }

    /**
     * Создать новый жанр
     */
    public function store(GenreRequest $request) {
        $data = $request->validated();
        $genre = Genre::create($data);

        return response()->json(['message' => 'Жанр успешно добавлен', 'genre' => $genre], 201);
    }

    /**
     * Обновить существующий жанр
     */
    public function update(GenreRequest $request, $id) {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json(['message' => 'Жанр не найден'], 404);
        }

        $genre->update($request->validated());

        return response()->json(['message' => 'Жанр успешно обновлен', 'genre' => $genre], 200);
    }

    /**
     * Удалить жанр
     */
    public function destroy($id) {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json(['message' => 'Жанр не найден'], 404);
        }

        $genre->delete();
        return response()->json(['message' => 'Жанр успешно удален'], 200);
    }
}
