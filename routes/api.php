<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\QrController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotController;
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

/*User Authentication*/
Route::controller(AuthController::class)
->group(function () {
    Route::post('/register', 'signUp');
    Route::post('/login', 'signIn');
    Route::middleware('auth:api')->post('/logout', 'signOut');
});

/*Forgot Password*/
Route::controller(ForgotController::class)
->group(function () {
    Route::post('/forgot', 'forgot');
    Route::post('/reset', 'reset');
});

/*User Profile*/
Route::controller(UserController::class)
->middleware('auth:api')
->prefix('/users')
->group(function () {
    Route::get('/', 'getUser');
    Route::put('/', 'updateUser');
    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('/upload-image', 'uploadImage');
        Route::get('/news', 'getNews');
        Route::put('/news/mark/{id}', 'markNewsAsRead');

        /*GET User By QR Token*/
        Route::get('/qr-codes/{qrCode:token}', 'getByQrToken');
    });
});

/*Attach QR Token*/
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/qr-codes/{qrCode:token}/attach-user', [QrController::class, 'attachUser']);
});
