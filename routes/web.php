<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowsController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\PostsController;
use \App\Mail\NewUserWelcomeMail;


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



Auth::routes();

Route::get('/email', function () {
    return new NewUserWelcomeMail();
});

Route::post('follow/{user}', [FollowsController::class, 'store'])->name('follow');

Route::get('/profile/{username}', [ProfilesController::class, 'show'])->name('profile.show');
Route::get('/profile/{id}/edit', [ProfilesController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{id}', [ProfilesController::class, 'update'])->name('profile.update');


Route::get('/p/create', [PostsController::class, 'create'])->name('post.create');
Route::get('/p/{post}/edit', [PostsController::class, 'edit'])->name('post.edit');
Route::patch('/p/{post}', [ProfilesController::class, 'update'])->name('post.update');
Route::get('/p/{post}', [PostsController::class, 'show'])->name('post.show');
Route::post('/p', [PostsController::class, 'store'])->name('post.store');
Route::get('/', [PostsController::class, 'index'])->name('post.index');

