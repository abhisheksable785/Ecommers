<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Profile;

class OrderController extends Controller
{
public function index()
{
    $orders = Order::with(['users','items'])->paginate(15);
    $profile = Profile::where('user_id',auth()->id())->first();
    //  return $orders; // No need to eager load products here
    return view('admin.orders.index', compact('orders','profile'));

}
// public function view($id)
// {
//     $order = Order::with(['user', 'items', 'profile'])->findOrFail($id);
//     return $order;
//     return view('admin.orders.view', compact('order'));

// }
public function view($id)
{
    $order = Order::with(['users', 'items'])->findOrFail($id);
        $profile= Profile::where('user_id',auth()->id())->first();
 
    
    return view('admin.orders.view', compact('order','profile'));

}
public function order(){

    $orders = Order::with(['items'])->where('user_id', auth()->id())->get();
    // return $orders;
    return view('page.orders', compact('orders'));
}
}