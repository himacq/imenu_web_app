<?php

use Dompdf\Dompdf;



Route::group(['middleware' => 'auth'], function () {

    Route::get('/language/{id}', 'HomeController@changeLanguage');
    Route::get('/', 'HomeController@index');


    Route::post('user/contentListData', 'UserController@contentListData');
    Route::post('user/contentListData/{status}', 'UserController@contentListData');
    Route::get('user_activate', 'UserController@activeUser');
    Route::get('users/profile', 'UserController@profile')->name('users.profile');
    Route::post('users/changePassword', 'UserController@changePassword')->name('users.changePassword');
    Route::patch('users/updateUserInfo/{id}', 'UserController@updateInfo')->name('updateUserInfo');

    Route::resource('users', 'UserController');
    
    Route::get('lookup/level/{id}', 'LookupController@level');
    Route::resource('lookup', 'LookupController');
    
    Route::post('roles/contentListData', 'RoleController@contentListData');
    Route::resource('roles', 'RoleController');
    
    Route::post('permissions/contentListData', 'PermissionController@contentListData');
    Route::resource('permissions', 'PermissionController');



    Route::get('logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        return back();
    });

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
