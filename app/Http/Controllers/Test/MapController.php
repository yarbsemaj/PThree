<?php

namespace App\Http\Controllers\Test;

use App\MapTest;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MapController extends TestType
{

    public function __construct()
    {
        Route::get('/home', 'HomeController@index')->name('home');


        $this->middleware('auth');
        $this->middleware('owns:MapTest')->except(['index', 'create', 'store', 'image']);
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
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('crud.map.create', ["url" => route("map.store")]);
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
            'map' => 'required|image'
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
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $map = MapTest::findOrFail($id);

        return view('crud.map.show', ['map' => $map]);
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
        $map = MapTest::findOrFail($id);

        return view('crud.map.edit', array_merge(compact('map'),
            ["url" => route("map.update", ["id" => $id])]));
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
            'map' => 'required|image'
        ]);

        $map = MapTest::findOrFail($id);

        $photoName = request()->file('map')->store('map');

        list($folder, $filename) = explode("/", $photoName);

        $data = $request->all();
        $data["map"] = $filename;

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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        MapTest::destroy($id);

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
        $map = MapTest::findOrFail($id);

        return view("test.map.index", ["test" => $map]);
    }

    /**
     * Stores the result of the test
     *
     * @param Request $request
     * @param $id test id;
     * @return View
     */
    public function storeResult(Request $request, $id): void
    {
        $map = MapTest::findOrFail($id);


    }
}
