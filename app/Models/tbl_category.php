<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_category extends Model
{
    use HasFactory;
    protected $table = "tbl_category";
    protected $fillable = ['name', 'image', 'description'];

 public function products()
{
    return $this->hasMany(Product::class, 'category', 'id');
}
}
