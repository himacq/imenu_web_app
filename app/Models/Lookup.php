<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lookup extends BaseModel
{
    protected $table = 'lookup';
    protected $fillable = ['display_text' , 'description', 'parent_id', 'notes'];


}
