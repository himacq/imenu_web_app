<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantReview extends Model
{
    protected $fillable = ['user_id','restaurant_id','review_text','review_rank','isActive'];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function restaurant(){
        return $this->belongsTo('App\Models\Restaurant','restaurant_id','id');
    }
}
