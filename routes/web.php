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
        Route::get('/image/{file}', 'MapTestController@image')->name("image");
        Route::get('/preview/{id}', 'MapTestController@displayTest')->name("preview");
        Route::get('/results/{id}', 'MapTestController@getResult')->name("results");
        Route::get('/results/{id}/data.json', 'MapTestController@getResultsData')->name("results.data");
        Route::get('/mouse/{id}/{participantID}', 'MapTestController@getMouse')->name("mouse");
        Route::get('/mouse/{id}/{participantID}/data.json', 'MapTestController@getMouseData')->name("mouse.data");
    });

    Route::resource('free-text', 'FreeTextTestController');
    Route::group(["as" => "free-text.", "prefix" => "free-text"], function () {
        Route::get('/preview/{id}', 'FreeTextTestController@displayTest')->name("preview");
        Route::get('/results/{id}', 'FreeTextTestController@getResult')->name("results");
        Route::get('/results/{id}/data.json', 'FreeTextTestController@getResultsData')->name("results.data");
        Route::get('/mouse/{id}/{participantID}', 'FreeTextTestController@getMouse')->name("mouse");
        Route::get('/mouse/{id}/{participantID}/data.json', 'FreeTextTestController@getMouseData')->name("mouse.data");
    });

    Route::resource('order', 'OrderTestController');
    Route::group(["as" => "order.", "prefix" => "order"], function () {
        Route::get('/preview/{id}', 'OrderTestController@displayTest')->name("preview");
        Route::get('/results/{id}', 'OrderTestController@getResult')->name("results");
        Route::get('/results/{id}/data.json', 'OrderTestController@getResultsData')->name("results.data");
        Route::get('/mouse/{id}/{participantID}', 'OrderTestController@getMouse')->name("mouse");
        Route::get('/mouse/{id}/{participantID}/data.json', 'OrderTestController@getMouseData')->name("mouse.data");
    });


    Route::resource('word', 'WordTestController');
    Route::group(["as" => "word.", "prefix" => "word"], function () {
        Route::get('/preview/{id}', 'WordTestController@displayTest')->name("preview");
        Route::get('/results/{id}', 'WordTestController@getResult')->name("results");
        Route::get('/results/{id}/data.json', 'WordTestController@getResultsData')->name("results.data");
        Route::get('/mouse/{id}/{participantID}', 'WordTestController@getMouse')->name("mouse");
        Route::get('/mouse/{id}/{participantID}/data.json', 'WordTestController@getMouseData')->name("mouse.data");
    });

    Route::resource('image-select', 'ImageSelectTestController');
    Route::group(["as" => "image-select.", "prefix" => "image-select"], function () {
        Route::get('image/{file}', 'ImageSelectTestController@image')->name("image");
        Route::get('/preview/{id}', 'ImageSelectTestController@displayTest')->name("preview");
        Route::get('/results/{id}', 'ImageSelectTestController@getResult')->name("results");
        Route::get('/results/{id}/data.json', 'ImageSelectTestController@getResultsData')->name("results.data");
        Route::get('/mouse/{id}/{participantID}', 'ImageSelectTestController@getMouse')->name("mouse");
        Route::get('/mouse/{id}/{participantID}/data.json', 'ImageSelectTestController@getMouseData')->name("mouse.data");
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

    Route::post("/underway/{participantToken}/mouse", "TestSteward@saveMouse")->name("mouse");


});

