<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "tbl_product";
    protected $fillable = [
        'name',
        'image',
        'price',
        'gender',
        'description',
        'category',
        'stock_quantity',
    ];
    protected $casts = [
    'pics' => 'array',
];

    public function category()
{
    return $this->belongsTo(tbl_category::class, 'category');
}
public function wishedByUsers()
{
    return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
}
public function inBags()
{
    return $this->hasMany(AddToBag::class);
}

// AddToBag.php
public function user()
{
    return $this->belongsTo(User::class);
}

public function product()
{
    return $this->belongsTo(Product::class);
}
  
}
