<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\LoansController;
use App\Http\Controllers\Web\InstallmentController;
use App\Http\Controllers\Web\SavingController;


Route::get('/', [AuthController::class, 'index']);
Route::get('login', [AuthController::class, 'index'])->name('login');;
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout']);

Route::get('/test', [LoansController::class, 'test']);

Route::group(['middleware' => ['auth']], function() {

  Route::get('dashboard', [DashboardController::class, 'index']);

  Route::prefix('auth')->group(function() {
    Route::get('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/change-password', [AuthController::class, 'updatePassword']);
  });
  
  Route::prefix('users')->group(function() {
    Route::get('/', [UsersController::class, 'index']);
    Route::get('/create', [UsersController::class, 'create']);
    Route::post('/', [UsersController::class, 'store']);
    Route::get('/{id}', [UsersController::class, 'show']);
    Route::get('/{id}/edit', [UsersController::class, 'edit']);
    Route::put('/{id}', [UsersController::class, 'update']);
    Route::delete('/{id}', [UsersController::class, 'destroy']);
  });

  Route::prefix('loans')->group(function() {
    Route::get('/', [LoansController::class, 'index']);
    Route::get('/create', [LoansController::class, 'create']);
    Route::get('/{id}', [LoansController::class, 'show']);
    Route::post('/', [LoansController::class, 'store']);
  });

  Route::prefix('installments')->group(function() {
    Route::put('/update-status/{id}', [InstallmentController::class, 'update_status']);
  });

  Route::prefix('savings')->group(function() {
    Route::get('/', [SavingController::class, 'index']);
    Route::get('/create', [SavingController::class, 'create']);
    Route::post('/', [SavingController::class, 'store']);
  });

});
