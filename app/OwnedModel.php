<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 06/12/18
 * Time: 10:07
 */

namespace App;


use App\User;
use Illuminate\Database\Eloquent\Model;

abstract class OwnedModel extends Model
{
    abstract function getOwner() : User;
}