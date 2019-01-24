<?php

namespace App;

use App\Http\Controllers\Test\FreeTextTestController;

class FreeTextTest extends TestModel
{
    protected $fillable = ["name", "description"];

    //
    function getColourClassAttribute()
    {
        return "danger";
    }

    function getRouteNameAttribute()
    {
        return "free-text";
    }

    function getControllerClassAttribute()
    {
        return FreeTextTestController::class;
    }
}
