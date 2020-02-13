<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Models\Favourite;
use App\Http\Resources\Favourite as FavouriteResource;


class FavouriteController extends ApiController
{  
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * add to favourites
     */
    
    public function createFavourite(Request $request){
        $rules = [
            'product_id' => 'required|integer',
        ];
        
          $validate = Validator::make($request->all(), $rules);
          if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }
        
        $favourite = Favourite::create([
            'product_id' => $request->product_id,
            'user_id'   => $this->user->id
        ]);
        return $this->response($favourite->toArray(), true,__('api.success'));
    }
    
    /**
     * Delete Favourite
     * @param type $id
     */
    public function deleteFavourite($id){
        if (!$id) {
            return $this->response(null, false,__('api.not_found'));
        }
        $favourite= Favourite::where(['user_id'=>$this->user->id,'id'=>$id])->first();
        if (!$favourite) {
            return $this->response(null, false,__('api.not_found'));
        }
        
        $favourite->delete();
      
        return $this->response(null, true,__('api.success'));
        
    }
    
    public function listFavourites(){
          $favourites = FavouriteResource::Collection($this->user->getFavourites);
        
        return $favourites->additional(['status'=>true,'message'=>__('api.success')]);
    }
}
