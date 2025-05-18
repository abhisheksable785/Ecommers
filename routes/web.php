<?php
use Faker\Guesser\Name;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BagController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;

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

Route::get("/", function () {
    return view("page.home");
});
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
Route::get("/contact", function () {
    return view("page.contact");
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

Route::controller(Controller::class)->group(function(){
    Route::get('/shop/{id}', 'shop')->name('shop.cat');
    Route::post('/contact_list', 'contact');
    Route::get('/contact_list', 'show_contact');
    Route::get('/contact/{id}', 'view_contact')->name('contact.show');
    Route::delete('/contact_list/{id}', 'delete_contact');

});

///admin category
///admin category
///admin category
Route::controller(CategoryController::class)->group(function(){
    Route::get('/category',  'index')->name('category.list');
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
    Route::get('/product/{id}',  'product_details')->name('details.show');
    Route::get('/search', 'search')->name('product.search');

    // Route::get('/',[ProductController::class, 'home'])->name('products.home');
});

///// login & sign Up

Route::controller(AuthController::class)->group(function(){
    Route::get('/login','showLoginForm')->name('loginform');
    Route::post('/login', 'login')->name('login');
    Route::get('/register','showRegisterForm');
    Route::post('/register',  'register')->name('register');
    Route::post('/logout','logout')->name('logout');
    

});

Route::get('/reset-pass',function(){
    return view('auth.passwords.email');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'viewWishlist'])->name('wishlist.index');
    Route::post('/wishlist/add/{id}', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
});


Route::get('/users', [AuthController::class, 'index'])->name('users.index');

Route::middleware('auth')->get('/dashboard', function () {
    return view('admin.dashboard');
});
Route::post('/bag/add', [BagController::class, 'add'])->name('bag.add');
Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');

Route::delete('/cart/{id}', [BagController::class, 'remove'])->name('cart.remove');
Route::get('/bill', [CheckoutController::class, 'checkout'])->name('checkout');


// routes/web.php
Route::prefix('cart')->group(function () {
    Route::get('/', [BagController::class, 'index'])->name('cart');
    Route::post('/update', [BagController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{id}', [BagController::class, 'remove'])->name('cart.remove');
});
