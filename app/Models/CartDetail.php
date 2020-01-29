<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    protected $fillable = ['cart_id','product_id','qty','price'];
    
    public function product(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }
    
    public function options(){
        return $this->hasMany('App\Models\CartDetailOption','cart_details_id','id');
    }
}
