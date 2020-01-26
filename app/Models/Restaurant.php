<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends BaseModel
{
            
    protected $fillable = ['email','mobile2','mobile1','phone3','phone2','phone1','extra_info'
        ,'working_details','longitude','latitude','branch_of','manager_id','verification_code'
        ,'status','banner','logo','name'];
    
    public function manager() {
            return $this->belongsTo('App\Models\User','manager_id','id');
    }
    
    public function main_branch() {
            return $this->belongsTo('App\Models\Restaurant','branch_of','id');
    }
    
    public function branches(){
        return $this->hasMany('App\Models\Restaurant','branch_of','id');
    }
    
    public function status_text(){
        return $this->belongsTo('App\Models\Lookup','status','id');
    }
    
    
    
}
