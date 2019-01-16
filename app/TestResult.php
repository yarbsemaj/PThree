<?php

namespace App;

class TestResult extends OwnedModel
{
    protected $fillable = ["test_participant_id", "test_id"];

    //
    function getOwner(): User
    {
        // TODO: Implement getOwner() method.
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
