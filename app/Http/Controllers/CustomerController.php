<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
   
public function index()
{
    $allCustomers = User::withCount('orders')
        ->withSum('orders as total_spent', 'total_amount')
        ->get();

    return view('admin.Customer.all', compact('allCustomers'));
}
public function show($id)
{
    $customer = User::with('orders')->findOrFail($id);

    return view('admin.Customer.details', compact('customer'));
}
}
