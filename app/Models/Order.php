<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'full_name',
        "order_number",
        'email',
        'mobile_number',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'total',
        'status',
        'total_amount',
        'payment_method',
        'payment_status',
        // add any other required fields
    ];
    public function items()
{
    return $this->hasMany(OrderItems::class);
}
public function products()
{
    return $this->belongsToMany(Product::class, 'order_items')
                ->withPivot('quantity', 'price_at_purchase');

}
public function user() {
    return $this->belongsTo(User::class);
}
public function profile()
{
    return $this->belongsTo(Profile::class);
}


}