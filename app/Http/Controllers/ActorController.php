<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActorCreateRequest;
use App\Http\Requests\ActorRequest;  // Включаем запрос на валидацию
use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    // Получение списка всех актеров
    public function index()
    {
        $actors = Actor::all();
        return response()->json($actors);
    }

    // Получение информации о конкретном актере
    public function show($id)
    {
        $actor = Actor::find($id);

        if (!$actor) {
            return response()->json(['message' => 'Актер не найден.'], 404);
        }

        return response()->json($actor);
    }

    // Добавление нового актера
    public function store(ActorCreateRequest $request)
    {
        $data = $request->validated();

        // Проверяем наличие файла изображения
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('actors/photos', 'public');
        }

        $actor = Actor::create($data);

        return response()->json(['message' => 'Актер успешно добавлен.', 'actor' => $actor], 201);
    }

    // Обновление информации об актере
    public function update(ActorRequest $request, $id)
    {
        $actor = Actor::find($id);

        if (!$actor) {
            return response()->json(['message' => 'Актер не найден.'], 404);
        }

        $data = $request->validated();

        // Проверяем наличие нового файла изображения
        if ($request->hasFile('photo')) {
            // Удаляем старый файл, если он существует
            if ($actor->photo) {
                \Storage::disk('public')->delete($actor->photo);
            }

            // Сохраняем новое изображение
            $data['photo'] = $request->file('photo')->store('actors/photos', 'public');
        }

        $actor->update($data);

        return response()->json(['message' => 'Актер успешно обновлен.', 'actor' => $actor]);
    }

    // Удаление актера
    public function destroy($id)
    {
        $actor = Actor::find($id);

        if (!$actor) {
            return response()->json(['message' => 'Актер не найден.'], 404);
        }

        // Удаляем файл изображения, если он существует
        if ($actor->photo) {
            \Storage::disk('public')->delete($actor->photo);
        }

        $actor->delete();

        return response()->json(['message' => 'Актер успешно удален.']);
    }
}
