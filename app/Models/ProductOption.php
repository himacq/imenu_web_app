<?php

namespace App\Models;


class ProductOption extends BaseModel
{
    protected $fillable = ['name','price','isActive','minutes_required','group_id'];
}
