<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\EmployeeController;


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
Route::get('users/count', [UserController::class,'count']);

Route::get('vehicles', [VehicleController::class, 'index']);
Route::post('vehicles', [VehicleController::class, 'store']);
// Route::get('vehicles/{id}', [VehicleController::class, 'show']);
Route::get('vehicles/count', [VehicleController::class, 'count']);

Route::get('employees', [EmployeeController::class, 'index']);
Route::post('employees', [EmployeeController::class, 'store']);
// Route::get('employees/{id}', [EmployeeController::class, 'show']);
Route::get('employees/count', [EmployeeController::class, 'count']);

Route::get('orders', [OrderController::class, 'index']);
Route::post('orders', [OrderController::class, 'store']);
// Route::get('orders/{id}', [OrderController::class, 'show']);
Route::get('orders/count', [OrderController::class, 'count']);
Route::get('orders/total-revenue', [OrderController::class, 'totalRevennue']);

Route::get('expenses', [ExpenseController::class, 'index']);
Route::post('expenses', [ExpenseController::class, 'store']);
// Route::get('expenses/{id}', [ExpenseController::class, 'show']);
// Route::get('expenses/count', [ExpenseController::class, 'count']);
Route::get('expenses/total-amount', [ExpenseController::class, 'totalExpense']);
