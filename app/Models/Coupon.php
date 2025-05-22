<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
     protected $fillable = ['code', 'type', 'value'];

public function discount($subtotal)
{
    if ($this->type === 'fixed') {
        return $this->value;
    } elseif ($this->type === 'percent') {
        return ($subtotal * $this->value) / 100;
    }
    return 0;
}
public function cartItems()
{
    return $this->hasMany(AddToBag::class); // Adjust if your cart table/model is different
}
}
