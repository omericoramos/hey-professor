<?php

use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Question\LikeController;
use App\Http\Controllers\Question\UnlikeController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {

    // se o .env for local faz o login automaticamente utilizando o usuário de id 1
    if (app()->isLocal()) {
        auth()->loginUsingId(1);

        return to_route('dashboard');
    }

    return view('welcome');
});

Route::get('/dashboard', DashBoardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/question/store', [QuestionController::class, 'store'])->name('question.store');
Route::post('/question/like/{question}', LikeController::class)->name('question.like');
Route::post('/question/unlike/{question}', UnlikeController::class)->name('question.unlike');

require __DIR__.'/auth.php';
