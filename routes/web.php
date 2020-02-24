<?php

use Dompdf\Dompdf;



Route::group(['middleware' => 'auth'], function () {

    Route::get('/language/{id}', 'HomeController@changeLanguage');
    Route::get('/', 'HomeController@index');


    Route::post('user/contentListData{status?}', 'UserController@contentListData');
    Route::get('user_activate', 'UserController@activeUser');
    Route::get('users/profile', 'UserController@profile')->name('users.profile');
    Route::post('users/updateUserInfo', 'UserController@updateUserInfo')->name('users.updateUserInfo');

    Route::resource('users', 'UserController');
    
    Route::get('lookup/level/{id}', 'LookupController@level');
    Route::post('lookup/{id}', 'LookupController@store');
    Route::resource('lookup', 'LookupController');
    
    Route::post('roles/contentListData', 'RoleController@contentListData');
    Route::resource('roles', 'RoleController');
    
    Route::post('permissions/contentListData', 'PermissionController@contentListData');
    Route::resource('permissions', 'PermissionController');
    
    Route::get('restaurant_activate', 'RestaurantController@activeRestaurant');
    Route::post('status-registered-restaurant/{id}', 'RestaurantController@registeredRestaurantStatus');
    Route::get('registered-restaurant/{id}', 'RestaurantController@registeredRestaurantView');
    Route::get('registered-restaurants', 'RestaurantController@registeredRestaurants')->name('restaurant.registered');
    Route::post('restaurants/registeredContentListData/{status?}', 'RestaurantController@registeredContentListData');
    Route::post('restaurants/contentListData/{status?}', 'RestaurantController@contentListData');
    Route::post('restaurants/childContentListData', 'RestaurantController@childContentListData');
    Route::post('restaurants/reviewsContentListData', 'RestaurantController@reviewsContentListData');
    Route::resource('restaurants', 'RestaurantController');
    
    Route::post('orders/contentListData', 'OrderController@contentListData');
    Route::resource('orders', 'OrderController');
    
    Route::post('categories/contentListData', 'CategoryController@contentListData');
    Route::resource('categories', 'CategoryController');
    

    Route::get('logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        return back();
    });

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/not_active_user', 'LandPageController@notActiveUser')->name('not_active_user');
