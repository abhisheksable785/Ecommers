<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AddToBag extends Model
{
    use HasFactory;

    // This should be your cart/bag table name, not product table
    protected $table = 'add_to_bag'; // Changed from 'tbl_product'
    
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'size',
        'color',
        'price_at_purchase'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // REMOVE THIS - Controller logic shouldn't be in model
    // public function add(Request $request) {...}
}