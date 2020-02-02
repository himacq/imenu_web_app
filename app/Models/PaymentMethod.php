<?php

namespace App\Models;


class PaymentMethod extends BaseModel
{
    protected $fillable = ['name','api_url','isActive'];
    
}
