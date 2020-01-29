<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptions extends BaseModel
{
    protected $fillable = ['name','price','isActive','minutes_required','product_id'];
}
