<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\PartnerController;
use App\Http\Controllers\API\System\CountryController;
use App\Http\Controllers\API\System\PaymentController;
use App\Http\Controllers\API\System\ZoneController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function(){
    Route::prefix('auth')->group(function(){
        Route::post('login', [AuthController::class, 'login']);
        Route::post('verify_token', [AuthController::class, 'verifyToken']);
    });

    Route::post('verify', [AuthController::class, 'verify']);

    Route::group(['middleware' => ['auth:api']], function(){
        Route::apiResource('users', UserController::class);

        Route::apiResource('zones', ZoneController::class);
        Route::apiResource('countries', CountryController::class);
        Route::apiResource('partners', PartnerController::class);
    });

    Route::group(['middleware' => ['client']], function(){
        Route::apiResource('payments', PaymentController::class);
    });
});
