<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartDetailOption extends Model
{
    protected $fillable = ['cart_details_id','product_option_id','price','qty'];
    
    public function option(){
        return $this->belongsTo('App\Models\ProductOption','product_option_id','id');
    }
}
