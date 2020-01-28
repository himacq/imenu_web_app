<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductIngredients extends Model
{
    protected $fillable = ['name','isActive','product_id'];
}
