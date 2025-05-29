<?php

namespace App\Http\Controllers;

use App\Models\AddToBag;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout()
{
    
    $cartItems = AddToBag::with('product')->where('user_id', auth()->id())->get();
    $profile= Profile::where('user_id',auth()->id())->first();
    $subtotal = 0;
    foreach ($cartItems as $item) {
        $subtotal += $item->price_at_purchase * $item->quantity;
    }
    // return $profile;

    return view('page.bill', compact('cartItems', 'subtotal' ,'profile'));
}

public function placeOrder(Request $request)
{
   

    $cartItems = AddToBag::with('product')->where('user_id', auth()->id())->get();

    if ($cartItems->isEmpty()) {
        return redirect()->back()->with('error', 'Your cart is empty.');
    }

    $total = $cartItems->sum(fn($item) => $item->price_at_purchase * $item->quantity);
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'mobile_number' => 'required|numeric|max_digits:10', // Adjust max length as needed
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'country' => 'required|string|max:100',
        'zipcode' => 'required|string|max:10',
        'payment_method' => 'string|in:cash_on_delivery,online_payment', // Adjust as needed
    ]);

    $order = Order::create([
        'user_id' => auth()->id(),
        'full_name' => $request->full_name,
        'email' => $request->email,
        'mobile_number' => $request->mobile_number,
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
