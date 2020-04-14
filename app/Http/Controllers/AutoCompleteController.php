<?php

namespace App\Http\Controllers;

use App\Models\ProductOptionGroup;
use Illuminate\Http\Request;

use App\Models\ProductOption;
use App\Models\Translation;

use DB;

class AutoCompleteController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function option_names($language) {

        if($language=='en')
            $data = ProductOption::all();
        /*$data = DB::selectRaw('distinct product_options.name,ar_translations.display_text as name_ar ,'
        .'tr_translations.display_text as name_tr from product_options left outer join translations ar_translations '
        .' on ar_translations')
            ->having('distance', '<', $request->distance)
            ->having('isActive','=',1);*/


        else
            $data = Translation::where(['model'=>'product_options','field'=>'name','language_id'=>$language])->get();


        return $data;
    }

    public function option_group_names(request $request,$language) {
        if($language=='en')
            $data = ProductOptionGroup::selectRaw('distinct name as value')
                ->Where('name', 'like', '%' . $request->term. '%')
                ->where(['isActive'=>1])->get();

        else
            $data = Translation::where(['model'=>'product_options','field'=>'name','language_id'=>$language])->get();


        return $data;
    }

}
