<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppReview extends Model
{
    protected $fillable = ['user_id','review_text','review_rank','isActive'];
    
}
