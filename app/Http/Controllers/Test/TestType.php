<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 09/01/19
 * Time: 15:45
 */

namespace App\Http\Controllers\Test;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

abstract class TestType extends Controller
{

    /**
     * Returns the view the test
     *
     * @param Request $request
     * @param $id test id;
     * @return View
     */
    public abstract function displayTest(Request $request, $id): View;

    /**
     * Stores the result of the test
     *
     * @param Request $request
     * @param $id test id;
     * @return View
     */
    public abstract function storeResult(Request $request, $id): void;

}