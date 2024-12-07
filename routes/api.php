<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Авторизация
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Защищённые маршруты
Route::middleware('auth:sanctum')->group(function () {
    // Пользователи

// Получить данные текущего пользователя
    Route::get('/user', [UserController::class, 'show']);

// Обновить данные текущего пользователя
    Route::post('/user/profile', [UserController::class, 'updateProfile']);
    // Фильмы
    Route::post('/movies', [MovieController::class, 'store']);
    Route::post('/movies/update/{id}', [MovieController::class, 'update']);
    Route::delete('/movies/{id}', [MovieController::class, 'destroy']);
    Route::post('/movies/{id}/favorite', [MovieController::class, 'addToFavorites']); // Добавление в избранное
    Route::get('/movies/favorites', [MovieController::class, 'favorites']); // Просмотр избранного
    Route::delete('/movies/{id}/favorite', [MovieController::class, 'removeFromFavorites']);
    // Отзывы
    Route::post('/ratings', [RatingController::class, 'store']);  // Добавить новый отзыв
    Route::post('/ratings/{id}', [RatingController::class, 'update']);  // Обновить существующий отзыв
    Route::delete('/ratings/{id}', [RatingController::class, 'destroy']);  // Удалить отзыв
    // Актёры
    Route::post('/actors', [ActorController::class, 'store']);
    Route::post('/actors/update/{id}', [ActorController::class, 'update']);
    Route::delete('/actors/{id}', [ActorController::class, 'destroy']);
    // Студии
    Route::post('/studios', [StudioController::class, 'store']);
    Route::post('/studios/{id}', [StudioController::class, 'update']);
    Route::delete('/studios/{id}', [StudioController::class, 'destroy']);

    // Жанры
    Route::post('/genres', [GenreController::class, 'store']);
    Route::post('/genres/{id}', [GenreController::class, 'update']);
    Route::delete('/genres/{id}', [GenreController::class, 'destroy']);
});

// Публичные маршруты
Route::get('/movies', [MovieController::class, 'index']); // Просмотр всех фильмов
Route::get('/movies/{id}', [MovieController::class, 'show']); // Просмотр конкретного фильма
Route::get('/genres', [GenreController::class, 'index']); // Просмотр всех жанров
Route::get('/genres/{id}', [GenreController::class, 'show']); // Просмотр конкретного жанра
Route::get('/actors', [ActorController::class, 'index']); // Просмотр всех актёров
Route::get('/actors/{id}', [ActorController::class, 'show']); // Просмотр конкретного актёра
Route::get('/studios', [StudioController::class, 'index']); // Просмотр всех студий
Route::get('/studios/{id}', [StudioController::class, 'show']); // Просмотр конкретной студии
Route::get('/ratings', [RatingController::class, 'index']);          // Получить все отзывы
Route::get('/ratings/{id}', [RatingController::class, 'show']);      // Получить отзыв по ID
