<?php

namespace App;

use App\OwnedModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TestSeries extends OwnedModel
{
    public function user()
    {
        return $this->belongsTo('App\User');
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
