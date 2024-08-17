<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['api']], function () {
  Route::get('/', function () {
    return response()->json(['message' => 'Hello, World!'], 200);
  });


  Route::resource('users', UserController::class);
});
