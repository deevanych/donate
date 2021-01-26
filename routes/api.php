<?php

use App\Http\Controllers\Api\v1\DonationController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\UserSettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => '/v1', 'as' => 'api.'], function () {
    Route::resource('users', UserController::class)->only('show');
    Route::resource('users/{user}/donations', DonationController::class)->only('store');
});

Route::group(['prefix' => '/v1', 'as' => 'api.', 'middleware' => 'auth:api'], function () {
    Route::resource('users', UserController::class)->except('show');
    Route::resource('settings', UserSettingsController::class);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
