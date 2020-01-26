<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App;
class BaseModel extends Model
{
    
    
    public function translate($field){
        if(App::getLocale()=='en')
            return $this->$field;
        
        $translation = DB::table('translations')
                ->where(['model'=>$this->getTable(),'field'=>$field,'record_id'=>$this->id,'language_id'=>App::getLocale()])
                ->value('display_text');
        
        if(!$translation)
            return $this->$field;
        
        return $translation;
    }
}
