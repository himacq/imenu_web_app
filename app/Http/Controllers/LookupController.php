<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Lookup;

use App\Http\Resources\Lookup as LookupResource;
use App\Http\Resources\LookupCollection;
use Validator;
use Request;

class LookupController extends Controller {

    public function __construct() {
        $this->change_language();

        $this->middleware('role:superadmin', ['except' => ['show', 'getData', 'getChildren']]);
        $this->data['menu'] = 'system';
        $this->data['selected'] = 'system';
        $this->data['location'] = trans('main.lookup');
        $this->data['location_title'] = trans('main.lookup');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $this->data['sub_menu'] = 'lookup';
        $this->data['mains'] = Lookup::where(['parent_id' => 0])->get();
        return view('lookup.lookup', $this->data);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function Show($id) {
        $data = Lookup::where(['id' => $id])->first();
        $data->display_text_ar = $data->translate('display_text','ar');
        $data->description_ar = $data->translate('description','ar');
        $data->display_text_tr = $data->translate('display_text','tr');
        $data->description_tr = $data->translate('description','tr');
        
        return ['data'=>$data];
    }

    public function level($id) {
        return new LookupCollection(Lookup::where(['parent_id' => $id])->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function Update($id) {
        $input = Request::All();
        
        $lookup = Lookup::findOrFail($id);
        $lookup->update(
                [
                    'display_text'=>$input['name'],
                    'description'=>$input['description']
                ]);
        
        $this->new_translation($id,'ar','lookup','display_text',$input['name_ar1']);
        $this->new_translation($id,'ar','lookup','description',$input['description_ar1']);
        
        $this->new_translation($id,'tr','lookup','display_text',$input['name_tr1']);
        $this->new_translation($id,'tr','lookup','description',$input['description_tr1']);
        
        return json_encode(['id'=>$id,'display_text'=>$lookup->translate('display_text')]);
        
    }

    
    /**
     * save a new record.
     *
     * @param  int  $id
     * @return Response
     */
    public function Store($id) {
        $input = Request::All();
        
        $lookup = Lookup::create(
                [
                    'parent_id'=>$id,
                    'display_text'=>$input['name'],
                    'description'=>$input['description']
                ]);
        
        $this->new_translation($lookup->id,'ar','lookup','display_text',$input['name_ar1']);
        $this->new_translation($lookup->id,'ar','lookup','description',$input['description_ar1']);
        
        $this->new_translation($lookup->id,'tr','lookup','display_text',$input['name_tr1']);
        $this->new_translation($lookup->id,'tr','lookup','description',$input['description_tr1']);
        
       return json_encode(['id'=>$lookup->id,'display_text'=>$lookup->translate('display_text')]);
        
    }


}
