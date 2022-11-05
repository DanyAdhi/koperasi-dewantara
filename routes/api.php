<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\InstallmentController;
use App\Http\Controllers\Api\UserController;


Route::fallback(function(){
  return response()->json([
    'status' => false,
    'message' => 'Route not found!'
  ], 404);
});

Route::post('login', [AuthController::class, 'login']);


Route::group(['middleware' => ['jwt.verify']], function () {
  Route::post('logout', [AuthController::class, 'logout']);
  
  Route::prefix('loans')->group(function() {
    Route::get('/', [LoanController::class, 'getAllLoans']);
    Route::get('/{id}', [LoanController::class, 'getOneLoans']);
    Route::get('/total', [LoanController::class, 'getTotalLoans']);
  });

  Route::prefix('installments')->group(function() {
    Route::get('/{id}', [InstallmentController::class, 'getAllInstallment']);
  });

  Route::prefix('users')->group(function() {
    Route::get('/me', [UserController::class, 'myProfile']);
  });

});
