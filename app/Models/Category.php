<?php

namespace App\Models;


class Category extends BaseModel
{
    protected $fillable = ['name','image','isActive','restaurant_id'];
    
    public function restaurant(){
        return $this->belongsTo('App/Models/Restaurant','restaurant_id','id');
    }
}
