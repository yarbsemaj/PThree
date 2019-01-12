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

Route::resource('test-series', 'CRUD\\TestSeriesController');
Route::get('test-series/add-test/{id}', 'CRUD\\TestSeriesController@setupTest')->name("test-series.setup-test");
Route::post('test-series/add-test/{id}', 'CRUD\\TestSeriesController@saveSetupTest')->name("test-series.setup-test-save");;


Route::resource('map', 'Test\\MapController');

Route::get('/map/image/{file}', 'Test\\MapController@image')->name("map.image");
Route::get('/map/preview/{id}', 'Test\\MapController@displayTest')->name("map.preview");


Route::group(["prefix" => "test", "as" => "test.","namespace"=>"Test"], function () {
    Route::get("/{urlToken}", "TestSteward@index")->name("index");
    Route::post("/{urlToken}", "TestSteward@store")->name("store");

    Route::get("/underway/{participantToken}", "TestSteward@store")->name("display");
    Route::post("/underway/{participantToken}", "TestSteward@store")->name("save");



});

