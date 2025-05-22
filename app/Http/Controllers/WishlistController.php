<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AddToBag;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    public function index() {
    $wishlists = Wishlist::with('product')->where('user_id', auth()->id())->get();
    return view('page.wishlist', compact('wishlists'));
}
public function addToWishlist(Request $request)
{
    if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please Login first!');

    }

    $exists = Wishlist::where('user_id', auth()->id())
                      ->where('product_id', $request->product_id)
                      ->exists();

    if ($exists) {
        return redirect()->back()->with('info', 'Already in wishlist.');
    }

    Wishlist::create([
        'user_id' => auth()->id(),
        'product_id' => $request->product_id,
    ]);

    return redirect()->back()->with('success', 'Added successfully!');
}



   public function destroy($id)
{
    Wishlist::where('id', $id)->where('user_id', auth()->id())->delete();
    return back()->with('success', 'removed from wishlist');
}

public function moveToCart(Request $request)
{
    $product = Product::findOrFail($request->product_id);
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Please Login first!');
    }

    $wishlistItem = Wishlist::where('user_id', $user->id)
                            ->where('product_id', $request->product_id)
                            ->first();

    if (!$wishlistItem) {
        return response()->json(['error' => 'Item not in wishlist'], 404);
    }

    AddToBag::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'price_at_purchase' => $product->price, // ✅ Fixed here
    ]);

    $wishlistItem->delete();

    return redirect()->back()
        ->with('success', 'Moved to cart successfully!')
        ->with('added_product_id', $product->id); // Pass the product ID for further use
}




   
}
