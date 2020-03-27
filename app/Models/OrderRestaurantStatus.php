<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderRestaurantStatus extends Model
{
    protected $fillable = ['order_restaurant_id','status'];

    public function status_text(){
        return $this->belongsTo('App\Models\Lookup','status','id');
    }

    public function order_restaurant(){
        return $this->belongsTo('App\Models\OrderRestaurant','order_restaurant_id','id');
    }


}
