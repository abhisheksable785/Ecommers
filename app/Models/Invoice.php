<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];
public function products()
    {
        return $this->belongsToMany(Product::class, 'invoice_items')  // specify pivot table here
                    ->withPivot('quantity');
    }
public function users()
{
    return $this->belongsTo(User::class);
}

public function items()
{
    return $this->hasMany(OrderItems::class);
}


}
