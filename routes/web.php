<?php
use Faker\Guesser\Name;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BagController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\contactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RazorpayController;
use Illuminate\Support\Facades\Route;

///back
///back
///back
// mysqld --skip-grant-tables --skip-external-locking


Route::get("/dashboard", function () {
    return view("admin.dashboard");
});

///front
///front
///front

Route::get("/home", function () {
    return view("page.home");
})->name('home');

// Route::get("/shop", function () {
//     return view("page.shop");
// });

Route::get("/about", function () {
    return view("page.about");
});
Route::get("/bill", function () {
    return view("page.bill");
});
Route::get("/shopping-cart", function () {
    return view("page.shopping-cart");
});

Route::get("/blog", function () {
    return view("page.blog");
});
Route::get("/orders", function () {
    return view("page.orders");
});
Route::get("/wishlist", function () {
    return view("page.wishlist");
});
Route::get("/gift", function () {
    return view("page.gift");
});
Route::get("/credit", function () {
    return view("page.credit");
});
Route::get("/shop", function () {
    return view("page.shop");
});
Route::get("/users", function () {
    return view("admin.users");
});



// Route::controller(Controller::class)->group(function(){
//     Route::get('/shop/{id}', 'shop')->name('shop.cat');
//     Route::post('/contact_list', 'contact');
    
//     Route::get('/contact/{id}', 'view_contact')->name('contact.show');
//     Route::delete('/contact_list/{id}', 'delete_contact');

// });


///admin category
///admin category
///admin category
Route::get('/test-google-config', function () {
    return [
        'client_id' => config('services.google.client_id'),
        'client_secret' => config('services.google.client_secret'),
        'redirect' => config('services.google.redirect'),
    ];
});
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);

Route::controller(AuthController::class)->group(function(){
    Route::get('/login','showLoginForm')->name('loginform');
    Route::post('/login', 'login')->name('login');
    Route::get('/register','showRegisterForm');
    Route::post('/register',  'register')->name('register');
    Route::post('/logout-user','logout')->name('logout')->middleware('auth:sanctum');
    

});

Route::controller(contactController::class)->group(function(){
Route::get('/contact-ind','index')->name('contact.index');
Route::get('/add-contact','create')->name('contact.create');
Route::post('/contact-store','store')->name('contact.store');
Route::get('/contact/{id}', 'view')->name('contact.view');
Route::delete('/contact/{id}', 'destroy')->name('contact.destroy');
});

Route::controller(CategoryController::class)->group(function(){
    Route::get('/category',  'index')->name('category.index');
    Route::get('/category/view/{id}',  'view')->name('category.view');
    Route::view('/category/add',  'admin.category.add-cat')->name('category.add');
    Route::post('/category/store', 'store')->name('category.store');
    Route::get('/category/edit/{id}', 'edit')->name('category.edit');
    Route::post('/category/update/{id}',  'update')->name('category.update');
    Route::delete('/category/delete/{id}', 'destroy')->name('category.destroy');
    Route::get('/shop',  'shop')->name('shop');

    Route::get('/',  'cathome')->name('category.home');


});
///product Controller
///product
///product
Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('products.index');
    Route::get('/add-product', 'create')->name('products.create');
    Route::post('/add-product', 'store')->name('products.store');
    Route::delete('/products/{id}',  'destroy')->name('products.destroy');
    Route::get('/products/{id}/edit',  'edit')->name('products.edit');
    Route::put('/products/{id}', 'update')->name('products.update');
    Route::get('/products/{id}', 'show')->name('products.show');
    Route::get('/category/{id}','categoryProducts')->name('category.products');
    Route::get('category-data', 'index');
    Route::get('/shop',  'shop')->name('shop');
    Route::get('/catproducts/{id}', 'categoryProducts')->name('category.products');
    Route::get('/product/{id}',  'product_details')->name('product.details');
    Route::get('/search', 'search')->name('product.search');

    // Route::get('/',[ProductController::class, 'home'])->name('products.home');
});

///// login & sign Up


Route::controller(WishlistController::class)->group(function(){
    Route::get('/wishlist', 'index')->name('wishlist.index');
    Route::post('/wishlist/add/{id}', 'addToWishlist')->name('wishlist.add');
   Route::delete('/wishlist/delete/{id}',  'destroy')->name('wishlist.delete');;
   Route::post('/wishlist/move-to-cart',  'moveToCart')->name('wishlist.moveToCart');
});

Route::get('/reset-pass',function(){
    return view('auth.passwords.email');
});
Route::middleware(['auth'])->group(function () {
    
});


Route::get('/users', [AuthController::class, 'index'])->name('users.index');

Route::middleware('auth')->get('/dashboard', function () {
    return view('admin.dashboard');
});
Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');

Route::get('/bill', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.place');


Route::post('/apply-coupon', [CouponController::class, 'applyCoupon'])->name('apply.coupon');
Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupons.create');
Route::post('/coupons/store', [CouponController::class, 'store'])->name('coupons.store');
Route::get('/coupons/{coupon}/edit', [CouponController::class, 'edit'])->name('coupons.edit');
Route::put('/coupons/{coupon}', [CouponController::class, 'update'])->name('coupons.update');
Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy'])->name('coupons.destroy');



// routes/web.php
Route::controller(BagController::class)->group(function () {
    Route::get('/bag', 'index')->name('bag.index');
    Route::post('/bag-update',  'update')->name('cart.update');
    Route::delete('/bag/remove/{id}',  'remove')->name('bag.remove');
    Route::post('/bag/add', 'add')->name('bag.add');
});
   

Route::get('/my-profile', [profileController::class, 'index'])->name('profile.index');
Route::resource('profile', profileController::class)->only(['index', 'store', 'update']);

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{id}', [OrderController::class, 'view'])->name('orders.view');
Route::get('/orders/edit/{id}', [OrderController::class, 'edit'])->name('orders.edit');
Route::post('orders/destroy/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

Route::get('/user-order', [OrderController::class, 'order'])->name('user.orders');

Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoice.store');
Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');


Route::post('/payment/verify', [RazorpayController::class, 'verifyPayment'])->name('payment.verify');
Route::post('/payment', [RazorpayController::class, 'payment'])->name('payment');
Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
Route::match(['get', 'post'],'/payment/success', [CheckoutController::class, 'razorpaySuccess'])->name('razorpay.success');



