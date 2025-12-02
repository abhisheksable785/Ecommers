<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'is_verified_purchase',
        'is_approved',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function images()
    {
        return $this->hasMany(ReviewImage::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}
