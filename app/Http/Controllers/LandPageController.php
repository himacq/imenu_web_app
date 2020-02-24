<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use App\Models\Product;
use App\Models\Restaurant;


class LandPageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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
    public function notActiveUser()
    {
        
        $this->data['user'] = $this->user;
        return view('not_active_user', $this->data);
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
