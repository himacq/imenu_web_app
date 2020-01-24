<?php

use Dompdf\Dompdf;

Route::get('foo', function () {
    return 'Hello World';
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/language/{id}', 'HomeController@changeLanguage');
    Route::get('/', 'HomeController@index');

    Route::patch('users/updateUserInfo/{id}', 'UserController@updateInfo')->name('updateUserInfo');


    Route::get('roles/newRole', 'RoleController@newRole')->name('roles.newRole');
    Route::get('roles/view', 'RoleController@view')->name('roles.view');
    Route::get('roles/editRole/{id}', 'RoleController@editRole')->name('roles.editRole');
    Route::patch('roles/updateRole/{id}', 'RoleController@updateRole')->name('roles.updateRole');
    Route::delete('roles/destroyRole/{id}', 'RoleController@destroyRole')->name('roles.destroyRole');


    Route::get('users/profile', 'UserController@profile')->name('users.profile');
    Route::post('users/changePassword', 'UserController@changePassword')->name('users.changePassword');


    Route::get('delUser/{id}', 'UserController@destroy');
    Route::get('delBroker/{id}', 'BrokerController@destroy');
    Route::get('delDonor/{id}', 'DonorController@destroy');
    Route::get('delProject/{id}', 'ProjectController@destroy');


    Route::post('roles/storeRole', 'RoleController@storeRole')->name('roles.store_role');
    Route::get('project/generate_project_number/{num}', 'ProjectController@generate_project_number');


    Route::post('user/contentListData', 'UserController@contentListData');
    Route::post('user/contentListData/{status}', 'UserController@contentListData');

    Route::post('broker/contentListData', 'BrokerController@contentListData');
    Route::get('viewBroker', 'BrokerController@viewBroker');

    Route::post('donor/contentListData', 'DonorController@contentListData');
    Route::get('viewDonor', 'DonorController@viewDonor');

    Route::post('project/contentListData', 'ProjectController@contentListData');
    Route::get('viewProject', 'ProjectController@viewProject');


    Route::post('donation/contentListData', 'DonationController@contentListData');


    Route::resource('users', 'UserController');
    Route::resource('brokers', 'BrokerController');
    Route::resource('donors', 'DonorController');
    Route::resource('projects', 'ProjectController');
    Route::resource('donations', 'DonationController');
    Route::post('donations/{id}', 'DonationController@update');

    Route::get('import', 'DatabaseController@import');
    Route::post('import', 'DatabaseController@import');
    Route::get('export', 'DatabaseController@export');
    Route::post('export', 'DatabaseController@export');
    /*               check jquery validation                  */
    Route::get('checkExistEmail', 'BrokerController@checkExistEmail');

    /*                                 */

    /*                              */

    Route::get('searchDonor', 'DonorController@search');
    Route::post('searchDonor', 'DonorController@search');

    Route::get('searchProject', 'ProjectController@search');
    Route::post('searchProject', 'ProjectController@search');


    Route::get('searchBroker', 'BrokerController@search');
    Route::post('searchBroker', 'BrokerController@search');
    /*                              */

    Route::post('getBrokerForDonor', 'DonationController@getBrokerForDonor');
    Route::get('getDonations', 'DonationController@getDonations');


    Route::get('logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        return back();
    });

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
