<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderRestaurant extends Model
{
    protected $fillable = ['order_id','restaurant_id','sub_total','payment_id','address_id'];

    public function order(){
        return $this->belongsTo('App\Models\Order','order_id','id');
    }

    public function restaurant(){
        return $this->belongsTo('App\Models\Restaurant','restaurant_id','id');
    }

    public function products(){
        return $this->hasMany('App\Models\OrderDetail','order_restaurant_id','id');
    }

    public function status(){
        return $this->hasMany('App\Models\OrderRestaurantStatus','order_restaurant_id','id');
    }


    public function user_review(){
        return $this->hasOne('App\Models\UserReview','order_restaurant_id','id');
    }

    public function payment_method(){
        return $this->belongsTo('App\Models\PaymentMethod','payment_id','id');
    }

    public function address(){
        return $this->belongsTo('App\Models\UserAddress','address_id','id');
    }


}
