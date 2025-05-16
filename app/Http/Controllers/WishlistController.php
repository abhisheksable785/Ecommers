<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function addToWishlist($productId)
    {
        $user = auth()->user();
        $product = Product::findOrFail($productId);

        if (!$user->wishlist->contains($product->id)) {
            $user->wishlist->attach($productId);
        }

        return back()->with('success', 'Product added to wishlist!');
    }

    public function removeFromWishlist($productId)
    {
        $user = auth()->user();
        $user->wishlist->detach($productId);
        return back()->with('success', 'Product removed from wishlist!');
    }

    public function viewWishlist()
    {
        $wishlists = auth()->user()->wishlist;
        return view('page.wishlist', compact('wishlists'));
    }
}
