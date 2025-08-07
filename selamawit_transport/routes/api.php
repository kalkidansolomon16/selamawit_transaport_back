<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::put('user',[UserController::class,'index']);
});
Route::get('logout',[AuthController::class,'logout']);
Route::post('login',[AuthController::class,'login']);
