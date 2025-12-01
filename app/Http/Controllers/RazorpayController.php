<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Session;

class RazorpayController extends Controller
{

    public function initiatePayment(Request $request)
{
    $input = $request->all();

    $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

    // Amount in paisa
    $amount = 100; // ₹500

    $razorpayOrder = $api->order->create([
        'receipt' => '1',
        'amount' => $amount,
        'currency' => 'INR'
    ]);

    $orderId = $razorpayOrder['id'];

    return view('page.payment', compact('orderId', 'amount'));
}
    public function payment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $payment = $api->payment->fetch($request->razorpay_payment_id);

        if ($payment->capture(['amount'=>$payment['amount']])) {
            Session::flash('success', 'Payment successful');
            return redirect()->back();
        } else {        
            Session::flash('error', 'Payment failed');
            return redirect()->back();
        }
    }
    public function verifyPayment(Request $request)
{
    $signatureStatus = false;
    try {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];

        $api->utility->verifyPaymentSignature($attributes);
        $signatureStatus = true;
    } catch (\Exception $e) {
        $signatureStatus = false;
    }

    if ($signatureStatus) {
        // ✅ Success: Order Place karo
        // Example:
        // Order::create([...])
        return redirect()->route('checkout')->with('success', 'Payment Successful');
    } else {
        // ❌ Failed
        return redirect()->route('checkout')->with('error', 'Payment Failed');
    }
}
public function razorpaySuccess(Request $request)
{
    if (Session::has('order_details')) {
        $orderDetails = Session::get('order_details');

        // Save the order in DB
        // Example: Order::create([...]);

        Session::forget('order_details');
        return redirect()->back()->with('success', 'Payment successful! Order placed.');
    }

    return redirect()->back()->with('error', 'Something went wrong.');
}

}
