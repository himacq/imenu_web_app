<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;


class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'name', 'email', 'password', 'isActive','username','phone','mobile','restaurant_id','api_token',
        'language_id','latitude','longitude','news_letter'
    ];
    
    protected $nullable = ['latitude','longitude'];
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

     
    public function app_reviews(){
        return $this->hasMany('App\Models\AppReview','user_id','id');
    }

    public function roles() {
        return $this->belongsToMany('App\Models\Role');
    }
    
    public function restaurant() {
        return $this->belongsTo('App\Models\Restaurant','restaurant_id','id');
    }


    public function getAddresses(){
        return $this->hasMany('App\Models\UserAddress','user_id','id');
    }
    
    public function getFavourites(){
        return $this->hasMany('App\Models\Favourite','user_id','id');
    }

    public function getCart(){
        return $this->hasOne('App\Models\Cart','user_id','id');
    }
    public function generateToken()
    {
        $this->api_token = str_random(32);
        $this->save();

        return $this->api_token;
    }
    public function deleteToken() {
        $this->api_token = null;
        $this->save();
    }
}
