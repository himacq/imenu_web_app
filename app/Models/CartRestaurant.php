<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartRestaurant extends Model
{
    protected $fillable = ['cart_id','restaurant_id','sub_total'];
    
    public function restaurant(){
        return $this->belongsTo('App\Models\Restaurant','restaurant_id','id');
    }
    
    public function products(){
        return $this->hasMany('App\Models\CartDetail','cart_restaurant_id','id');
    }
    
    
}
