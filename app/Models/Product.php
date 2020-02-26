<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends BaseModel
{
    protected $fillable = ['name','image','price','isActive','minutes_required','category_id'];
    
    public function category(){
        return $this->belongsTo('App\Models\Category','category_id','id');
    }
    
    public function ingredients(){
        return $this->hasMany('App\Models\ProductIngredient','product_id','id');
    }
    
    public function option_groups(){
        return $this->hasMany('App\Models\ProductOptionGroup','product_id','id');
    }
    
    public function order_details(){
        return $this->hasMany('App\Models\OrderDetail','product_id','id');
    }
    
    
}
