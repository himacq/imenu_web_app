<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

    /**
     * CoreApi public services
     */
    Route::post('/user/register' , 'Api\CoreApiController@register');
    Route::post('/user/login' , 'Api\CoreApiController@login');

    /**
     * shoppingApi public Services
     */
    
    Route::get('/shopping/restaurants/{language_id?}','Api\ShoppingApiController@listRestaurants');

Route::group(['middleware' => 'auth:api'], function () {
    
    /**
     * CoreApi services
     */
    Route::post('/user/logout' , 'Api\CoreApiController@logout');
    Route::get('/user/profile' , 'Api\CoreApiController@userProfile');
    Route::post('/user/update' , 'Api\CoreApiController@updateUserProfile');
    Route::post('/user/password' , 'Api\CoreApiController@updatePassword');
    Route::post('/user/address' , 'Api\CoreApiController@createAddress');
    Route::post('/user/updateAddress' , 'Api\CoreApiController@updateAddress');
    Route::delete('/user/address/{id}', 'Api\CoreApiController@deleteAddress');
    Route::get('user/addresses', 'Api\CoreApiController@listAddresses');
    Route::post('user/location', 'Api\CoreApiController@updateLocation');
    
    /**
     * shoppingApi Services
     */
    
    

});
/*
Route::resource('category' , 'Api\CategoryController');
Route::post('category/{id}' , 'Api\CategoryController@update');
/*                           */




