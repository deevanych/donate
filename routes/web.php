<?php

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

//Laravel
Route::get('/widget/{type}/{id}', [\App\Http\Controllers\WidgetController::class, 'show'])->name('widget')->middleware('signed');
Route::get('/auth/callback/{type?}', [\App\Http\Controllers\AuthController::class, 'callback'])->name('callback');
Route::get('/auth/{type?}', [\App\Http\Controllers\AuthController::class, 'index'])->name('login');
Route::get('/dashboard', [\App\Http\Controllers\PageController::class, 'index'])->name('dashboard');

//Vue
Route::get('/{any}', [\App\Http\Controllers\PageController::class, 'index'])->where('any', '.*')->name('index');
