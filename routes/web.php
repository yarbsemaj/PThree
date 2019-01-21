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


Route::group(["namespace" => "Test"], function () {
    Route::resource('map', 'MapTestController');
    Route::group(["as" => "map.", "prefix" => "map"], function () {
        Route::get('image/{file}', 'MapTestController@image')->name("image");
        Route::get('preview/{id}', 'MapTestController@displayTest')->name("preview");
        Route::get('results/{id}', 'MapTestController@getResult')->name("results");
        Route::get('results/{id}/data.json', 'MapTestController@getResultsData')->name("results.data");
    });

    Route::resource('free-text', 'FreeTextTestController');
    Route::group(["as" => "free-text.", "prefix" => "free-text"], function () {
        Route::get('/preview/{id}', 'FreeTextTestController@displayTest')->name("preview");
        Route::get('/results/{id}', 'FreeTextTestController@getResult')->name("results");
        Route::get('/results/{id}/data.json', 'FreeTextTestController@getResultsData')->name("results.data");
    });

    Route::resource('order', 'OrderTestController');
    Route::group(["as" => "order.", "prefix" => "order"], function () {
        Route::get('/preview/{id}', 'OrderTestController@displayTest')->name("preview");
        Route::get('/results/{id}', 'OrderTestController@getResult')->name("results");
        Route::get('/results/{id}/data.json', 'OrderTestController@getResultsData')->name("results.data");
    });
});


Route::resource('test-participant', 'CRUD\\TestParticipantController')->only([
    'index', 'show', 'destroy'
]);

Route::group(["prefix" => "test", "as" => "test.","namespace"=>"Test"], function () {
    Route::get("/{participantToken}", "TestSteward@index")->name("index");

    Route::get("/begin/{participantToken}", "TestSteward@getTestStart")->name("begin");

    Route::get("basics/{urlToken}", "TestSteward@basics")->name("basics");
    Route::post("basics/{urlToken}", "TestSteward@store")->name("store");

    Route::get("/underway/{participantToken}", "TestSteward@getTest")->name("display");
    Route::post("/underway/{participantToken}", "TestSteward@saveTest")->name("save");

});

