<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 08/01/19
 * Time: 13:19
 */

namespace App;

//ini_set('error_reporting', E_STRICT);


abstract class TestModel extends OwnedModel
{
    private $name, $description;

    protected static function boot()
    {
        parent::boot();

        parent::retrieved(function ($model) {
            $model->name = $model->test->name;
            $model->description = $model->test->description;
        });

        parent::deleting(function ($model) {
            $model->test->delete();
        });

        parent::created(function ($model) {
            $model->test()->create(["name" => $model->name, "description" => $model->description]);
        });

        parent::updated(function ($model) {
            $model->test()->update(["name" => $model->name, "description" => $model->description]);
        });
    }

    function getOwner(): User
    {
        return $this->test->user;
    }

    abstract function getColourClassAttribute();

    function test()
    {
        return $this->morphOne("App\Test", "testable");
    }

    public function getNameAttribute()
    {
        return $this->name;
    }

    public function setNameAttribute($name)
    {
        $this->name = $name;
    }

    public function getDescriptionAttribute()
    {
        return $this->description;
    }

    public function setDescriptionAttribute($description)
    {
        $this->description = $description;
    }
}