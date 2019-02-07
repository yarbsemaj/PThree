<?php

namespace App;

class MapTestResult extends TestResultModel
{
    protected $fillable = ["x", "y", "map_pin_id", "reason"];
    protected $appends = ["pinIndex"];

    function mapPin()
    {
        return $this->belongsTo("App\MapPin");
    }

    function getPinIndexAttribute()
    {

        return $this->testResult->test->testable->mapPins->search($this->mapPin);
    }

}
