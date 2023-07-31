<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmCodeController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\UserController;

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
Route::post('/user_register',[AuthController::class,'user_register']);
Route::post('admin/register',[AuthController::class,'admin_register']);


Route::post('admin/login',[AuthController::class,'admin_login']);
Route::post('/login',[AuthController::class,'user_login']);
Route::post('broker/login',[AuthController::class,'broker_login']);

Route::post('/password/forget-password',[ForgetPasswordController::class,'forgetPassword']);
Route::post('/password/confirm-code',[ConfirmCodeController::class,'confirm_code']);
Route::post('/password/reset_password',[ResetPasswordController::class,'reset_password']);

Route::middleware(['auth:sanctum'])->group(function() {
    Route::post('/logout',[AuthController::class,'logout']);
});
Route::group(['middleware' => ['auth', 'admin']], function () {
    //Route::get('/dashboard/counts',[HomeController::class,'index']);
    //Route::get('/dashboard/users',[UsersController::class,'get_users']);

});
Route::resource('dashboard/users', UserController::class);
Route::resource('dashboard/lands', LandController::class);
Route::resource('dashboard/shops', ShopController::class);
Route::resource('dashboard/apartments', ApartmentController::class);
Route::resource('dashboard/brokers', ApartmentController::class);


Route::get('/dashboard/counts',[HomeController::class,'index']);
//Route::get('/dashboard/users',[HomeController::class,'get_users']);
