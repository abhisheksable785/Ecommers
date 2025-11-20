<?php

use App\Http\Controllers\Api\AddToCardController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\profileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function () {
    Route::get('/login-api', 'showLoginForm')->name('loginform');
    Route::post('/login-list', 'login')->name('login');
    Route::get('/register-api', 'showRegisterForm');
    Route::post('/register-api', 'register')->name('register');
    // Route::post('/logout-api','logout')->name('logout')->middleware('auth:sanctum');

});

Route::middleware('auth:sanctum')->post('/logout', [AuthApiController::class, 'logout']);
Route::post('/google-login', [AuthApiController::class, 'googleLogin']);

Route::middleware('auth:sanctum')->get('/verify-token', function () {
    return response()->json([
        'success' => true,
        'message' => 'Token is valid',
    ]);
});

Route::post('/user-register', [AuthApiController::class, 'store']);
Route::post('/user-login', [AuthApiController::class, 'userLogin']);

Route::post('/profile/store', [ProfileController::class, 'store'])->middleware('auth:sanctum');
route::get('/profile/info', [ProfileController::class, 'index'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->post('/checkout/place-order', [CheckoutController::class, 'placeOrderApi']);

Route::post('/slider/store', [SliderController::class, 'store']);
Route::get('/slider/list', [SliderController::class, 'index']);

Route::get('/category-list', [CategoryController::class, 'index']);
Route::get('/product-list', [ProductController::class, 'apiIndex']);

Route::get('/produt-details/{id}', [ProductController::class, 'show']);
Route::get('/profile-list', [profileController::class, 'apiIndex']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/add-to-bag', [AddToCardController::class, 'addToBag']);
    Route::get('/bag', [AddToCardController::class, 'getBag']);
    Route::put('/bag/{id}/quantity', [AddToCardController::class, 'updateQuantity']);
    Route::delete('/bag/remove/{id}', [AddToCardController::class, 'removeFromBag']);
    Route::delete('/bag/clear', [AddToCardController::class, 'clearBag']);
    Route::get('/cart-count', [AddToCardController::class, 'getCartCount']);

});
