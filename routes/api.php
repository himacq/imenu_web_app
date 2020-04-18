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

Route::get('test_map_api',function(){
    $url = "https://maps.googleapis.com/maps/api/directions/json?&waypoints=via:-37.81223%2C144.96254%7Cvia:-34.92788%2C138.60008&key=AIzaSyCGdpn4f1QYHxrQCzInRbPTYhwdMICR_DU";
    //$url = "https://maps.googleapis.com/maps/api/directions/json?origin=Toronto&destination=Montreal&key=AIzaSyCGdpn4f1QYHxrQCzInRbPTYhwdMICR_DU";
    $result = file_get_contents($url);
    echo ($result);

});
    /**
     * CoreApi public services
     */
    Route::post('/user/register' , 'Api\UserController@register');
    Route::post('/user/login' , 'Api\UserController@login');

    /**
     * shoppingApi public Services
     */
    Route::get('/restaurant/registration_questions','Api\RestaurantController@listQuestions');

    Route::post('/restaurants','Api\RestaurantController@listRestaurants');
    Route::post('/withinMaxDistance','Api\RestaurantController@withinMaxDistance');
    Route::get('/restaurant/{id}','Api\RestaurantController@Restaurant');
    Route::get('/restaurant_classifications','Api\RestaurantController@restaurant_categories');


    Route::get('/categories/{restaurant_id?}','Api\CategoryController@listCategories');
    Route::get('/category/{id}','Api\CategoryController@Category');

    Route::post('/products','Api\ProductController@listProducts');
    Route::get('/product/{id}','Api\ProductController@Product');
    Route::get('/paymentMethods/{id}','Api\PaymentController@paymentMethods');

Route::group(['middleware' => 'auth:api'], function () {

    /**
     * CoreApi services
     */
    Route::post('/restaurant/register','Api\RestaurantController@register');
    Route::post('/restaurant/review', 'Api\RestaurantController@review');
    Route::post('/user/logout' , 'Api\UserController@logout');
    Route::get('/user/profile' , 'Api\UserController@userProfile');
    Route::post('/user/update' , 'Api\UserController@updateUserProfile');
    Route::post('/user/password' , 'Api\UserController@updatePassword');
    Route::post('/user/address' , 'Api\UserController@createAddress');
    Route::post('/user/updateAddress' , 'Api\UserController@updateAddress');
    Route::delete('/user/address/{id}', 'Api\UserController@deleteAddress');
    Route::get('/user/addresses', 'Api\UserController@listAddresses');
    Route::post('/user/review', 'Api\UserController@review');

    Route::post('/product/review', 'Api\ProductController@review');

    /**
     * shoppingApi Services
     */
    Route::post('/favourite', 'Api\FavouriteController@createFavourite');
    Route::delete('/favourite/{id}', 'Api\FavouriteController@deleteFavourite');
    Route::get('/favourites', 'Api\FavouriteController@listFavourites');

    Route::post('/favourite_restaurant', 'Api\FavouriteController@createFavouriteRestaurant');
    Route::delete('/favourite_restaurant/{id}', 'Api\FavouriteController@deleteFavouriteRestaurant');
    Route::get('/favourite_restaurants', 'Api\FavouriteController@listFavouriteRestaurants');

    Route::post('/cart', 'Api\CartController@addToCart');
    Route::post('/cart_update', 'Api\CartController@updateItemCart');
    Route::post('/cartOption', 'Api\CartController@addOptionToCartDetails');
    Route::get('/cart', 'Api\CartController@getCart');
    Route::delete('/cart/{id}', 'Api\CartController@removeItemCart');
    Route::get('/cart/empty', 'Api\CartController@emptyCart');

    Route::post('/delivered_order', 'Api\OrderController@delivered_order');
    Route::post('/order', 'Api\OrderController@createOrder');
    Route::get('/order/{id}', 'Api\OrderController@order');
    Route::get('/orders', 'Api\OrderController@listOrders');

    Route::post('/messages/send_message_restaurant','Api\MessageController@send_message_restaurant');
    Route::post('/messages/send_message_admin','Api\MessageController@send_message_admin');
    Route::post('/messages/reply','Api\MessageController@reply');
    Route::get('/messages/sent','Api\MessageController@get_sent_messages');
    Route::get('/messages/inbox','Api\MessageController@inbox');
    Route::get('/messages/unread','Api\MessageController@unread');
    Route::get('/messages/details/{id}','Api\MessageController@details');


});
/*
Route::resource('category' , 'Api\CategoryController');
Route::post('category/{id}' , 'Api\CategoryController@update');
/*                           */




