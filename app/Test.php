<?php

namespace App;

use Illuminate\Support\Facades\Auth;

class Test extends OwnedModel
{
    protected $fillable = ["name", "description"];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function testSeries()
    {
        return $this->belongsToMany('App\TestSeries');
    }

    function getOwner(): User
    {
        return $this->user;
    }

    public function testable()
    {
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot();
        parent::creating(function ($model) {
            $model->user_id = Auth::id();
        });
    }

}
