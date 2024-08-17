<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['api']], function () {
  Route::get('/', function () {
    return response()->json(['message' => 'Hello, World!'], 200);
  });

  /**
   * Auth routes
   */
  Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::group(['middleware' => 'auth:api'], function () {
      Route::post('logout', [AuthController::class, 'logout']);
    });
  });

  /**
   * User routes
   */
  Route::group(['prefix' => 'users'], function () {
    Route::get('/me', [UserController::class, 'me'])->middleware('auth:api');
    Route::post('/', [UserController::class, 'store']);
  });
});
