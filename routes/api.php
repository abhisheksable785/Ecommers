<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function(){
    Route::get('/login-api','showLoginForm')->name('loginform');
    Route::post('/login-list', 'login')->name('login');
    Route::get('/register-api','showRegisterForm');
    Route::post('/register-api',  'register')->name('register');
    Route::post('/logout-api','logout')->name('logout')->middleware('auth:sanctum');
    
});

Route::get('/category-list',[CategoryController::class , 'index']);
Route::get('/product-list',[ProductController::class , 'apiIndex']);
Route::get('/profile-list',[profileController::class , 'apiIndex']);


