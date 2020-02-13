<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id','grand_total'];
    
    public function cartRestaurants(){
        return $this->hasMany('App\Models\CartRestaurant','cart_id','id');
    }
}
