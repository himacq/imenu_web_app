<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantPaymentMethod extends Model
{
    protected $fillable = ['restaurant_id','payment_id'];

public function method(){
    return $this->belongsTo('App\Models\PaymentMethod','payment_id','id');
}
}
