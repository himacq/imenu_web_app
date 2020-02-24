<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantRegistration extends Model
{
   protected $fillable = ['user_id','name','id_img','license_img','education_level','city'
       ,'locality','address','duty','starting','ending','email','phone','business_title'
       ,'branches_count','branches','status'];
   
   public function owner() {
            return $this->belongsTo('App\Models\User','user_id','id');
    }
    
    public function status_text(){
        return $this->belongsTo('App\Models\Lookup','status','id');
    }
    
    public function questions_answers(){
        return $this->hasMany('App\Models\RegistrationsQuestionsAnswer','registration_id','id');
    }
}
