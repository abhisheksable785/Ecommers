<?php

namespace App\Http\Controllers;

use App\Models\AddToBag;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BagController extends Controller
{

  public function add(Request $request)
{
   
    // Redirect to login if not authenticated
    if (!Auth::check()) {
        return redirect()
            ->route('login')
            ->with('error', 'Please login to add items to your bag');
    }
    
    // Find or create bag item
    $item = AddToBag::firstOrNew([
        'user_id' => Auth::id(),
        'product_id' => $request->product_id,
        'size' => $request->size,
        'color' => $request->color,
    ]);

    // Set quantity and price
    $item->price_at_purchase = $request->price;
    $item->quantity = $item->exists ? $item->quantity + 1 : 1;

    // Max quantity check
    $maxQuantity = 10;
    if ($item->quantity > $maxQuantity) {
        return back()
            ->with('error', "Maximum quantity ($maxQuantity) reached for this item")
            ->withInput();
    }

    // Save and update cart count
    $item->save();
    $cartCount = AddToBag::where('user_id', Auth::id())->count();
    session(['cart_count' => $cartCount]);

    return back()
        ->with('success', 'Product added to your bag successfully!')
        ->with('added_product_id', $request->product_id);
}



    public function cart(){
        $cartItems = AddToBag::with('product')
                    ->where('user_id', auth()->id())
                    ->get();

        return view('page.shopping-cart', compact('cartItems'));
        }
    public function index()
    {
        $cartItems = AddToBag::with('product')
                    ->where('user_id', Auth::id())
                    ->get();

        $subtotal = $cartItems->sum(function($item) {
            return $item->price_at_purchase * $item->quantity;
        });

        return view('page.shopping-cart', compact('cartItems', 'subtotal'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*.id' => 'required|exists:add_to_bag,id',
            'quantities.*.quantity' => 'required|integer|min:1'
        ]);

        foreach ($request->quantities as $item) {
            AddToBag::where('id', $item['id'])
                ->where('user_id', Auth::id())
                ->update(['quantity' => $item['quantity']]);
        }

        return response()->json(['success' => true]);
    }

    public function remove($id)
    {
        AddToBag::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Item removed from cart');
    }
}