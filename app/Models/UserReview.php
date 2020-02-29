<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{
    protected $fillable = ['user_id','order_restaurant_id','review_text','review_rank','isActive'];
    
}
