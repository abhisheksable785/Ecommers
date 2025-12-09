<?php

namespace App\Http\Controllers\Api;

use App\Helpers\OneSignalHelper;
use OneSignal;
use App\Http\Controllers\Controller;
use App\Models\AddToBag;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class CheckoutController extends Controller
{
     // Generate Order Number (Eg: ORD-000001)
    private function generateOrderNumber()
    {
        $prefix = "ORD";

        $latest = Order::orderBy("id", "DESC")->first();
        $next = $latest ? $latest->id + 1 : 1;

        return $prefix . "-" . str_pad($next, 6, "0", STR_PAD_LEFT);
    }

    // MAIN CHECKOUT API
    public function placeOrderApi(Request $request)
    {
        $userId = auth()->id();
        $user = auth()->user();

        $cartItems = AddToBag::with("product")
            ->where("user_id", $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty.'
            ], 400);
        }

        // Validate Request
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile_number' => 'required|string|max:15',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'zipcode' => 'required|string|max:10',
            'payment_method' => 'required|in:cod,razorpay',
        ]);

        // Total Amount
        $total = $cartItems->sum(function ($item) {
            return $item->price_at_purchase * $item->quantity;
        });

        /*
        |--------------------------------------------------------------------------
        | 1️⃣ CASH ON DELIVERY
        |--------------------------------------------------------------------------
        */
        if ($request->payment_method === 'cod') {

            $order = Order::create([
                'user_id' => $userId,
                'order_number' => $this->generateOrderNumber(),
                'full_name' => $request->full_name,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'pincode' => $request->zipcode,
                'total_amount' => $total,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItems::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price_at_purchase' => $item->price_at_purchase,
                    'size' => $item->size,
                ]);
            }

            AddToBag::where('user_id', $userId)->delete();
            
            if ($user->onesignal_player_id) {
                \App\Helpers\OneSignalHelper::sendToUser(
                    $user->onesignal_player_id,
                    "Order Placed Successfully 🛒",
                    "Your order {$order->order_number} is confirmed! Total: ₹{$order->total_amount}"
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $order->id
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 2️⃣ ONLINE PAYMENT (RAZORPAY ORDER CREATION)
        |--------------------------------------------------------------------------
        */
        if ($request->payment_method === 'razorpay') {

            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $razorpayOrder = $api->order->create([
                'receipt' => 'RZP_' . uniqid(),
                'amount' => $total * 100,
                'currency' => 'INR',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Razorpay order created.',
                'razorpay_order_id' => $razorpayOrder['id'],
                'key' => env('RAZORPAY_KEY'),
                'amount' => $total * 100,
                'customer' => [
                    'name' => $request->full_name,
                    'email' => $request->email,
                    'mobile' => $request->mobile_number
                ]
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 3️⃣ VERIFY PAYMENT (After Razorpay success)
    |--------------------------------------------------------------------------
    */
   public function verifyPayment(Request $request)
{
    $request->validate([
        'razorpay_payment_id' => 'required',
        'razorpay_order_id' => 'required',
        'razorpay_signature' => 'required',
        // Proper field names matching DB
        'full_name' => 'required',
        'email' => 'required',
        'mobile_number' => 'required',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'country' => 'required',
        'zipcode' => 'required',
    ]);

    $userId = auth()->id();
    $user = auth()->user();
    $cartItems = AddToBag::where("user_id", $userId)->get();

    if ($cartItems->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'Cart empty'], 400);
    }

    $total = $cartItems->sum(fn($i) => $i->price_at_purchase * $i->quantity);

    // VERIFY SIGNATURE
    $generated = hash_hmac(
        'sha256',
        $request->razorpay_order_id . "|" . $request->razorpay_payment_id,
        env('RAZORPAY_SECRET')
    );

    if ($generated !== $request->razorpay_signature) {
        return response()->json(['success' => false, 'message' => 'Payment verification failed'], 400);
    }

    // PAYMENT VERIFIED -> CREATE ORDER
    $order = Order::create([
        'user_id' => $userId,
        'order_number' => $this->generateOrderNumber(),

        'full_name' => $request->full_name,
        'email' => $request->email,
        'mobile_number' => $request->mobile_number,   // FIXED
        'address' => $request->address,
        'city' => $request->city,
        'state' => $request->state,
        'country' => $request->country,
        'pincode' => $request->zipcode,               // FIXED

        'total_amount' => $total,
        'payment_method' => 'razorpay',
        'payment_status' => 'success',
        'status' => 'processing',
    ]);

    // SAVE ORDER ITEMS
    foreach ($cartItems as $item) {
        OrderItems::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price_at_purchase' => $item->price_at_purchase,
            'size' => $item->size,
        ]);
    }
    
    AddToBag::where('user_id', $userId)->delete();
    if ($user->onesignal_player_id) {
                \App\Helpers\OneSignalHelper::sendToUser(
                    $user->onesignal_player_id,
                    "Order Placed Successfully 🛒",
                    "Your order {$order->order_number} is confirmed! Total: ₹{$order->total_amount}"
                );
            }

    return response()->json([
        'success' => true,
        'message' => 'Payment verified & order placed.',
        'order_id' => $order->id
    ]);
}

}
