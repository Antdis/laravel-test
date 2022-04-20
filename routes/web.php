<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\PostController;
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

Route::get('/', [MainController::class, 'index']);
Route::resource('/posts', PostController::class)->only(['index', 'show']);

Route::post('/posts/{post}/comment', [PostController::class, 'comment'])->middleware('auth');
Route::post('/like', [PostController::class, 'like'])->middleware('auth');

Route::get('/boosterPacks', [MainController::class, 'boosterPacks']);

Route::post('/login', [MainController::class, 'login']);
Route::get('/logout', [MainController::class, 'logout'])->name('logout');

