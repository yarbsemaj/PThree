<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 15/01/19
 * Time: 15:44
 */

namespace App\Http\View\Composers;


use App\PoliceForce;
use App\RouteIntoRole;
use App\Test;
use Illuminate\View\View;

class ResultsComposer
{


    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {

        $test = Test::findOrFail(request()->id);

        $training = [];
        for ($i = 0; $i < 60; $i++) {
            $training[date("Y") - $i] = date("Y") - $i;
        }

        $yearsInRole = [
            0 => "Less that a year",
            1 => "1 year"];
        for ($i = 2; $i < 58; $i++) {
            $yearsInRole[$i] = $i . " years";
        }

        $testParticipants = $test->testResults()->groupBy("test_participant_id")->with("testParticipant")->get(["test_participant_id"])->pluck("testParticipant.token", "testParticipant.id");

        $view->with('policeForce', PoliceForce::all()->pluck("name", "id"));
        $view->with('routeIntroRole', RouteIntoRole::all()->pluck("name", "id"));
        $view->with('training', $training);
        $view->with('yearInRole', $yearsInRole);
        $view->with("testSeries", $test->testSeries->pluck("name", "id"));
        $view->with("testParticipant", $testParticipants);

    }
}