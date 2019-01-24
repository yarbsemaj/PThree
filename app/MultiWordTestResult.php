<?php

namespace App;

class MultiWordTestResult extends TestResultModel
{
    protected $fillable = ["word_test_word_id"];

    function wordTestWord()
    {
        return $this->belongsTo("App\WordTestWord");
    }
}
