<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationsQuestionsAnswer extends Model
{
    protected $fillable = ['registration_id','question_id','answer'];
    
    public function question() {
            return $this->belongsTo('App\Models\RegistrationsQuestion','question_id','id');
    }
}
