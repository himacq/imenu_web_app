<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantBilling extends Model
{
    protected $fillable = ['restaurant_id','branch_id','payment_id','sub_total','order_id','order_restaurant_id','commision','discount',
        'restaurant_distance','order_distance','distance_exceeded','credit','debit','paid','paid_at'];

    public function order(){
        return $this->belongsTo('App\Models\Order','order_id','id');
    }

    public function order_restaurant(){
        return $this->belongsTo('App\Models\OrderRestaurant','order_restaurant_id','id');
    }

    public function restaurant(){
        return $this->belongsTo('App\Models\Restaurant','restaurant_id','id');
    }

    public function branch(){
        return $this->belongsTo('App\Models\Restaurant','branch_id','id');
    }

    public function payment_method(){
        return $this->belongsTo('App\Models\PaymentMethod','payment_id','id');
    }

    public function address(){
        return $this->belongsTo('App\Models\UserAddress','address_id','id');
    }


}
