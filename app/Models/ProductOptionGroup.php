<?php

namespace App\Models;


class ProductOptionGroup extends BaseModel
{
    protected $fillable = ['name','isActive','product_id','minimum','maximum'];
    
    public function options(){
        return $this->hasMany('App\Models\ProductOption','group_id','id');
    }
}
