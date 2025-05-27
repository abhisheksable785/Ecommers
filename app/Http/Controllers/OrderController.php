<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
public function index()
{
    $orders = Order::with(['user','items','profile'])->get();
    //  return $orders; // No need to eager load products here
    return view('admin.orders.index', compact('orders'));

}
public function view($id)
{
    $order = Order::with(['user', 'items', 'profile'])->findOrFail($id);
    // return $order;
    return view('admin.orders.view', compact('order'));

}
public function order(){
    $orders = Order::with(['items'])->get();
    // return $orders;
    return view('page.orders', compact('orders'));
}
}