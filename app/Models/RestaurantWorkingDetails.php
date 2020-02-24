<?php

namespace App\Models;


class RestaurantWorkingDetails extends BaseModel
{
    protected $fillable = ['restaurant_id','working_day','start_at','end_at'];
    
    public function day(){
        return $this->belongsTo("App\Models\Lookup",'working_day','id');
    }
}
