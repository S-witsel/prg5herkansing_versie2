<?php

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

Auth::routes();

use App\Http\Controllers\HomeController;

//Route::get('/', [HomeController::class, 'index'])->name('home');
//Route::get('/home', [HomeController::class, 'index'])->name('home');


use App\Http\Controllers\UserProfileController;

Route::get('/profile', [UserProfileController::class, 'show'])->name('user.profile');
Route::patch('/profile', [UserProfileController::class, 'update'])->name('user.profile.update');


use App\Http\Controllers\TopicController;

Route::middleware(['auth'])->group(function () {
    Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
    Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');
    Route::get('/home', [TopicController::class, 'index'])->name('home');
    Route::resource('topics', TopicController::class);
    Route::get('/topics/topic_detail/{topic}', [TopicController::class, 'show'])->name('topics.show');
    Route::get('/topics/{topic}/edit', [TopicController::class, 'edit'])->name('topics.edit');
});

