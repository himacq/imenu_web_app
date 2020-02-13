<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use App\Models\Product;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->change_language();
        $this->data['menu'] = 'home';
        $this->data['location'] = 'home';
        $this->data['location_title'] = 'home';
        $this->data['selected'] = '';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->data['products'] = Product::where(['isActive'=>1])->count();
        return view('home', $this->data);
    }
    
    /**
     * 
     * @param type $language_id
     * @return type
     */
    public function changeLanguage($language_id){
        $user = Auth::user();
        $user->update(['language_id'=>$language_id]);
        App::setLocale($language_id);
 
        return back();
    }
}
