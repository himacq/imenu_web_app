<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetailIngredient extends Model
{
    protected $fillable = ['order_details_id','product_ingredient_id'];

    public function ingredient(){
        return $this->belongsTo('App\Models\ProductIngredient','product_ingredient_id','id');
    }
}
