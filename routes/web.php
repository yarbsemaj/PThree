<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(["prefix" => "admin", "as" => "admin.","middleware"=>"auth","namespace"=>"Admin"], function () {
    Route::group(["prefix" => "data", "as" => "crud.","middleware"=>"auth"], function () {
        Route::get('list/{model}', 'CRUDControler@list')->name('list');
        Route::get('get/{model}/{id?}', 'CRUDControler@list')->name('get');
        Route::post('get/{model}/{id?}', 'CRUDControler@list')->name('get.post');
        Route::get('delete/{model}/{id}', 'CRUDControler@list')->name('delete');
    });
});
Route::resource('admin/test-series', 'Admin\\TestSeriesController');
Route::resource('admin/police-forces', 'Admin\\PoliceForcesController');
Route::resource('admin/test-partipants', 'Admin\\TestPartipantsController');