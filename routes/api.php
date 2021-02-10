<?php

use App\Http\Controllers\Api\v1\BalanceController;
use App\Http\Controllers\Api\v1\DonationController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\UserSettingsController;
use App\Http\Controllers\Api\v1\VideoController;
use App\Http\Controllers\Api\v1\WidgetController;
use App\Http\Controllers\Api\v1\WidgetTypeController;
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

//open routes
Route::group(['prefix' => '/v1', 'as' => 'api.'], function () {
    Route::resource('users', UserController::class)->only('show');
    Route::resource('users/{user}/donations', DonationController::class)->only('store');
    Route::resource('widgets', WidgetController::class)->only('show');
    Route::get('widgets/{widget}/data', [WidgetController::class, 'getData']);
    Route::get('video', VideoController::class);
});

//guarded routes
Route::group(['prefix' => '/v1', 'as' => 'api.', 'middleware' => 'auth:api'], function () {
    Route::resource('users', UserController::class)->except('show');
    Route::resource('balance', BalanceController::class);
    Route::resource('settings', UserSettingsController::class);
    Route::resource('widgets', WidgetController::class)->except('show');
    Route::resource('widgets/types', WidgetTypeController::class)->only('index');
});
