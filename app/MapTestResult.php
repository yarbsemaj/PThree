<?php

namespace App;

class MapTestResult extends TestResultModel
{
    protected $fillable = ["x", "y", "map_pin_id"];

    function mapPins()
    {
        return $this->hasMany("App/MapPin");
    }

}
