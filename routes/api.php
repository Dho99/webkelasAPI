<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CommentsController;

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

Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function () {
        Route::post('login', 'login')->name('login');
        Route::post('register', 'register')->name('register');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::get('show', 'detail');
    });

// Route::middleware('auth:api')->group(function(){
Route::resource('post', PostController::class);
Route::resource('comment', CommentsController::class);

Route::prefix('chat')
    ->controller(MessageController::class)
    ->middleware('auth:api')
    ->group(function () {
        Route::get('messages','messages')->name('showMessages');
        Route::get('message/{chatId}','index')->name('showMessage');
        Route::post('message/{chatId}','sendMessage')->name('sendMessage');
    });

// });
