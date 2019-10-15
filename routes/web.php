<?php


Auth::routes();

Route::get('/welcome',function(){
    return view('layouts.admin');
});

Route::group(['middleware' => ['auth','mypermission']], function () {


    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/users', 'UserController@users');
    Route::get('/roles','HomeController@roles');
    Route::get('del-role/selected/{id}','HomeController@del_sel_roles');

    Route::get('/permission','RoleController@getPermission');
    Route::post('/add-role','RoleController@store');
    Route::post('/new-user','UserController@store');
    Route::get('/del-user/selected/{id}','UserController@destroy');

    Route::get('/company','CompanyController@index');
    Route::post('/company/create','CompanyController@store');
    Route::get('/company/del/{id}','CompanyController@destroy');
    Route::post('/company/edit','CompanyController@save');

    Route::get('/invoice/{id}','InvoiceController@index');
    Route::post('/invoice','InvoiceController@store');
    Route::get('/invoice/del/{id}','InvoiceController@destroy');
    Route::post('/invoice/edit','InvoiceController@save');
    Route::get('/search/{id}/{search}','InvoiceController@search');

    Route::post('/file','FileController@store');
    Route::get('/file','FileController@index');
    Route::get('/file/del/{id}','FileController@destroy');
});



