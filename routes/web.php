<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('web/auth')->controller(WebAuthController::class)->group(function () {
    Route::get('/', 'index')->name('login');
    Route::post('/', 'authenticate')->name('processLogin');
    Route::get('/logout', 'logout')->middleware('auth')->name('processLogout');
});


// Route::middleware(['auth:web'])->group(function () {
    Route::prefix('livechat')->controller(MessageController::class)->group(function () {
        Route::get('/', 'index')->name('allChats');
    });

    Route::get('/checkSession', function () {
        return response()->json([
            'session' => auth()->check()
        ]);
    });

// });
