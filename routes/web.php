<?php

Route::get('/map', 'MapController@index');

Route::get('/maps', function(){
    $config = array();
    $config['center'] = 'Defence Garden, Karachi';
    GMaps::initialize($config);
    $map = GMaps::create_map();

    echo $map['js'];
    echo $map['html'];
});

// user routes
Route::group(['middleware' => 'auth'], function () {

    Route::get('/autoComplete/option_names/{language_id}', 'AutoCompleteController@option_names');
    Route::get('/language/{id}', 'HomeController@changeLanguage');
    Route::get('/', 'HomeController@index');
    Route::get('home/app_review', 'HomeController@app_review')->name('app_reviews');
    Route::post('home/app_review', 'HomeController@store_app_review');
    Route::post('home/reviewsContentListData', 'HomeController@reviewsContentListData');
    
    Route::get('users/profile', 'UserController@profile')->name('users.profile');
    Route::post('users/updateUserInfo', 'UserController@updateUserInfo')->name('users.updateUserInfo');

    Route::get('logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        return back();
    });

});

// manage categories and products
Route::group(['middleware' => 'permission:catalog-manage'], function () {
    /**
     * categories
     */
    Route::post('categories/contentListData', 'CategoryController@contentListData');
    Route::post('categories/store_copy', 'CategoryController@store_copy')->name('categories.store_copy');
    Route::get('category_activate', 'CategoryController@activeCategory');
    Route::resource('categories', 'CategoryController');
    
    /**
     * products
     */
    Route::post('products/contentListData', 'ProductController@contentListData');
    Route::post('products/store_copy/{id}', 'ProductController@store_copy')->name('products.store_copy');
    Route::get('product_activate', 'ProductController@activeProduct');
    Route::delete('product_ingredient/{id}', 'ProductController@destroy_ingredient');
    Route::delete('product_option_group/{id}', 'ProductController@destroy_option_group');
    Route::delete('product_option/{id}', 'ProductController@destroy_option');
    Route::resource('products', 'ProductController');
});

// manage orders
Route::group(['middleware' => 'permission:orders-manage'], function () {
    Route::post('orders/contentListData', 'OrderController@contentListData');
    Route::post('orders/review_customer/{id}', 'OrderController@review_customer')->name('orders.review_customer');
    Route::resource('orders', 'OrderController');
});

// manage users
Route::group(['middleware' => 'permission:users-manage'], function () {
    Route::post('user/contentListData{status?}', 'UserController@contentListData');
    Route::get('user_activate', 'UserController@activeUser');
    Route::resource('users', 'UserController');
});

// restaurant managment 
Route::group(['middleware' => 'role:admin||superadmin'], function () {
    Route::get('restaurants/profile', 'RestaurantController@profile')->name('restaurants.profile');
    Route::post('restaurants/childContentListData', 'RestaurantController@childContentListData');
    Route::post('restaurants/reviewsContentListData', 'RestaurantController@reviewsContentListData');
    Route::get('restaurant_activate', 'RestaurantController@activeRestaurant');
    Route::get('acting_as/{id}', 'HomeController@acting_as');
    Route::get('acting_as_cancle', 'HomeController@acting_as_cancle');
    
    
    Route::resource('restaurants', 'RestaurantController');
});

// system managment - lookup,roles,permissions,restaurant
Route::group(['middleware' => 'role:superadmin'], function () {
    
    Route::get('lookup/level/{id}', 'LookupController@level');
    Route::post('lookup/{id}', 'LookupController@store');
    Route::resource('lookup', 'LookupController');
    
    Route::post('roles/contentListData', 'RoleController@contentListData');
    Route::resource('roles', 'RoleController');
    
    Route::post('permissions/contentListData', 'PermissionController@contentListData');
    Route::resource('permissions', 'PermissionController');
    
    
    Route::post('status-registered-restaurant/{id}', 'RestaurantController@registeredRestaurantStatus');
    Route::get('registered-restaurant/{id}', 'RestaurantController@registeredRestaurantView');
    Route::get('registered-restaurants', 'RestaurantController@registeredRestaurants')->name('restaurant.registered');
    Route::post('restaurants/registeredContentListData/{status?}', 'RestaurantController@registeredContentListData');
    Route::post('restaurants/contentListData/{status?}', 'RestaurantController@contentListData');
    
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/not_active_user', 'LandPageController@notActiveUser')->name('not_active_user');
