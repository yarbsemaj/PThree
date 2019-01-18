<?php

namespace App\Http\Controllers\Test;

use App\FreeTextTest;
use App\FreeTextTestResult;
use App\Test;
use App\TestParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FreeTextTestController extends TestType
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('owns:Test')->except(['index', 'create', 'store']);
        $this->middleware('testType:FreeTextTest')->except(['index', 'create', 'store']);

    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        $tests = Test::where("user_id", "=", Auth::id())->where("testable_type", "=", "App\FreeTextTest");

        if (!empty($keyword)) {
            $tests = $tests->where('name', 'LIKE', "%$keyword%");
        }

        $tests = $tests->latest()->paginate($perPage);

        return view('crud.free-text.list', ["data" => $tests, "name" => "Free Text", "search" => $keyword]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('crud.free-text.create', ["url" => route("free-text.index")]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $data = $request->all();

        FreeTextTest::create($data);

        return redirect(route("free-text.index"))->with('flash_message', 'Free Text Test added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $freeText = Test::findOrFail($id)->testable;

        return view('crud.free-text.show', ['test' => $freeText]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data = Test::findOrFail($id)->testable;

        return view('crud.free-text.edit', array_merge(compact('data'),
            ["url" => route("free-text.update", ["id" => $id])]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
        ]);

        $freeTextTest = Test::findOrFail($id)->testable;

        $data = $request->all();

        $freeTextTest->update($data);

        return redirect(route("free-text.index"))->with('flash_message', 'Free Text Test updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Test::findOrFail($id)->testable->destroy();

        return redirect(route("free-text.index"))->with('flash_message', 'Map deleted!');
    }

    /**
     * Returns the view the test
     *
     * @param Request $request
     * @param $id test id;
     * @return View
     */
    public function displayTest(Request $request, $id): View
    {
        $map = Test::findOrFail($id)->testable;

        return view("test.free-text.index", ["test" => $map]);
    }

    /**
     * Stores the result of the test
     *
     * @param Request $request
     * @param $id test id;
     * @param TestParticipant $participant
     * @return void
     */
    public function storeResult(Request $request, $id, TestParticipant $participant): void
    {
        $request->validate(["answer" => "required"]);
        $results = FreeTextTestResult::create($request->all());
        $results->testResult()->create(["test_participant_id" => $participant->id, "test_id" => $id]);
    }


    /**
     * Returns a view with the results for a particular test
     * @param Request $request
     * @param $id
     * @return View
     */
    public function getResult(Request $request, $id): View
    {
        $test = Test::findOrFail($id)->testable;


        return view("test.free-text.results", ["test" => $test]);
    }


    public function getResultsData(Request $request, $id)
    {
        $query = parent::getResultsData($request, $id);

        $results = $query->with("testresultsable")->get();

        $results = $results->pluck("testresultsable");

        $wordCount = collect(array_count_values(explode(" ", $results->pluck("answer")->implode(" "))));

        $wordCount = $wordCount->map(function ($item, $key) {
            return ["text" => $key, "weight" => $item];
        })->values();

        $answers = $results->map(function ($item) {
            return [
                $item->testResult->testParticipant->token,
                $item->answer,
                $item->testResult->testParticipant->testSeries->name,
                $item->testResult->testParticipant->policeForce->name,
                $item->testResult->testParticipant->routeIntoRole->name,
                $item->testResult->testParticipant->years_in_role,
                $item->testResult->testParticipant->traning];
        })->values();


        return ["tagCloud" => $wordCount, "answers" => $answers];
    }

}
