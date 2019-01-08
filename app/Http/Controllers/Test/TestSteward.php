<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 06/12/18
 * Time: 23:33
 */

namespace App\Http\Controllers\Test;


use App\PoliceForce;
use App\RouteIntoRole;
use App\TestParticipant;
use App\TestSeries;
use Illuminate\Http\Request;


class TestSteward
{

    function index(Request $request, $testToken)
    {
        $testSeries = TestSeries::where("url_token", $testToken)->first();
        $policeForce = PoliceForce::all();
        $routeIntoRole = RouteIntoRole::all();

        return view("test.start-series",
            ["testSeries" => $testSeries, "policeForce" => $policeForce, "routeIntoRole" => $routeIntoRole]);
    }

    function store(Request $request, $testToken)
    {

        $testSeries = TestSeries::where("url_token", $testToken)->first();


        $dataRange = (date("Y") - 100) . "," . date("Y");

        $request->validate([
            "policeForce" => "required",
            "routeIntoRole" => "required",
            "training" => "",
            "yearsInRole" => "required|between:0,100"]);


        $participant = new TestParticipant();
        $policeForce = PoliceForce::firstOrCreate(["name" => $request->policeForce]);
        $routeIntoRole = RouteIntoRole::firstOrCreate(["name" => $request->routeIntoRole]);

        $participant->policeForce()->associate($policeForce);
        $participant->routeIntoRole()->associate($routeIntoRole);

        $participant->testSeries()->associate($testSeries);

        $participant->training = $request->traning;
        $participant->years_in_role = $request->yearsInRole;

        $participant->save();

    }


}