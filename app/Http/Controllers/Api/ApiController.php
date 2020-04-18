<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use App;
use Illuminate\Support\Facades\File;

class ApiController extends Controller
{

    public function __construct()
    {
      $this->user =  Auth::guard('api')->user();
      if($this->user)
        App::setLocale($this->user->language_id);

      if(app('request')->header('lang'))
          App::setLocale(app('request')->header('lang'));

    }

    public function storeImage($imageBase64,$store_in,$name)
    {

        $arr = explode(",", $imageBase64);
        $ext = $arr[0];

        $imgContent = base64_decode($arr[1]);
        $file_name = $name."." . $ext;


        //$fullPath = base_path().'/../public_html' . $store_in . $file_name;
        $fullPath = public_path() . $store_in . $file_name;

        $path = $store_in . $file_name;

        File::put($fullPath, $imgContent);

        return $file_name;
    }

}
