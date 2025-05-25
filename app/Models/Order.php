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
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'total',
        'status',
        'total_amount',
        'payment_method',
        // add any other required fields
    ];
    public function items()
{
    return $this->hasMany(OrderItems::class);
}

}
