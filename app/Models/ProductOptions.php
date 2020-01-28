<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptions extends Model
{
    protected $fillable = ['name','extra_price','isActive','minutes_required','product_id'];
}
