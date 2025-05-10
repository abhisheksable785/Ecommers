<?php

namespace App\Http\Controllers;

use App\Models\AddToBag;
use Illuminate\Http\Request;

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
}
