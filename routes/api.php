<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\AssetAssignmentController;

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

Route::post('register', 'App\Http\Controllers\Api\RegisterController@register')->name('api.register');
Route::post('login', 'App\Http\Controllers\Api\RegisterController@login')->name('api.login');;

Route::middleware('auth:api')->group(function () {
    
    Route::resources([
        'users' => UserController::class,
        'assets' => AssetController::class,
        'vendors' => VendorController::class,
        'asset-assignment' => AssetAssignmentController::class,
        
    ]);
});

