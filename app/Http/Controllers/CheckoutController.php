<?php

namespace App\Http\Controllers;

use App\Models\AddToBag;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Session;

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
        'mobile_number' => 'required|numeric|max_digits:10',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'country' => 'required|string|max:100',
        'zipcode' => 'required|string|max:10',
        'payment_method' => 'required|string|in:cash_on_delivery,online_payment',
    ]);

    if ($request->payment_method === 'cash_on_delivery') {
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
            'payment_method' => 'cash_on_delivery',
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

    // Razorpay flow
    if ($request->payment_method === 'online_payment') {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $razorpayOrder = $api->order->create([
            'receipt' => 'ORDER_' . uniqid(),
            'amount' => $total * 100, // Razorpay uses paise
            'currency' => 'INR'
        ]);

        Session::put('razorpay_order_id', $razorpayOrder['id']);
        Session::put('order_cart_items', $cartItems);
        Session::put('order_total', $total);
        Session::put('order_form', $request->only([
            'full_name', 'email', 'mobile_number', 'address',
            'city', 'state', 'country', 'zipcode'
        ]));

        return view('payment.razorpay', [
            'razorpayOrderId' => $razorpayOrder['id'],
            'amount' => $total * 100,
            'key' => env('RAZORPAY_KEY'),
            'customer' => $request->only(['full_name', 'email', 'mobile_number']),
        ]);
    }
}
public function razorpaySuccess(Request $request)
{
    if (!Session::has('order_form') || !Session::has('order_cart_items')) {
        return redirect()->route('bag.index')->with('error', 'Session expired or invalid!');
    }

    $form = Session::get('order_form');
    $cartItems = Session::get('order_cart_items');
    $total = Session::get('order_total');

    $order = Order::create([
        'user_id' => auth()->id(),
        'full_name' => $form['full_name'],
        'email' => $form['email'],
        'mobile_number' => $form['mobile_number'],
        'address' => $form['address'],
        'city' => $form['city'],
        'state' => $form['state'],
        'country' => $form['country'],
        'pincode' => $form['zipcode'],
        'total_amount' => $total,
        'payment_method' => 'online_payment',
    ]);

    foreach ($cartItems as $item) {
        OrderItems::create([
            'order_id' => $order->id,
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'price_at_purchase' => $item['price_at_purchase'],
        ]);
    }

    AddToBag::where('user_id', auth()->id())->delete();

    Session::forget(['order_form', 'order_cart_items', 'razorpay_order_id', 'order_total']);

    return redirect()->route('bag.index')->with('success', 'Payment successful and order placed!');
}


}
