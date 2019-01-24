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

        parent::deleting(function ($model) {
            $model->testResults()->delete();
        });
    }

    function getOwner(): User
    {
        return $this->testSeries->user;
    }

    function testResults()
    {
        return $this->hasMany("App\TestResult");
    }


    function policeForce()
    {
        return $this->belongsTo("App\PoliceForce");
    }

    function country()
    {
        return $this->belongsTo("App\Country");
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
