<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    
    
public function contacts() {
        return DB::table('lookups')->where('lookup_parent', 70)->get();
    }


    public function lookup_title($id) {

        return DB::table('lookups')->where('lookup_id', $id)->first();
    }

    /**
     * 
     * @param type $data
     * @param type $status
     * @return type
     */
    public function response($data,$status,$messages = null){
        return response()->json(['status'=>$status,'message'=>$messages,'data' => $data], 200);
    }
}
