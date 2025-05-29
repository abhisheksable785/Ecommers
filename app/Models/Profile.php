<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profile'; // Optional: only needed if your table is not the default plural form (profiles)

    protected $fillable = [
        'user_id',
        'full_name',
        'mobile_number',
        'email',
        'birthday',
        'address',
        'city',
        'pincode',
    ];

    // Define the relationship: A profile belongs to a user

public function orders()
{
    return $this->hasMany(Order::class);
}
public function users(){
    return $this->belongsTo(User::class,'user_id');
}
}
