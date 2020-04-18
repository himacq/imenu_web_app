<?php

namespace App\Models;


class RestaurantClassification extends BaseModel
{
    protected $fillable = ['restaurant_id','classification_id'];

    public function classification(){
        return $this->belongsTo("App\Models\Classification",'classification_id','id');
    }
}
