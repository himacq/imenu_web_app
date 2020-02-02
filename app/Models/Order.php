<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id','grand_total','order_status','address_id','payment_id'];
    
    public function details(){
        return $this->hasMany('App\Models\OrderDetail','order_id','id');
    }
    
    public function payment_method(){
        return $this->belongsTo('App\Models\PaymentMethod','payment_id','id');
    }
    
    public function address(){
        return $this->belongsTo('App\Models\UserAddress','address_id','id');
    }
    
    public function status_text(){
        return $this->belongsTo('App\Models\Lookup','order_status','id');
    }
}
