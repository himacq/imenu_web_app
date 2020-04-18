<?php

namespace App\Models;


class Classification extends BaseModel
{
    protected $fillable = ['name','image','isActive'];

    public function restaurants(){
        return $this->hasMany('App\Models\RestaurantClassification','classification_id','id');
    }

}
