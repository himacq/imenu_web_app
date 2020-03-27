<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRestaurantReview extends Model
{
    protected $fillable = ['user_id','restaurant_id','review_text','review_rank','isActive'];

}
