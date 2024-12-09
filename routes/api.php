<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use Illuminate\Http\Request;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::controller(ArticleController::class)->group(function () {
   Route::get('articles', 'index');
   Route::get('articles/{id}', 'show');
});

Route::controller(LikeController::class)->group(function () {
    Route::post('/likes', 'store')->middleware('throttle:100,1');
});

Route::controller(CommentController::class)->group(function () {
    Route::post('/sendComment', 'store');
});
