<?php

namespace App\Http\Controllers;

use App\Models\AddToBag;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $wishlists = Wishlist::with('product')->where('user_id', auth()->id())->get();
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $wishlists,
            ]);
        }

        return view('page.wishlist', compact('wishlists'));
    }

    public function addToWishlist(Request $request)
    {
        if (! auth()->check()) {
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

        if (! $user) {
            return redirect()->route('login')->with('error', 'Please Login first!');
        }

        $wishlistItem = Wishlist::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if (! $wishlistItem) {
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

    public function toggleWishlist(Request $request)
    {
        // 1. Authentication Check (Mandatory for API)
        if (! Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated. Please log in to manage your wishlist.',
            ], 401);
        }

        // 2. Validate the incoming product ID
        $request->validate([
            'product_id' => 'required|integer|exists:tbl_product,id',
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;

        // 3. Check for existing item
        $wishlistItem = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($wishlistItem) {
            // Item EXISTS -> REMOVE it
            $wishlistItem->delete();

            return response()->json([
                'status' => 'success',
                'action' => 'removed',
                'message' => 'Product successfully removed from wishlist.',
                'is_wishlisted' => false,
            ]);

        } else {
            // Item DOES NOT EXIST -> ADD it
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);

            return response()->json([
                'status' => 'success',
                'action' => 'added',
                'message' => 'Product successfully added to wishlist.',
                'is_wishlisted' => true,
            ]);
        }
    }
}
