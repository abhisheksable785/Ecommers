<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Invoice;

class InvoiceController extends Controller
{

    public function store(Request $request)
{
    $order = Order::with('products')->findOrFail($request->order_id);

    $invoice = new Invoice();
    $invoice->order_id = $order->id;
    $invoice->user_id = $order->user_id; 
    $invoice->invoice_date = now();// Assuming the order has a user_id
    $invoice->total = $order->total_amount; // Assuming the order has a total_amount field
    $invoice->save();

    // Optionally attach items to invoice_products table
    foreach ($order->products as $product) {
       $invoice->products()->attach($product->id, [
        'item_name' => $product->name, // Assuming the product has a name field
    'quantity' => $product->pivot->quantity,
    'price' => $product->price,
]);
    }

    return redirect()->route('invoices.show', $invoice->id)->with('success', 'Invoice created successfully.');
}
public function show($id)
{
   $invoice = Invoice::with(['users.profile', 'products'])->findOrFail($id);

    // return $invoice;
    return view('admin.orders.invoice', compact('invoice'));
}


}
