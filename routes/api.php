<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\PartnerController;
use App\Http\Controllers\API\System\CountryController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function(){
    Route::prefix('auth')->group(function(){
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::post('verify', [AuthController::class, 'verify']);

    Route::group(['middleware' => ['auth:api']], function(){
        Route::apiResource('users', UserController::class);

        Route::apiResource('zones', ZoneController::class);
        Route::apiResource('countries', CountryController::class);
        Route::apiResource('partners', PartnerController::class);
    });

    Route::group(['middleware' => ['client']], function(){
        Route::get('test', function(){
            return [
                'message' => 'Your fine bro!',
            ];
        });
    });

    // Route::get('verify', function(Request $request){
    //     $validator = Validator::make($request->input(), [
    //         'token' => ['required'],
    //     ]);

    //     $validator->validate();

    //     $data = [
    //         'grant_type' => 'client_credentials',
    //         'client_id' => 1,
    //         'client_secret' => $request->token,
    //         'scope' => '',
    //     ];

    //     $response = Http::asForm()->post('http://127.0.0.1:8001/oauth/token', $data);

    //     dd(date('Y-m-d H:i:s', 3 * $response->json()['expires_in'] + strtotime(date('Y-m-d H:i:s'))));

    //     dd(1);
    // });
});
