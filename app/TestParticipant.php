<?php

namespace App;

class TestParticipant extends OwnedModel
{

    protected static function boot()
    {
        parent::boot();
        parent::creating(function ($model) {
            $model->token = str_random();
        });
    }

    function getOwner(): User
    {
        return $this->test_series->user;
    }

    function policeForce()
    {
        return $this->belongsTo("App\PoliceForce");
    }

    function routeIntoRole()
    {
        return $this->belongsTo("App\RouteIntoRole");
    }

    function testSeries()
    {
        return $this->belongsTo("App\TestSeries");
    }
}
