<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantBilling extends Model
{
    protected $fillable = ['restaurant_id','payment_id','sub_total','order_id','order_restaurant_id','commision','discount',
        'restaurant_distance','order_distance','distance_exceeded','credit','debit'];
}
