<?php

namespace App;

use App\Http\Controllers\Test\WordTestController;

class MultiWordTest extends TestModel
{
    protected $fillable = ["name", "description", "max"];

    function getColourClassAttribute()
    {
        return "success";
    }

    function getRouteNameAttribute()
    {
        return "word";
    }

    function getControllerClassAttribute()
    {
        return WordTestController::class;
    }

    function wordTestWords()
    {
        return $this->hasMany("App\WordTestWord");
    }
}
