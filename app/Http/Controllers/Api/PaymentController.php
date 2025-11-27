<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AddToBag;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
 public function paymentVerify(Request $request)
{
    $request->validate([
        'razorpay_payment_id' => 'required',
        'razorpay_order_id' => 'required',
        'razorpay_signature' => 'required',

        // Also pass user checkout form
        'full_name' => 'required',
        'email' => 'required',
        'mobile_number' => 'required',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'country' => 'required',
        'zipcode' => 'required',
    ]);

    $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

    try {
        $api->utility->verifyPaymentSignature([
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Verification failed'
        ], 400);
    }

    // ✔ Payment OK → create order
    $cartItems = AddToBag::where('user_id', auth()->id())->get();
    $total = $cartItems->sum(fn($i) => $i->price_at_purchase * $i->quantity);

    $order = Order::create([
        'user_id' => auth()->id(),
        'order_number' => 'ORD-'.rand(11111,99999),
        'full_name' => $request->full_name,
        'email' => $request->email,
        'mobile_number' => $request->mobile_number,
        'address' => $request->address,
        'city' => $request->city,
        'state' => $request->state,
        'country' => $request->country,
        'pincode' => $request->zipcode,
        'total_amount' => $total,
        'payment_method' => 'online',
        'payment_status' => 'paid',
        'order_date' => now(),
        'status' => 'processing',
        'payment_id' => $request->razorpay_payment_id
    ]);

    foreach ($cartItems as $item) {
        OrderItems::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price_at_purchase' => $item->price_at_purchase,
            'size' => $item->size
        ]);
    }

    AddToBag::where('user_id', auth()->id())->delete();

    return response()->json([
        'success' => true,
        'message' => 'Order placed successfully',
        'order_id' => $order->id
    ]);
}


}
