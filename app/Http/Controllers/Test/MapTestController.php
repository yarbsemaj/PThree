<?php

namespace App\Http\Controllers\Test;

use App\MapTest;
use App\MapTestResult;
use App\Test;
use App\TestParticipant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class MapTestController extends TestType
{

    public function __construct()
    {
        $this->middleware('auth')->except(['image']);
        $this->middleware('owns:Test')->except(['index', 'create', 'store', 'image']);
        $this->middleware('testType:MapTest')->except(['index', 'create', 'store', 'image']);

    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        $tests = Test::where("user_id", "=", Auth::id())->where("testable_type", "=", "App\MapTest");

        if (!empty($keyword)) {
            $tests = $tests->where('name', 'LIKE', "%$keyword%");
        }

        $tests = $tests->latest()->paginate($perPage);

        return view('crud.map.list', ["data" => $tests, "name" => "Map", "search" => $keyword]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('crud.map.create', ["url" => route("map.store")]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'map' => 'required|image',
            'mapPins' => 'required'
        ]);

        $data = $request->all();
        $mapPins = collect($data["mapPins"]);

        $mapPins = $mapPins->map(function ($item, $key) {
            return ["name" => $item];
        });

        $photoName = request()->file('map')->store('map');

        list($folder, $filename) = explode("/", $photoName);

        $data["map"] = $filename;

        $map = MapTest::create($data);

        $map->mapPins()->createMany($mapPins->toArray());

        return redirect(route("map.index"))->with('flash_message', 'Map added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return View
     */
    public function show($id)
    {
        $map = Test::findOrFail($id)->testable;

        return view('crud.map.show', ['test' => $map]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return View
     */
    public function edit($id)
    {
        $map = Test::findOrFail($id)->testable;

        return view('crud.map.edit', array_merge(compact('map'),
            ["url" => route("map.update", ["id" => $id])]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     *
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
            'map' => 'required|image',
            'mapPins' => 'required'
        ]);

        $map = Test::findOrFail($id)->testable;

        $photoName = request()->file('map')->store('map');

        list($folder, $filename) = explode("/", $photoName);

        $data = $request->all();
        $data["map"] = $filename;

        Test::findOrFail($id)->update($data);

        $map->update($data);

        $map->mapPins()->delete();

        $mapPins = collect($data["mapPins"]);

        $mapPins = $mapPins->map(function ($item, $key) {
            return ["name" => $item];
        });

        $map->mapPins()->createMany($mapPins->toArray());

        return redirect(route("map.index"))->with('flash_message', 'Map updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        $map = Test::findOrFail($id)->testable->delete();

        return redirect(route("map.index"))->with('flash_message', 'Map deleted!');
    }

    public function image(Request $request, $imageURL)
    {
        return response()->file(Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . "map/" . $imageURL);
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

        return view("test.map.index", ["test" => $map]);
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
        $test = Test::find($id);
        $mapTest = $test->testable;

        $request->validate([
            "dataToDisplay.*.x" => "required|numeric|between:0.0,1.0",
            "dataToDisplay.*.y" => "required|numeric|between:0.0,1.0",
            "dataToDisplay.*.type" => "required|numeric|between:0," . $mapTest->mapPins->count()]);

        $pins = $mapTest->mapPins;

        foreach ($request->pins as $pin) {
            $results = MapTestResult::create([
                "x" => $pin["x"],
                    "y" => $pin["y"],
                "map_pin_id" => $pins[$pin["type"]]->id,
                "reason" => $pin["reason"]]);
            $results->testResult()->create(["test_participant_id" => $participant->id, "test_id" => $id]);
        }
    }

    /**
     * Returns a view with the results for a particular test
     * @param Request $request
     * @param $id
     * @return View
     */
    public function getResult(Request $request, $id): View
    {
        $map = Test::findOrFail($id)->testable;

        return view("test.map.results", ["test" => $map]);
    }

    public function getResultsData(Request $request, $id)
    {
        $query = parent::getResultsData($request, $id);

        $query = $query->with(["test", "testresultsable.testResult.testParticipant",
            "testresultsable.testResult.testParticipant.testSeries"]);

        $results = $query->get()->pluck("testresultsable");

        return $results;
    }

    /**
     * Returns a view with the mouse data overlay
     * @param Request $request
     * @param $testID
     * @param $participantID
     * @return View
     */
    public function getMouse(Request $request, $testID, $participantID): View
    {
        $test = Test::findOrFail($testID)->testable;
        return view("test.map.mouse", ["test" => $test]);
    }
}
