<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::view('/users', 'users.show-all')->name('users.show.all');

Route::view('/game', 'game.show')->name('game.show');

Route::prefix('chat')->name('chat.')->group(function () {
    Route::get('/', [ChatController::class, 'showChat'])->name('show');
    Route::post('message', [ChatController::class, 'messageReceived'])->name('message.received');
    Route::post('/greet/{user}', [ChatController::class, 'greet'])->name('greet');
});
