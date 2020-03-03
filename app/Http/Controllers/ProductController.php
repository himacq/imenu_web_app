<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductIngredient;
use App\Models\ProductOptionGroup;
use App\Models\ProductOption;

class ProductController extends Controller
{
    
    public function __construct()
    {
        $this->change_language();
        $this->middleware('permission:catalog-manage');
        $this->data['menu'] = 'catalog';
        $this->data['selected'] = 'product';
        $this->data['location'] = 'Products';
        $this->data['location_title'] = __('main.products');
        $this->data['sub_menu'] = 'product';

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
           
        return view('product.index', $this->data);
    }
    
    /**
     * return dataTable
     * @param Request $request
     * @return type
     */

    public function contentListData(Request $request)
    {
       if( $this->user->hasRole('superadmin'))
        $products = Product::all();
       else{
           $restaurant = $this->user->restaurant;
           $products = $restaurant->categories()->with('products')->get()->pluck('products')->flatten();
       }
          return DataTables::of($products)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;

            
            })
             
            ->addColumn('category', function ($model) {
                return $model->category->translate('name');

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
                $html =  "<a class='btn btn-primary btn-sm' href = '" . url("products/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a> ";
                if(!count($model->order_details))
                  $html.= "<a class='btn btn-danger btn-sm delete' ><input type = 'hidden' class='id_hidden' value = '" . $id . "' > <i class='fa fa-remove' ></i ></a > ";

                $html.='<a href="' . url("products/" . $id ) . '"  class="btn btn-sm blue"><i class="fa fa-file-o"></i> '.__('main.copy').' </a>';
                
                return $html;
            })
            ->rawColumns(['category','control','active'])
            ->make(true);

    }
    
     public function activeProduct(Request $request)
    {
        $isActive = $request->active;
        $product = Product::find($request->id);
        $category = $product->category;
        
        if($this->check_user_authority($category))
           return  redirect()->route('logout');
        
        $product->update([
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
        $this->data['categories'] = Category::where(['restaurant_id'=>$this->user->restaurant_id])->get();
        
        return view('product.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        
        $product = Product::create([
            'name' => $request->name,
            'isActive'=>$request->isActive,
            'minutes_required'=>$request->minutes_required,
            'price'=>$request->price,
            'category_id'=>$request->category_id
                
             ]);
       
       if($request->image){
             $file = $request->file('image');
             $filename = "image-".$product->id.".".$file->getClientOriginalExtension();
                
                //Move Uploaded File
                $destinationPath = 'uploads/products/';
                $file->move($destinationPath,$filename);
                
                $product->update([
                 'image' => $filename
             ]);
                
        }
        else if($request->image_file_name)
            $product->update([
                 'image' => $request->image_file_name
             ]);
        
        if($product){
        $this->new_translation($product->id,'ar','products','name',$request['name_ar']);
        $this->new_translation($product->id,'tr','products','name',$request['name_tr']);
        
        }
        
        return redirect()->route('products.edit',$product->id)->with('status', trans('main.success_continue'));
    }
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_copy(Request $request,$id)
    {    
        $original_product = Product::find($id);
        
        $product = Product::create([
            'name' => $request->name,
            'isActive'=>$request->isActive,
            'minutes_required'=>$request->minutes_required,
            'price'=>$request->price,
            'category_id'=>$request->category_id
                
             ]);
       
       if($request->image){
             $file = $request->file('image');
             $filename = "image-".$product->id.".".$file->getClientOriginalExtension();
                
                //Move Uploaded File
                $destinationPath = 'uploads/products/';
                $file->move($destinationPath,$filename);
                
                $product->update([
                 'image' => $filename
             ]);
                
        }
        else if($request->image_file_name)
            $product->update([
                 'image' => $request->image_file_name
             ]);
        
        if($product){
        $this->new_translation($product->id,'ar','products','name',$request['name_ar']);
        $this->new_translation($product->id,'tr','products','name',$request['name_tr']);
        
        }
        
         // ingredients
        if($original_product->ingredients){
        foreach($original_product->ingredients as $ingr){
                $ingredient = ProductIngredient::create([
                    'name' => $ingr->name,
                    'isActive'=> $ingr->isActive,
                    'product_id'=>$product->id
                ]);
                
            $this->new_translation($ingredient->id,'ar','product_ingredients','name',$ingr->translate('name','ar'));
            $this->new_translation($ingredient->id,'tr','product_ingredients','name',$ingr->translate('name','tr'));     
             }
        }
        
        // option groups
         if($original_product->option_groups){
        foreach($original_product->option_groups as $option_group){
                $group = ProductOptionGroup::create([
                    'name' => $option_group->name,
                    'isActive'=> $option_group->isActive,
                    'product_id'=>$product->id,
                    'minimum'=>$option_group->minimum,
                    'maximum'=>$option_group->maximum
                ]);
                
            $this->new_translation($group->id,'ar','product_option_groups','name',$option_group->translate('name','ar'));
            $this->new_translation($group->id,'tr','product_option_groups','name',$option_group->translate('name','tr'));     
            
            
            if($option_group->options){
                foreach($option_group->options as $option){
                    $new_option = ProductOption::create([
                    'name' => $option->name,
                    'isActive'=> $option->isActive,
                    'group_id'=>$group->id,
                    'minutes_required'=>$option->minutes_required,
                    'price'=>$option->price
                ]);
                
            $this->new_translation($new_option->id,'ar','product_options','name',$option->translate('name','ar'));
            $this->new_translation($new_option->id,'tr','product_options','name',$option->translate('name','tr'));     
            
                }
            }
            
        }
        }
             
        
        
        return redirect()->route('products.edit',$product->id)->with('status', trans('main.success_continue'));
    }
    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        $category = $product->category;
        if($this->check_user_authority($category))
           return  redirect()->route('logout');
        
        $product->name_ar = $product->translate('name','ar');
        $product->name_tr = $product->translate('name','tr');
        
        if( $this->user->hasRole('superadmin'))
            $this->data['categories'] = Category::where(['restaurant_id'=>$category->restaurant_id])->get();
        else
             $this->data['categories'] = Category::where(['restaurant_id'=>$this->user->restaurant_id])->get();
        
        
        $this->data['product'] = $product;
        
        return view('product.copy', $this->data);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $category = $product->category;
        
        if($this->check_user_authority($category))
           return  redirect()->route('logout');
        
        $product->name_ar = $product->translate('name','ar');
        $product->name_tr = $product->translate('name','tr');
        
        if( $this->user->hasRole('superadmin'))
            $this->data['categories'] = Category::where(['restaurant_id'=>$category->restaurant_id])->get();
        else
             $this->data['categories'] = Category::where(['restaurant_id'=>$this->user->restaurant_id])->get();
        
        $this->data['product'] =$product;
        return view('product.edit', $this->data);
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
        $product = Product::find($id);
        $category = $product->category;
        
        if($this->check_user_authority($category))
           return  redirect()->route('logout');
        
        $product->update([
            'name' => $request->name,
            'isActive'=>$request->isActive,
            'minutes_required'=>$request->minutes_required,
            'price'=>$request->price,
            'category_id'=>$request->category_id
                
             ]);
       
       if($request->image){
             $file = $request->file('image');
             $filename = "image-".$product->id.".".$file->getClientOriginalExtension();
                
                //Move Uploaded File
                $destinationPath = 'uploads/products/';
                $file->move($destinationPath,$filename);
                
                $product->update([
                 'image' => $filename
             ]);
                
        }
        if($product){
        $this->new_translation($product->id,'ar','products','name',$request['name_ar']);
        $this->new_translation($product->id,'tr','products','name',$request['name_tr']);
        
        }
        
        // ingredients
        if(is_array($request->ingr_id)){
        for($i=0; $i<count($request->ingr_id); $i++){
            if(is_null($request->ingr_name[$i]))
                continue;
            
            $ingredient = ProductIngredient::find($request->ingr_id[$i]);
            
            
            if($request->ingr_id[$i] == -1 || !$ingredient)
                $ingredient = ProductIngredient::create([
                    'name' => $request->ingr_name[$i],
                    'isActive'=> $request->ingr_is_avtive[$i][0],
                    'product_id'=>$product->id
                ]);
                
            else
                $ingredient->update([
                    'name' => $request->ingr_name[$i],
                    'isActive'=> $request->ingr_is_avtive[$i][0]
                ]);
                
            $this->new_translation($ingredient->id,'ar','product_ingredients','name',$request->ingr_name_ar[$i]);
            $this->new_translation($ingredient->id,'tr','product_ingredients','name',$request->ingr_name_tr[$i]);     
             }
        }
             
        // option groups
         if(is_array($request->option_group_id)){
        for($i=0; $i<count($request->option_group_id); $i++){
            if(is_null($request->option_group_name[$i]))
                continue;
            
            $optionGroup = ProductOptionGroup::find($request->option_group_id[$i]);
            
            if($request->option_group_id[$i] == -1 || !$optionGroup)
                $optionGroup = ProductOptionGroup::create([
                    'name' => $request->option_group_name[$i],
                    'isActive'=> $request->option_group_is_avtive[$i][0],
                    'product_id'=>$product->id,
                    'minimum'=>$request->minimum[$i],
                    'maximum'=>$request->maximum[$i]
                ]);
                
            else
                $optionGroup->update([
                    'name' => $request->option_group_name[$i],
                    'isActive'=> $request->option_group_is_avtive[$i][0],
                    'minimum'=>$request->minimum[$i],
                    'maximum'=>$request->maximum[$i]
                ]);
                
            $this->new_translation($optionGroup->id,'ar','product_option_groups','name',$request->option_group_name_ar[$i]);
            $this->new_translation($optionGroup->id,'tr','product_option_groups','name',$request->option_group_name_tr[$i]);     
             }
         }
         
         
          // options
        
         if(is_array($request->thisoption_group_id)){
           
        for($i=0; $i<count($request->thisoption_group_id); $i++){
            
            if(is_null($request->option_name[$i]))
                continue;
            
            $option = ProductOption::find($request->option_id[$i]);
            
            if($request->option_id[$i] == -1 || !$option)
                $option = ProductOption::create([
                    'name' => $request->option_name[$i],
                    'isActive'=>$request->option_is_active[$i],
                    'group_id'=>$request->thisoption_group_id[$i],
                    'minutes_required'=>$request->option_minutes_required[$i],
                    'price'=>$request->option_price[$i]
                ]); 
                
            else
                $option->update([
                    'name' => $request->option_name[$i],
                    'isActive'=>$request->option_is_active[$i],
                    'group_id'=>$request->thisoption_group_id[$i],
                    'minutes_required'=>$request->option_minutes_required[$i],
                    'price'=>$request->option_price[$i]
                ]);
                
            $this->new_translation($option->id,'ar','product_options','name',$request->option_name_ar[$i]);
            $this->new_translation($option->id,'tr','product_options','name',$request->option_name_tr[$i]);     
             }
         }
        
         
        return redirect()->route('products.index')->with('status', trans('main.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
         
        $product = Product::find($id);
        $category = $product->category;
        
        if($this->check_user_authority($category))
           return response()->json(['status'=>false]);
        
        try {
            if($product->delete()){
                $this->delete_translation($id, 'products');
            }
            
            return response()->json(['status' => true]);
        } catch (QueryException $e) {
            if ($e->getCode() == "2292") {
                return response()->json(['status'=>false]);
            }
        }

    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy_ingredient($id)
    {
         
        $product_ingr = ProductIngredient::find($id);

        try {
            if($product_ingr->delete()){
                $this->delete_translation($id, 'product_ingredients');
                return response()->json(['status' => true]);
            }
             return response()->json(['status'=>false]);
        } catch (QueryException $e) {
            if ($e->getCode() == "2292") {
                return response()->json(['status'=>false]);
            }
        }

    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy_option_group($id)
    {
         
        $product_group = ProductOptionGroup::find($id);

        try {
            if($product_group->delete()){
                $this->delete_translation($id, 'product_option_groups');
                return response()->json(['status' => true]);
            }
             return response()->json(['status'=>false]);
        } catch (QueryException $e) {
            if ($e->getCode() == "2292") {
                return response()->json(['status'=>false]);
            }
        }

    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy_option($id)
    {
         
        $product_option = ProductOption::find($id);

        try {
            if($product_option->delete()){
                $this->delete_translation($id, 'product_options');
                return response()->json(['status' => true]);
            }
             return response()->json(['status'=>false]);
        } catch (QueryException $e) {
            if ($e->getCode() == "2292") {
                return response()->json(['status'=>false]);
            }
        }

    }
    
    
}
