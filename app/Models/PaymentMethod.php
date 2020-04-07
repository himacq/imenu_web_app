<?php

namespace App\Models;


class PaymentMethod extends BaseModel
{
    protected $fillable = ['name','api_url','isActive'];

    public function restaurants(){
        return $this->hasMany('App\Models\RestaurantPaymentMethod','payment_id','id');
    }
}
