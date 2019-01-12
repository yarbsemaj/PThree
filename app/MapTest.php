<?php

namespace App;

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
}
