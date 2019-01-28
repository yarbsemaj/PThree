<?php

namespace App;

class ImageSelectTestResult extends TestResultModel
{
    protected $fillable = ["image_select_image_id"];

    function imageTestImage()
    {
        return $this->belongsTo("App\ImageSelectImage");
    }
}
