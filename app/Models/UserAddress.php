<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{

    protected $table = "user_addresses";
    protected $fillable = ['user_id','formated_address','description','address_type','street','city','house_no','house_name'
        ,'floor_no','apartment_no','governorate','zip_code','latitude','longitude','isDefault'];

    public function user() {
            return $this->belongsTo('App\Models\User');
        }
}
