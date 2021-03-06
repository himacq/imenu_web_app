<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = ['order_restaurant_id','product_id','qty','price'];

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }

    public function options(){
        return $this->hasMany('App\Models\OrderDetailOption','order_details_id','id');
    }

    public function ingredients(){
        return $this->hasMany('App\Models\OrderDetailIngredient','order_details_id','id');
    }

    public function order_restaurant(){
        return $this->belongsTo('App\Models\OrderRestaurant','order_restaurant_id','id');
    }

}
