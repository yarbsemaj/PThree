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


Route::resource('map', 'Test\\MapTestController');
Route::get('/map/image/{file}', 'Test\\MapTestController@image')->name("map.image");
Route::get('/map/preview/{id}', 'Test\\MapTestController@displayTest')->name("map.preview");
Route::get('/map/results/{id}', 'Test\\MapTestController@getResult')->name("map.results");
Route::get('/map/results/{id}/data.json', 'Test\\MapTestController@getResultsData')->name("map.results.data");

Route::resource('test-participant', 'CRUD\\TestParticipantController')->only([
    'index', 'show', 'destroy'
]);


Route::resource('free-text', 'Test\\FreeTextTestController');
Route::get('/free-text/preview/{id}', 'Test\\FreeTextTestController@displayTest')->name("free-text.preview");
Route::get('/free-text/results/{id}', 'Test\\FreeTextTestController@getResult')->name("free-text.results");
Route::get('/free-text/results/{id}/data.json', 'Test\\FreeTextTestController@getResultsData')->name("free-text.results.data");




Route::group(["prefix" => "test", "as" => "test.","namespace"=>"Test"], function () {
    Route::get("/{participantToken}", "TestSteward@index")->name("index");

    Route::get("/begin/{participantToken}", "TestSteward@getTestStart")->name("begin");

    Route::get("basics/{urlToken}", "TestSteward@basics")->name("basics");
    Route::post("basics/{urlToken}", "TestSteward@store")->name("store");

    Route::get("/underway/{participantToken}", "TestSteward@getTest")->name("display");
    Route::post("/underway/{participantToken}", "TestSteward@saveTest")->name("save");

});

