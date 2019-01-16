<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 09/01/19
 * Time: 15:45
 */

namespace App\Http\Controllers\Test;


use App\Http\Controllers\Controller;
use App\Test;
use App\TestParticipant;
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
     * @param TestParticipant $participant
     * @return void
     */
    public abstract function storeResult(Request $request, $id, TestParticipant $participant): void;

    /**
     * Returns a view with the results for a particular test
     * @param Request $request
     * @param $id
     * @return View
     */
    public abstract function getResult(Request $request, $id): View;


    public function getResultsData(Request $request, $id)
    {
        $test = Test::findOrFail($id);

        $results = $test->testResults();

        if ($request->routeIntoRole != null) {
            $results->where(function ($query) use ($request) {
                foreach ($request->routeIntoRole as $routeIntoRole) {
                    $query = $query->orWhereHas('testParticipant', function ($query) use ($routeIntoRole) {
                        $query->where('route_into_role_id', '=', $routeIntoRole);
                    });
                }
            });
        }

        if ($request->policeForce != null) {
            $results->where(function ($query) use ($request) {
                foreach ($request->policeForce as $policeForce) {
                    $query = $query->orWhereHas('testParticipant', function ($query) use ($policeForce) {
                        $query->where('police_force_id', '=', $policeForce);
                    });
                }
            });
        }

        if ($request->minYearsInRole != null) {
            $results = $results->whereHas('testParticipant', function ($query) use ($request) {
                $query->where('years_in_role', '>', $request->minYearsInRole);
            });
        }

        if ($request->maxYearsInRole != null) {
            $results = $results->whereHas('testParticipant', function ($query) use ($request) {
                $query->where('years_in_role', '<', $request->maxYearsInRole);
            });
        }

        if ($request->minTraining != null) {
            $results = $results->whereHas('testParticipant', function ($query) use ($request) {
                $query->where('training', '>', $request->minTraining);
            });
        }

        if ($request->maxTraining != null) {
            $results = $results->whereHas('testParticipant', function ($query) use ($request) {
                $query->where('training', '<', $request->maxTraining);
            });
        }

        if ($request->testParticipant != null) {
            $results->where(function ($query) use ($request) {
                foreach ($request->testParticipant as $testParticipant) {
                    $query = $query->orWhereHas('testParticipant', function ($query) use ($testParticipant) {
                        $query->where('id', '=', $testParticipant);
                    });
                }
            });
        }

        if ($request->testSeries != null) {
            $results->where(function ($query) use ($request) {
                foreach ($request->testSeries as $testSeries) {
                    $query = $query->orWhereHas('test.testSeries', function ($query) use ($testSeries) {
                        $query->where('test_series.id', '=', $testSeries);
                    });
                }
            });
        }


        return $results;
    }


}