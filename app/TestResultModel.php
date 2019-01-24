<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 08/01/19
 * Time: 13:19
 */

namespace App;

//ini_set('error_reporting', E_STRICT);


abstract class TestResultModel extends OwnedModel
{
    protected static function boot()
    {
        parent::boot();

        parent::deleting(function ($model) {
            $model->testResult->delete();
        });
    }

    function getOwner(): User
    {

    }

    function testResult()
    {
        return $this->morphOne("App\TestResult", "testresultsable");
    }

}