<?php

namespace App;

use App\Http\Controllers\Test\MapTestController;

class MapTest extends TestModel
{
    protected $fillable = ["name", "description", "map"];

    function mapPins()
    {
        return $this->hasMany("App\MapPin");
    }

    function getColourClassAttribute()
    {
        return "primary";
    }

    function getRouteNameAttribute()
    {
        return "map";
    }

    function getControllerClassAttribute()
    {
        return MapTestController::class;
    }
}
