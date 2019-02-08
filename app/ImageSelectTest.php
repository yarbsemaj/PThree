<?php

namespace App;

use App\Http\Controllers\Test\ImageSelectTestController;

class ImageSelectTest extends TestModel
{
    protected $fillable = ["name", "description", "max"];

    function imageSelectImages()
    {
        return $this->hasMany("App\ImageSelectImage");
    }

    function getColourClassAttribute()
    {
        return "success-outline";
    }

    function getRouteNameAttribute()
    {
        return "image-select";
    }

    function getControllerClassAttribute()
    {
        return ImageSelectTestController::class;
    }
}
