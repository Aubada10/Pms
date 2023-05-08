<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgetPasswordController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::post('/register_user',[AuthController::class,'register_user']);
Route::post('/login',[AuthController::class,'login']);

Route::post('/password/forget-password',[ForgetPasswordController::class,'forgetPassword']);
Route::post('/password/reset-password',[ResetPasswordController::class,'resetPassword']);

Route::middleware(['auth:sanctum'])->group(function() {
    Route::post('/logout',[AuthController::class,'logout']);
});

