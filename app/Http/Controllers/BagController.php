<?php

namespace App\Http\Controllers;

use App\Models\AddToBag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class BagController extends Controller
{

    public function add(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    
        $validated = $request->validate([
            'product_id' => 'required|exists:tbl_product,id',
            'price' => 'required|numeric',
            'size' => 'nullable|string',
            'color' => 'nullable|string'
        ]);
    
        $item = AddToBag::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
            'size' => $validated['size'],
            'color' => $validated['color']
        ]);
    
        $item->price_at_purchase = $validated['price'];
        $item->quantity = $item->exists ? $item->quantity + 1 : 1;
        $item->save();
    
        return back()->with('success', 'Item added to bag!');
    }
    public function cart()
{
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