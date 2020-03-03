<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProductOption;
use App\Models\Translation;

class AutoCompleteController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function option_names($language) {
        
        if($language=='en')
            $data = ProductOption::all();
        
        else
            $data = Translation::where(['model'=>'product_options','field'=>'name','language_id'=>$language])->get();
        
        
        return $data;
    }
    
}
