<?php

namespace App\Models;

use App\Models\BaseModel;

class ProductReview extends BaseModel
{
    protected $fillable = ['user_id','product_id','review_text','review_rank','isActive'];

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }

}
