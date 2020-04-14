<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavouriteRestaurant extends Model
{
    protected $fillable = ['user_id','restaurant_id'];

    public function restaurant(){
        return $this->belongsTo('App\Models\Restaurant','restaurant_id','id');
    }

}
