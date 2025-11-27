<?php

use App\Http\Controllers\Api\AddToCardController;
use App\Http\Controllers\Api\LegalController as ApiLegalController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/login-api', 'showLoginForm')->name('loginform');
    Route::post('/login-list', 'login')->name('login');
    Route::get('/register-api', 'showRegisterForm');
    Route::post('/register-api', 'register')->name('register');

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

Route::post('/slider/store', [SliderController::class, 'store']);
Route::get('/slider/list', [SliderController::class, 'index']);

Route::get('/category-list', [CategoryController::class, 'index']);
Route::get('/category-product-list/{id}', [ProductController::class, 'getProductsByCategory']);
Route::get('/product-list', [ProductController::class, 'apiIndex']);

// Route::get('/profile-list', [profileController::class, 'apiIndex']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/legal/accept', [ApiLegalController::class, 'acceptTerms']);
    Route::post('/legal/check', [ApiLegalController::class, 'checkTerms']);


    Route::get('/bag', [AddToCardController::class, 'getBag']);
    Route::post('/add-to-bag', [AddToCardController::class, 'addToBag']);
    Route::put('/bag/{id}/quantity', [AddToCardController::class, 'updateQuantity']);
    Route::delete('/bag/remove/{id}', [AddToCardController::class, 'removeFromBag']);
    Route::delete('/bag/clear', [AddToCardController::class, 'clearBag']);
    Route::get('/cart-count', [AddToCardController::class, 'getCartCount']);

    Route::get('/produt-details/{id}', [ProductController::class, 'show']);
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrderApi']);
    Route::post('/profile/store', [ProfileController::class, 'store']);
    route::get('/profile/info', [ProfileController::class, 'index']);

    Route::get('/user/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggleWishlist']);

    Route::get('/user/order-list', [OrderController::class, 'userOderApi']);
    Route::get('/user/order-details/{id}', [OrderController::class, 'orderDetailsApi']);




    Route::post("checkout/place-order", [CheckoutController::class, "placeOrderApi"]);
    Route::post("checkout/verify-payment", [PaymentController::class, "paymentVerify"]);

});
