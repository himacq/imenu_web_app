<?php

namespace App\Models;


class PaymentMethod extends BaseModel
{
    protected $fillable = ['name','api_url','isActive'];

    public function orders(){
        return $this->hasMany('App\Models\Order','payment_id','id');
    }
}
