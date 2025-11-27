<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsAcceptance extends Model
{
    use HasFactory;
    protected $table = 'terms_acceptance'; 
     protected $fillable = ['user_id', 'accepted', 'accepted_at'];
}
