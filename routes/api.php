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

// Публичные маршруты
Route::get('/movies', [MovieController::class, 'index']); // Просмотр всех фильмов
Route::get('/movies/{id}', [MovieController::class, 'show']); // Просмотр конкретного фильма
Route::get('/genres', [GenreController::class, 'index']); // Просмотр всех жанров
Route::get('/genres/{id}', [GenreController::class, 'show']); // Просмотр конкретного жанра
Route::get('/actors', [ActorController::class, 'index']); // Просмотр всех актёров
Route::get('/actors/{id}', [ActorController::class, 'show']); // Просмотр конкретного актёра
Route::get('/studios', [StudioController::class, 'index']); // Просмотр всех студий
Route::get('/studios/{id}', [StudioController::class, 'show']); // Просмотр конкретной студии

// Защищённые маршруты
Route::middleware('auth:sanctum')->group(function () {
    // Пользователи
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Фильмы
    Route::post('/movies', [MovieController::class, 'store']);
    Route::put('/movies/{id}', [MovieController::class, 'update']);
    Route::delete('/movies/{id}', [MovieController::class, 'destroy']);
    Route::post('/movies/{id}/favorite', [MovieController::class, 'addToFavorites']); // Добавление в избранное
    Route::get('/movies/favorites', [MovieController::class, 'favorites']); // Просмотр избранного
    Route::delete('/movies/{id}/favorite', [MovieController::class, 'removeFromFavorites']);
    // Отзывы
    Route::apiResource('/rating', RatingController::class);

    // Актёры
    Route::post('/actors', [ActorController::class, 'store']);
    Route::put('/actors/{id}', [ActorController::class, 'update']);
    Route::delete('/actors/{id}', [ActorController::class, 'destroy']);

    // Студии
    Route::post('/studios', [StudioController::class, 'store']);
    Route::put('/studios/{id}', [StudioController::class, 'update']);
    Route::delete('/studios/{id}', [StudioController::class, 'destroy']);

    // Жанры
    Route::post('/genres', [GenreController::class, 'store']);
    Route::put('/genres/{id}', [GenreController::class, 'update']);
    Route::delete('/genres/{id}', [GenreController::class, 'destroy']);
});








    // Студии
    Route::apiResource('/studios', StudioController::class);
    Route::prefix('studios')->group(function () {
        Route::get('/', [StudioController::class, 'index']);          // Просмотр всех студий
        Route::get('/{id}', [StudioController::class, 'show']);       // Просмотр конкретной студии

    });

    // Жанры
    Route::apiResource('/genres', GenreController::class);
    Route::get('/genres', [GenreController::class, 'index']);
    Route::get('/genres/{id}', [GenreController::class, 'show']);
