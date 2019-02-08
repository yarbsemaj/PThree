<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 06/12/18
 * Time: 23:33
 */

namespace App\Http\Controllers\Test;

use App\Country;
use App\MousePosition;
use App\PoliceForce;
use App\RouteIntoRole;
use App\TestParticipant;
use App\TestSeries;
use Illuminate\Http\Request;

class TestSteward
{

    function basics(Request $request, $testToken)
    {
        $testSeries = TestSeries::where("url_token", $testToken)->firstOrFail();
        $policeForce = PoliceForce::all();
        $country = Country::all();
        $routeIntoRole = RouteIntoRole::all();

        return view("test.start-series",
            ["testSeries" => $testSeries,
                "policeForce" => $policeForce,
                "routeIntoRole" => $routeIntoRole,
                "country" => $country]);
    }

    function store(Request $request, $testToken)
    {

        $testSeries = TestSeries::where("url_token", $testToken)->firstOrFail();

        $request->validate([
            "policeForce" => "required",
            "routeIntoRole" => "required",
            "country" => "required",
            "training" => "required",
            "yearsInRole" => "required|between:0,100",
            "g-recaptcha-response" => "required|recaptcha",
            "consent" => "required"],
            ["g-recaptcha-response.required" => "Please confirm you are not a robot.",
                "consent.required" => "Please read and accept the consent form."]);

        $participant = new TestParticipant();
        $policeForce = PoliceForce::firstOrCreate(["name" => $request->policeForce]);
        $routeIntoRole = RouteIntoRole::firstOrCreate(["name" => $request->routeIntoRole]);
        $country = Country::firstOrCreate(["name" => $request->country]);

        $participant->country()->associate($country);
        $participant->policeForce()->associate($policeForce);
        $participant->routeIntoRole()->associate($routeIntoRole);

        $participant->testSeries()->associate($testSeries);

        $participant->training = $request->training;
        $participant->years_in_role = $request->yearsInRole;

        $participant->save();

        return redirect()->route("test.begin", ["participantToken" => $participant->token]);
    }

    function getTestStart(Request $request, $participantToken)
    {
        $participant = TestParticipant::where("token", "=", $participantToken)->firstOrFail();
        $testSeries = $participant->testSeries;
        return view("test.info-serise", ["testSeries" => $testSeries, "testParticipant" => $participant]);
    }

    function index(Request $request, $testToken)
    {
        $testSeries = TestSeries::where("url_token", $testToken)->firstOrFail();
        return view("test.description-series", ["testSeries" => $testSeries]);
    }

    function getTest(Request $request, $participantToken)
    {
        $participant = TestParticipant::where("token", "=", $participantToken)->firstOrFail();
        $testSeries = $participant->testSeries;
        $tests = $testSeries->tests;
        if ($tests->count() > $participant->test_step) {
            $test = $tests->get($participant->test_step);
            $controllerName = $test->testable->controllerClass;
            $controller = new $controllerName;
            return ($controller->displayTest($request, $test->id));
        } else {
            return view("test.end-series", ["testSeries" => $testSeries, "testParticipant" => $participant]);
        }
    }

    function saveTest(Request $request, $participantToken)
    {
        $participant = TestParticipant::where("token", "=", $participantToken)->firstOrFail();
        $testSeries = $participant->testSeries;
        $tests = $testSeries->tests;
        if ($tests->count() > $participant->test_step) {
            $test = $tests->get($participant->test_step);
            $controllerName = $test->testable->controllerClass;
            $controller = new $controllerName;
            $controller->storeResult($request, $test->id, $participant);
        } else {
            return response('', 404);
        }
    }

    function saveMouse(Request $request, $participantToken)
    {
        $participant = TestParticipant::where("token", "=", $participantToken)->firstOrFail();
        $testSeries = $participant->testSeries;
        $tests = $testSeries->tests;
        if ($tests->count() > $participant->test_step) {
            $test = $tests->get($participant->test_step);

            $mouseData = collect($request->mousePositions);

            $mouseData = $mouseData->map(function ($mouse) use ($test, $participant) {
                $mouse['test_id'] = $test->id;
                $mouse['test_participant_id'] = $participant->id;
                return $mouse;
            });

            MousePosition::insert($mouseData->toArray());
            $participant->test_step++;
            $participant->save();

        } else {
            return response('', 404);
        }
    }
}