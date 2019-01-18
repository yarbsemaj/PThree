<?php

namespace App;

class TestResult extends OwnedModel
{
    protected $fillable = ["test_participant_id", "test_id"];

    protected static function boot()
    {
        parent::boot();
        parent::deleting(function ($model) {
            $model->testresultsable()->delete();
        });

    }

    function getOwner(): User
    {
        return $this->testParticipant->getOwner();
    }

    public function testParticipant()
    {
        return $this->belongsTo('App\TestParticipant');
    }

    public function test()
    {
        return $this->belongsTo('App\Test');
    }


    public function testresultsable()
    {
        return $this->morphTo();
    }
}
