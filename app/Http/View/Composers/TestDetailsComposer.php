<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 15/01/19
 * Time: 15:44
 */

namespace App\Http\View\Composers;

use App\Test;
use Illuminate\View\View;

class TestDetailsComposer
{


    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {

        $test = array_first(Test::findOrFail(request()->route()->parameters()));

        $testParticipants = $test->testResults()->groupBy("test_participant_id")->with("testParticipant")->get(["test_participant_id"])->pluck("testParticipant");


        $view->with("testSeriess", $test->testSeries);
        $view->with("testParticipants", $testParticipants);
    }
}