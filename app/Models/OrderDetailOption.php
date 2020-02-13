<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetailOption extends Model
{
    protected $fillable = ['order_details_id','product_option_id','price','qty'];
    
    public function option(){
        return $this->belongsTo('App\Models\ProductOption','product_option_id','id');
    }
}
