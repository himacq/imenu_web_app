<?php

Route::get('/displayReport', 'MapController@displayReport');


// general routes
Route::group(['middleware' => 'auth'], function () {

    Route::post('home/register_restaurant','HomeController@register_restaurant');

    Route::get('/autoComplete/option_group_name/{language_id}', 'AutoCompleteController@option_group_names');
    Route::get('/autoComplete/option_names/{language_id}', 'AutoCompleteController@option_names');
    Route::get('/language/{id}', 'HomeController@changeLanguage');
    Route::get('/', 'HomeController@index');
    Route::get('home/app_review', 'HomeController@app_review')->name('app_reviews');
    Route::post('home/app_review', 'HomeController@store_app_review');
    Route::post('home/reviewsContentListData', 'HomeController@reviewsContentListData');

    Route::get('users/profile', 'UserController@profile')->name('users.profile');
    Route::post('users/updateUserInfo', 'UserController@updateUserInfo')->name('users.updateUserInfo');

    /*************/

    Route::group(['middleware' => 'role:c||superadmin||c1||c2'], function () {
        Route::get('users_messages', 'MessageController@users_messages')->name('users_messages');
        Route::post('messages/userMessagesContentListData', 'MessageController@userMessagesContentListData');

        Route::get('customers_messages', 'MessageController@customers_messages')->name('customers_messages');
        Route::post('messages/customerMessagesContentListData', 'MessageController@customerMessagesContentListData');
    });

    Route::group(['middleware' => 'role:c||superadmin||admin||c1||c2'], function () {
        Route::get('customers_messages', 'MessageController@customers_messages')->name('customers_messages');
        Route::post('messages/customerMessagesContentListData', 'MessageController@customerMessagesContentListData');
        Route::get('messages/user_message_details/{id}', 'MessageController@user_message_details')->name('user_message_details');
        Route::post('messages/user_message_store_reply/{id}', 'MessageController@user_message_store_reply')->name('user_message_store_reply');

        Route::get('messages/customer_message_details/{id}', 'MessageController@customer_message_details')->name('customer_message_details');
        Route::post('messages/customer_message_store_reply/{id}', 'MessageController@customer_message_store_reply')->name('customer_message_store_reply');
    });

    Route::get('messages/inbox', 'MessageController@inbox');
    Route::post('messages/inboxContentListData', 'MessageController@inboxContentListData');

    Route::get('messages/sent', 'MessageController@sent')->name('messages.sent');
    Route::post('messages/sentContentListData', 'MessageController@sentContentListData');


    Route::resource('messages', 'MessageController');
    /***********/
    Route::get('logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        return back();
    });

});
Route::group(['middleware' => 'auth'], function () {
    Route::get('acting_as_cancle', 'HomeController@acting_as_cancle');
// manage categories and products
Route::group(['middleware' => 'role:superadmin||admin'], function () {
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
    Route::post('products/reviewsContentListData', 'ProductController@reviewsContentListData');
    Route::resource('products', 'ProductController');
});

// manage reports
    Route::group(['middleware' => 'role:admin||superadmin||b'], function () {
        Route::get('reports/most_orders', 'ReportController@most_orders');
        Route::post('reports/most_orders', 'ReportController@most_orders');

        Route::get('reports/most_ranked', 'ReportController@most_ranked');
        Route::post('reports/most_ranked', 'ReportController@most_ranked');

    });

    Route::group(['middleware' => 'role:superadmin'], function () {
        Route::get('reports/restaurants_statistics', 'ReportController@restaurants_statistics');
        Route::get('reports/customers_statistics', 'ReportController@customers_statistics');
        Route::get('reports/users_statistics', 'ReportController@users_statistics');

    });

    Route::group(['middleware' => 'role:admin||superadmin||c'], function () {
        Route::get('reports/support', 'ReportController@support');
        Route::post('reports/support', 'ReportController@support');

    });

    Route::group(['middleware' => 'role:admin||superadmin||d'], function () {
        Route::group(['middleware' => 'role:admin||superadmin'], function () {
        Route::get('reports/orders', 'ReportController@orders');
        Route::post('reports/orders', 'ReportController@orders');

        });

        Route::get('reports/payments', 'ReportController@payments');
        Route::post('reports/payments', 'ReportController@payments');

        Route::get('reports/payments_methods', 'ReportController@payments_methods');
        Route::post('reports/payments_methods', 'ReportController@payments_methods');

        Route::get('reports/payments_geo', 'ReportController@payments_geo');
        Route::post('reports/payments_geo', 'ReportController@payments_geo');

        Route::get('reports/financial', 'ReportController@financial');
        Route::post('reports/financial_print', 'ReportController@financial_print');

        Route::get('reports/financial_bills', 'ReportController@financial_bills');
        Route::post('reports/financial_bills_print', 'ReportController@financial_bills_print');

        Route::group(['middleware' => 'role:superadmin||d'], function () {
            Route::get('reports/financial_paid', 'ReportController@financial_paid');
            Route::post('reports/financial_paid_print', 'ReportController@financial_paid_print');

            Route::get('reports/financial_not_paid', 'ReportController@financial_not_paid');
            Route::post('reports/financial_not_paid_print', 'ReportController@financial_not_paid_print');


        });
    });


// manage orders
Route::group(['middleware' => 'role:admin||superadmin'], function () {
    Route::get('orders/print/{id}', 'OrderController@print');
    Route::post('orders/contentListData', 'OrderController@contentListData');
    Route::post('orders/review_customer/{id}', 'OrderController@review_customer')->name('orders.review_customer');
    Route::resource('orders', 'OrderController');
});

// manage users
Route::group(['middleware' => 'role:admin||b||superadmin||c||d'], function () {
    Route::post('user/contentListData{status?}', 'UserController@contentListData');
    Route::get('user_activate', 'UserController@activeUser');

    Route::group(['middleware' => 'role:b||superadmin'], function () {
        Route::get('active_review', 'UserController@activeReview');
        Route::post('user/reviewsContentListData', 'UserController@reviewsContentListData');
        Route::get('users/users_app_reviews', 'UserController@users_app_reviews');
    });

    Route::resource('users', 'UserController');


});


// restaurant managment
Route::group(['middleware' => 'role:admin||a||superadmin'], function () {
    Route::get('restaurants/reviews', 'RestaurantController@reviews');
    Route::post('restaurants/restaurantReviewsContentListData', 'RestaurantController@restaurantReviewsContentListData');
    Route::get('restaurants/profile/{branches?}', 'RestaurantController@profile')->name('restaurants.profile');
    Route::post('restaurants/childContentListData', 'RestaurantController@childContentListData');
    Route::post('restaurants/reviewsContentListData', 'RestaurantController@reviewsContentListData');
    Route::post('restaurants/admin_review/{id}', 'RestaurantController@admin_review');
    Route::post('restaurants/adminReviewsContentListData', 'RestaurantController@adminReviewsContentListData');
    Route::get('restaurant_activate', 'RestaurantController@activeRestaurant');
    Route::get('acting_as/{id}', 'HomeController@acting_as');


    Route::post('status-registered-restaurant/{id}', 'RestaurantController@registeredRestaurantStatus');
    Route::get('registered-restaurant/{id}', 'RestaurantController@registeredRestaurantView');
    Route::get('registered-restaurants', 'RestaurantController@registeredRestaurants')->name('restaurant.registered');
    Route::post('restaurants/registeredContentListData/{status?}', 'RestaurantController@registeredContentListData');
    Route::post('restaurants/contentListData/{status?}', 'RestaurantController@contentListData');

    Route::resource('restaurants', 'RestaurantController');
});

// system managment - lookup,roles,permissions,restaurant, payment_methods
Route::group(['middleware' => 'role:superadmin'], function () {

    Route::get('lookup/level/{id}', 'LookupController@level');
    Route::post('lookup/{id}', 'LookupController@store');
    Route::resource('lookup', 'LookupController');

    Route::post('roles/contentListData', 'RoleController@contentListData');
    Route::resource('roles', 'RoleController');

    Route::post('permissions/contentListData', 'PermissionController@contentListData');
    Route::resource('permissions', 'PermissionController');



    Route::get('payment_methods_activate', 'PaymentMethodController@activeMethod');
    Route::post('payment_methods/contentListData', 'PaymentMethodController@contentListData');
    Route::resource('payment_methods', 'PaymentMethodController');

});

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/not_active_user', 'LandPageController@notActiveUser')->name('not_active_user');
