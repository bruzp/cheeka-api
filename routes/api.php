<?php

use App\Http\Controllers\API\V1\Auth\LoginController;
use App\Http\Controllers\API\V1\Auth\RegistrationController;
use App\Http\Controllers\API\V1\UserController;
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

Route::prefix('v1')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/user', [UserController::class, 'show']);
        Route::put('/user', [UserController::class, 'update']);

        Route::post('/logout', [LoginController::class, 'logout']);
    });

    Route::middleware('api.basic')
    ->group(function(){
        Route::post('/register', [RegistrationController::class, 'store']);

        Route::post('/login', [LoginController::class, 'authenticate']);
    });
});