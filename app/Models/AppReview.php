<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppReview extends Model
{
    protected $fillable = ['user_id','review_text','review_rank','isActive'];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
