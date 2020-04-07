<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id','grand_total'];

    public function orderRestaurants(){
        return $this->hasMany('App\Models\OrderRestaurant','order_id','id');
    }



    public function customer(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }


}
