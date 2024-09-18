<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GifController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login']);

$router->group(['middleware' => ['auth:api']], function () use ($router) {
    $router->get('/user', [AuthController::class, 'me'])->name('auth.me');
    $router->get('/gifs/search', [GifController::class, 'search'])->name('gifs.search');
    $router->get('/gifs/{id}', [GifController::class, 'show'])->name('gifs.show');
    $router->post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
});
