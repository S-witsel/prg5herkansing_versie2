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

use App\Http\Controllers\UserProfileController;

Route::get('/profile', [UserProfileController::class, 'show'])->name('user.profile');
Route::patch('/profile', [UserProfileController::class, 'update'])->name('user.profile.update');


use App\Http\Controllers\TopicController;

Route::middleware(['auth'])->group(function () {
    Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
    Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');
    Route::get('/home', [TopicController::class, 'index'])->name('home');
    Route::get('/', [TopicController::class, 'index'])->name('home');
    Route::resource('topics', TopicController::class);
    Route::get('/topics/topic_detail/{topic}', [TopicController::class, 'show'])->name('topics.show')->middleware('topic.visibility');
    Route::get('/topics/{topic}/edit', [TopicController::class, 'edit'])->name('topics.edit')->middleware('topic.visibility');
    Route::put('/topics/{topic}/updateTags', [TopicController::class, 'updateTags'])->name('topics.updateTags');
});

use App\Http\Controllers\CommentController;

Route::middleware(['auth'])->group(function () {
    Route::post('/topics/{topic}/comments', [CommentController::class, 'store'])->name('comments.store');
});


use App\Http\Controllers\AdminOptionsController;
use App\Http\Controllers\TagController;

Route::middleware(['special.rights'])->group(function () {
    Route::get('/admin/options', [AdminOptionsController::class, 'index'])->name('admin.options');
    Route::put('/admin/toggle-visibility/{topic}', [AdminOptionsController::class, 'toggleVisibility'])->name('admin.toggleVisibility');

    Route::get('/admin/tags', [TagController::class, 'manageTags'])->name('admin.manageTags');
    Route::post('/admin/tags', [TagController::class, 'createTag'])->name('tags.store');
    Route::delete('/admin/tags', [TagController::class, 'deleteTag'])->name('tags.destroy');
});



Route::delete('/topics/{topic}', [TopicController::class, 'destroy'])->name('topics.destroy')->middleware(['auth', 'topic.ownership']);
