<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\UserController;
use App\Models\User;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/accounts/all', [AccountController::class, 'all']);
    Route::post('/account/create', [AccountController::class, 'create']);
    Route::post('/account/delete', [AccountController::class, 'delete']);
    Route::get('/account/balance', [AccountController::class, 'balance']);
    Route::post('/account/balance/add', [AccountController::class, 'balanceAdd']);
    Route::post('/account/balance/deduct', [AccountController::class, 'balanceDeduct']);
});

Route::post('/login', [UserController::class, 'login']);
