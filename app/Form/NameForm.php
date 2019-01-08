<?php

namespace App\Form;

use Kris\LaravelFormBuilder\Form;

class NameForm extends Form
{
    public function buildForm()
    {
       $this->add("name","text",["rules"=>"required"]);
    }
}
