<?php

namespace App;

class OrderTestResult extends TestResultModel
{
    protected $fillable = ["position", "order_test_word_id"];

    function orderTestWord()
    {
        return $this->belongsTo("App\OrderTestWord");
    }
}
