<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderRestaurant extends Model
{
    protected $fillable = ['order_id','restaurant_id','sub_total'];
    
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
    
    
}
