<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Category;

class CategoryController extends Controller
{
    
    public function __construct()
    {
        $this->change_language();
        $this->middleware('permission:catalog-manage');
        $this->data['menu'] = 'catalog';
        $this->data['selected'] = 'category';
        $this->data['location'] = 'categories';
        $this->data['location_title'] = __('main.categories');
        $this->data['sub_menu'] = 'category';

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('category.index', $this->data);
    }
    
    /**
     * return dataTable
     * @param Request $request
     * @return type
     */

    public function contentListData(Request $request)
    {
       if( $this->user->hasRole('superadmin'))
        $categories = Category::all();
       else
           $categories = Category::where(['restaurant_id'=>$this->user->restaurant_id])->get();
       
          return DataTables::of($categories)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;

            
            })
             
            ->addColumn('restaurant', function ($model) {
                return $model->restaurant->translate('name');

            })
            ->addColumn('active', function ($model) {


                $activeON = "";
                $activeOff = "";
                $model->isActive !=0 ? $activeON = "active" : $activeOff = "active";
                return '<div class="btn-group btnToggle" data-toggle="buttons" style="position: relative;margin:5px;">
                              <input type="hidden" class="id_hidden" value="' . $model->id . '">
                              <label class="btn btn-default btn-on-1 btn-xs ' . "$activeON" . '">
                              <input   type="radio" value="1" name="multifeatured_module[module_id][status]" >ON</label>
                              <label class="btn btn-default btn-off-1 btn-xs ' . "$activeOff" . '">
                              <input  type="radio" value="0" name="multifeatured_module[module_id][status]">OFF</label>
                           </div>';


            })
            
            ->addColumn('control', function ($model) {
                $id = $model->id;
                $html =  "<a class='btn btn-primary btn-sm' href = '" . url("categories/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a> ";
                if(!count($model->products))
                  $html.= "<a class='btn btn-danger btn-sm delete' ><input type = 'hidden' class='id_hidden' value = '" . $id . "' > <i class='fa fa-remove' ></i ></a > ";

                $html.='<a href="' . url("categories/" . $id ) . '"  class="btn btn-sm blue"><i class="fa fa-file-o"></i> '.__('main.copy').' </a>';
                
                return $html;
            })
            ->rawColumns(['restaurant','control','active'])
            ->make(true);

    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
     public function activeCategory(Request $request)
    {
        $isActive = $request->active;
        $category = Category::find($request->id);
        if($this->check_user_authority($category))
           return  redirect()->route('logout');
        
        
        $category->update([
            'isActive' => $isActive,
        ]);

    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
        public function check_user_authority($category){
        if( $this->user->hasRole('superadmin'))
                return false ;
            
        if(($this->user->restaurant_id==$category->restaurant_id) && $this->user->can('catalog-manage'))
               return false;
     
       return true;
        
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        
        $category = Category::create([
                 'name' => $request->name,
                 'restaurant_id'=>$this->user->restaurant_id,
                'isActive'=>$request->isActive,
             ]);
       
       if($request->image){
             $file = $request->file('image');
             $filename = "image-".$category->id.".".$file->getClientOriginalExtension();
                
                //Move Uploaded File
                $destinationPath = 'uploads/categories/';
                $file->move($destinationPath,$filename);
                
                $category->update([
                 'image' => $filename
             ]);
                
        }
        if($category){
        $this->new_translation($category->id,'ar','categories','name',$request['name_ar']);
        $this->new_translation($category->id,'tr','categories','name',$request['name_tr']);
        
        }
        
        return redirect()->route('categories.index')->with('status', trans('main.success'));
    }
    
    /**
     * Store a copied resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_copy(Request $request)
    {    
        
        $category = Category::create([
                 'name' => $request->name,
                 'restaurant_id'=>$this->user->restaurant_id,
                'isActive'=>$request->isActive,
             ]);
       
       if($request->image){
             $file = $request->file('image');
             $filename = "image-".$category->id.".".$file->getClientOriginalExtension();
                //Move Uploaded File
                $destinationPath = 'uploads/categories/';
                $file->move($destinationPath,$filename);
                
        }
        else
            $filename = $request->old_image;
        
        
        $category->update([
                 'image' => $filename
             ]);
        
        if($category){
        $this->new_translation($category->id,'ar','categories','name',$request['name_ar']);
        $this->new_translation($category->id,'tr','categories','name',$request['name_tr']);
        
        }
        
        return redirect()->route('categories.index')->with('status', trans('main.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if($this->check_user_authority($category))
           return  redirect()->route('logout');
        
        $category->name_ar = $category->translate('name','ar');
        $category->name_tr = $category->translate('name','tr');
        
        $this->data['category'] = $category;
        $this->data['copy'] = true;
        
        return view('category.edit', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        if($this->check_user_authority($category))
           return  redirect()->route('logout');
        
        $category->name_ar = $category->translate('name','ar');
        $category->name_tr = $category->translate('name','tr');
        
        $this->data['category'] = $category;
        $this->data['copy'] = false;
        
        return view('category.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if($this->check_user_authority($category))
           return  redirect()->route('logout');
        
        $category->update([
                 'name' => $request->name,
                'isActive'=>$request->isActive,
             ]);
       
       if($request->image){
             $file = $request->file('image');
             $filename = "image-".$category->id.".".$file->getClientOriginalExtension();
                
                //Move Uploaded File
                $destinationPath = 'uploads/categories/';
                $file->move($destinationPath,$filename);
                
                $category->update([
                 'image' => $filename
             ]);
                
        }
        if($category){
        $this->new_translation($category->id,'ar','categories','name',$request['name_ar']);
        $this->new_translation($category->id,'tr','categories','name',$request['name_tr']);
        
        }
        
        return redirect()->route('categories.index')->with('status', trans('main.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
         
        $category = Category::find($id);
        if($this->check_user_authority($category))
           return response()->json(['status'=>false]);
        
        try {
            if($category->delete()){
                $this->delete_translation($id, 'categories');
            }
            return response()->json(['status' => true]);
        } catch (QueryException $e) {
            if ($e->getCode() == "2292") {
                return response()->json(['status'=>false]);
            }
        }

    }
}
