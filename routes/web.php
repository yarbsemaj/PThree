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

Route::resource('test-series', 'Admin\\TestSeriesController');
Route::resource('police-forces', 'Admin\\PoliceForcesController');
Route::resource('test-partipants', 'Admin\\TestPartipantsController');

Route::group(["prefix" => "test", "as" => "test.","namespace"=>"Test"], function () {
    Route::group(["prefix" => "map", "as" => "map."], function () {
        Route::get('/index', function (){
            return view("test.map.index");
        });
    });
});

