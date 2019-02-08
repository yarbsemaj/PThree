<?php

namespace App;

use Illuminate\Support\Facades\Auth;

class TestSeries extends OwnedModel
{

    protected $fillable = ["name", "description", "consent_form"];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function testParticipants()
    {
        return $this->hasMany('App\TestParticipant');
    }

    public function tests()
    {
        return $this->belongsToMany('App\Test');
    }

    protected static function boot()
    {
        parent::boot();
        parent::creating(function ($model){
            $model->url_token = str_random();
            $model->user_id = Auth::id();
        });
    }

    function getOwner(): User
    {
        return $this->user;
    }


}
