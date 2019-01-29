<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MousePosition extends Model
{
    protected $fillable = ["x", "y", "event", "time_stamp", "test_id", "test_participant_id"];

    protected $casts = ["event" => "array"];
}
