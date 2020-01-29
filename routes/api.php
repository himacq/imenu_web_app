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
    Route::post('/user/register' , 'Api\UserController@register');
    Route::post('/user/login' , 'Api\UserController@login');

    /**
     * shoppingApi public Services
     */
    
    Route::get('/restaurants/{language_id?}','Api\RestaurantController@listRestaurants');
    Route::get('/restaurant/{id}/{language_id?}','Api\RestaurantController@Restaurant');

    
    Route::get('/categories/{restaurant_id?}/{language_id?}','Api\CategoryController@listCategories');
    Route::get('/category/{id}/{language_id?}','Api\CategoryController@Category');
    
    Route::get('/products/{category_id?}/{language_id?}','Api\ProductController@listProducts');
    Route::get('/product/{id}/{language_id?}','Api\ProductController@Product');
    
Route::group(['middleware' => 'auth:api'], function () {
    
    /**
     * CoreApi services
     */
    Route::post('/user/logout' , 'Api\UserController@logout');
    Route::get('/user/profile' , 'Api\UserController@userProfile');
    Route::post('/user/update' , 'Api\UserController@updateUserProfile');
    Route::post('/user/password' , 'Api\UserController@updatePassword');
    Route::post('/user/address' , 'Api\UserController@createAddress');
    Route::post('/user/updateAddress' , 'Api\UserController@updateAddress');
    Route::delete('/user/address/{id}', 'Api\UserController@deleteAddress');
    Route::get('/user/addresses', 'Api\UserController@listAddresses');
    Route::post('/user/location', 'Api\UserController@updateLocation');
    
    /**
     * shoppingApi Services
     */
    Route::post('/favourite', 'Api\FavouriteController@createFavourite');
    Route::delete('/favourite/{id}', 'Api\FavouriteController@deleteFavourite');
    Route::get('/favourites', 'Api\FavouriteController@listFavourites');
    
    Route::post('/cart', 'Api\CartController@addToCart');
    Route::post('/cartOption', 'Api\CartController@addOptionToCartDetails');
    Route::get('/cart', 'Api\CartController@getCart');
    Route::delete('/cart/{id}', 'Api\CartController@removeItemCart');
    Route::get('/cart/empty', 'Api\CartController@emptyCart');
    

});
/*
Route::resource('category' , 'Api\CategoryController');
Route::post('category/{id}' , 'Api\CategoryController@update');
/*                           */




