<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    
    protected $table = "user_addresses";
    protected $fillable = ['user_id','street','city','house_no','governorate','zip_code','isDefault'];
    
    public function user() {
            return $this->belongsTo('App\Models\User');
        }
}
