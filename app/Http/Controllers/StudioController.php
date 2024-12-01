<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use App\Http\Requests\StudioRequest;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    /**
     * Получить список всех студий
     */
    public function index() {
        $studios = Studio::with('movies')->get(); // Загружаем также связанные фильмы
        return response()->json($studios, 200);
    }

    /**
     * Показать конкретную студию
     */
    public function show($id) {
        $studio = Studio::with('movies')->find($id); // Загружаем связанные фильмы
        return $studio ? response()->json($studio, 200) : response()->json(['message' => 'Студия не найдена'], 404);
    }

    /**
     * Создать новую студию
     */
    public function store(StudioRequest $request) {
        $studio = Studio::create($request->validated());
        return response()->json(['message' => 'Студия успешно создана', 'studio' => $studio], 201);
    }

    /**
     * Обновить существующую студию
     */
    public function update(StudioRequest $request, $id) {
        $studio = Studio::find($id);

        if (!$studio) {
            return response()->json(['message' => 'Студия не найдена'], 404);
        }

        $studio->update($request->validated());
        return response()->json(['message' => 'Студия успешно обновлена', 'studio' => $studio], 200);
    }

    /**
     * Удалить студию
     */
    public function destroy($id) {
        $studio = Studio::find($id);

        if (!$studio) {
            return response()->json(['message' => 'Студия не найдена'], 404);
        }

        $studio->delete();
        return response()->json(['message' => 'Студия успешно удалена'], 200);
    }
}
