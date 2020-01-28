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
        return $this->hasMany('App\Models\ProductIngredients','product_id','id');
    }
    
    public function options(){
        return $this->hasMany('App\Models\ProductOptions','product_id','id');
    }
    
    
}
