<?php

namespace App\Http\Controllers;

use App\Models\AddToBag;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout()
{
    
    $cartItems = AddToBag::with('product')->where('user_id', auth()->id())->get();
    $subtotal = 0;
    foreach ($cartItems as $item) {
        $subtotal += $item->price_at_purchase * $item->quantity;
    }

    return view('page.bill', compact('cartItems', 'subtotal'));
}

public function placeOrder(Request $request)
{
    
    $cartItems = AddToBag::with('product')->where('user_id', auth()->id())->get();

    if ($cartItems->isEmpty()) {
        return redirect()->back()->with('error', 'Your cart is empty.');
    }

    $total = $cartItems->sum(fn($item) => $item->price_at_purchase * $item->quantity);

    $order = Order::create([
        'user_id' => auth()->id(),
        'full_name' => $request->full_name,
        'email' => $request->email,
        'mobile_number' => $request->phone,
        'address' => $request->address,
        'city' => $request->city,
        'state' => $request->state,
        'country' => $request->country,
        'pincode' => $request->zipcode,
        'total_amount' => $total,
        'payment_method' => $request->payment_method,
    ]);

    foreach ($cartItems as $item) {
        OrderItems::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price_at_purchase' => $item->price_at_purchase,
        ]);
    }

    AddToBag::where('user_id', auth()->id())->delete();

    return redirect()->back()->with('success', 'Order placed successfully!');
}

}
