<?php

namespace App\Models;


class Restaurant extends BaseModel
{

    protected $fillable = ['email','mobile2','mobile1','phone3','phone2','phone1','extra_info'
        ,'longitude','latitude','branch_of','owner_id','verification_code'
        ,'isActive','banner','logo','name','commision','discount','distance'];

    public function classifications(){
        return $this->hasMany('App\Models\RestaurantClassification','restaurant_id','id');
    }

    public function payment_methods(){
        return $this->hasMany('App\Models\RestaurantPaymentMethod','restaurant_id','id');
    }
    public function owner() {
            return $this->belongsTo('App\Models\User','owner_id','id');
    }

    public function main_branch() {
            return $this->belongsTo('App\Models\Restaurant','branch_of','id');
    }

    public function branches(){
        return $this->hasMany('App\Models\Restaurant','branch_of','id');
    }


    public function category_text(){
        return $this->belongsTo('App\Models\Lookup','category','id');
    }

    public function reviews(){
       return $this->hasMany('App\Models\RestaurantReview','restaurant_id','id')->where('isActive',1);
    }


    public function categories(){
        return $this->hasMany('App\Models\Category','restaurant_id','id');
    }

    public function working_details(){
        return $this->hasMany('App\Models\RestaurantWorkingDetails','restaurant_id','id');
    }

    public function orders(){
        return $this->hasMany('App\Models\OrderRestaurant','restaurant_id','id');
    }






}
