<?php

use App\Http\Controllers\Auth\GitHub\CallbackController;
use App\Http\Controllers\Auth\GitHub\RedirectController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Question\LikeController;
use App\Http\Controllers\Question\PublishController;
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
    // if (app()->isLocal()) {
    //     auth()->loginUsingId(1);

    //     return to_route('dashboard');
    // }

    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', DashBoardController::class)->name('dashboard');

    //region profile routes

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //endregion

    //question routes
    Route::prefix('/questions')->group(function () {

        Route::get('/index', [QuestionController::class, 'index'])->name('question.index');
        Route::get('/{question}/edit', [QuestionController::class, 'edit'])->name('question.edit');
        Route::post('', [QuestionController::class, 'store'])->name('question.store');
        Route::delete('/{question}', [QuestionController::class, 'destroy'])->name('question.destroy');
        Route::put('/{question}', [QuestionController::class, 'update'])->name('question.update');
        Route::put('/publish/{question}', PublishController::class)->name('question.publish');
        Route::patch('/archive/{question}', [QuestionController::class, 'archive'])->name('question.archive');
        Route::patch('/restore/{question}', [QuestionController::class, 'restore'])->name('question.restore');
        Route::post('/like/{question}', LikeController::class)->name('question.like');
        Route::post('/unlike/{question}', UnlikeController::class)->name('question.unlike');
    });

    //endregion
});
Route::get('github/login', RedirectController::class)->name('github.login');
Route::get('github/callback', CallbackController::class)->name('github.callback');
require __DIR__.'/auth.php';
