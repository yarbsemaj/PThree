<?php

namespace App;

use App\Http\Controllers\Test\OrderTestController;

class OrderTest extends TestModel
{
    protected $fillable = ["name", "description"];

    function getColourClassAttribute()
    {
        return "warning";
    }

    function getRouteNameAttribute()
    {
        return "order";
    }

    function getControllerClassAttribute()
    {
        return OrderTestController::class;
    }

    function orderTestWords()
    {
        return $this->hasMany("App\OrderTestWord");
    }
}
