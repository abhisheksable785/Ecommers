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
    // Check authentication
    if (!Auth::check()) {
        return redirect()
            ->route('login')
            ->with('error', 'Please login to add items to your bag');
    }

    // Validate request data
    $validated = $request->validate([
        'product_id' => 'required|exists:tbl_product,id',
        'price' => 'required|numeric|min:0',
        'size' => 'required|string|max:50',
        'color' => 'nullable|string|max:50'
    ], [
        'size.required' => 'Please select a size before adding to bag',
        'product_id.exists' => 'The selected product is no longer available'
    ]);

    try {
        // Check product availability
        $product = Product::findOrFail($validated['product_id']);
        
        if (!$product->is_active) {
            return back()
                ->with('error', 'This product is currently unavailable')
                ->withInput();
        }

        // Check stock availability
        if ($product->stock <= 0) {
            return back()
                ->with('error', 'This product is out of stock')
                ->withInput();
        }

        // Find or create bag item
        $item = AddToBag::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
            'size' => $validated['size'],
            'color' => $validated['color'] ?? null
        ]);

        // Update item details
        $item->price_at_purchase = $validated['price'];
        $item->quantity = $item->exists ? $item->quantity + 1 : 1;
        
        // Validate maximum quantity
        $maxQuantity = 10; // Configurable maximum
        if ($item->quantity > $maxQuantity) {
            return back()
                ->with('error', "Maximum quantity ($maxQuantity) reached for this item")
                ->withInput();
        }

        $item->save();

        // Update user's cart count in session
        $cartCount = AddToBag::where('user_id', Auth::id())->count();
        session(['cart_count' => $cartCount]);

        return back()
            ->with('success', 'Product added to your bag successfully!')
            ->with('added_product_id', $validated['product_id']);

    } catch (\Exception $e) {
        Log::error('Add to bag failed: ' . $e->getMessage(), [
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'ip' => $request->ip()
        ]);

        return back()
            ->with('error', 'Failed to add product to bag. Please try again.')
            ->withInput();
    }
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