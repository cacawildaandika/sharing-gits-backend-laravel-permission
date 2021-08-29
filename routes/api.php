<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');


Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', [\App\Http\Controllers\AuthController::class, 'user']);

    Route::prefix('article')->group(function () {
        Route::get('/', [\App\Http\Controllers\ArticleController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\ArticleController::class, 'store']);
        Route::get('/{article}', [\App\Http\Controllers\ArticleController::class, 'show']);
        Route::put('/{article}', [\App\Http\Controllers\ArticleController::class, 'update']);
        Route::delete('/{article}', [\App\Http\Controllers\ArticleController::class, 'destroy']);
    });
});
