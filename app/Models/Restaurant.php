<?php

namespace App\Models;


class Restaurant extends BaseModel
{
            
    protected $fillable = ['category','email','mobile2','mobile1','phone3','phone2','phone1','extra_info'
        ,'longitude','latitude','branch_of','manager_id','verification_code'
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
    
    public function category_text(){
        return $this->belongsTo('App\Models\Lookup','category','id');
    }
    
    public function reviews(){
       return $this->hasMany('App\Models\RestaurantReview','restaurant_id','id');
    }
    
    
    public function categories(){
        return $this->hasMany('App\Models\Category','restaurant_id','id');
    }
    
    public function working_details(){
        return $this->hasMany('App\Models\RestaurantWorkingDetails','restaurant_id','id');
    }
    
   /* public function ranks(){
        
        $total = DB::table('restaurant_reviews')
                ->where(['restaurant_id'=>$this->id])
                ->sum('review_rank');
        $count = DB::table('restaurant_reviews')
                ->where(['restaurant_id'=>$this->id])->count();
        
        $x = $total/$count;
        
       return $x;
    }
    * */
    
    
   
    
    
    
}
