<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id','grand_total','address_id','payment_id'];
    
    public function orderRestaurants(){
        return $this->hasMany('App\Models\OrderRestaurant','order_id','id');
    }
    
    public function payment_method(){
        return $this->belongsTo('App\Models\PaymentMethod','payment_id','id');
    }
    
    public function address(){
        return $this->belongsTo('App\Models\UserAddress','address_id','id');
    }
    
    public function customer(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    
    
}
