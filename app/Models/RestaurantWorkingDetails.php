<?php

namespace App\Models;


class RestaurantWorkingDetails extends BaseModel
{
    protected $fillable = ['restaurant_id','display_text','start_at','end_at'];
}
