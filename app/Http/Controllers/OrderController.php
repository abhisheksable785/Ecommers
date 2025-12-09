<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Profile;

class OrderController extends Controller
{
public function index()
{
    $orders = Order::with(['user', 'items'])->latest()->paginate(15);
    
    // Calculate stats for widgets
    $totalPending = Order::where('status', 'pending')->count();
    $totalCompleted = Order::where('status', 'completed')->count();
    $totalRefunded = Order::where('status', 'refunded')->count();
    $totalFailed = Order::where('status', 'failed')->count();

    return view('admin.orders.index', compact(
        'orders', 
        'totalPending', 
        'totalCompleted', 
        'totalRefunded', 
        'totalFailed'
    ));
}
public function userOderApi(){
    $user = auth()->user();
    $orders = Order::orderBy('id', 'desc')->with(['user', 'items'])->where('user_id', $user->id)->get();
    return response()->json([
        'status' => true,
        'message' => 'Retrieve all Orders',
        'data' => ['orders' => $orders]
    ]);
}
// public function view($id)
// {
//     $order = Order::with(['user', 'items', 'profile'])->findOrFail($id);
//     return $order;
//     return view('admin.orders.view', compact('order'));

// }
public function view($id)
{
    $order = Order::with(['user', 'items.product'])->findOrFail($id);
    $userProfile = \App\Models\Profile::where('user_id', $order->user_id)->first();
    return view('admin.orders.view', compact('order', 'userProfile'));
}
public function order(){

    $orders = Order::with(['items'])->where('user_id', auth()->id())->get();
    // return $orders;
    return view('page.orders', compact('orders'));
}
}