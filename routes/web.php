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

Route::get('/', function () {
    return view('welcome');
});

//todo
Route::resource('/{user}/donate', \App\Http\Controllers\DonationController::class);
Route::get('/{user}/donate', [\App\Http\Controllers\DonationController::class, 'create'])->name('donate');
