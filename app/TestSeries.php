<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TestSeries extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'test_series';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'url_token', 'user_id'];

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

}
