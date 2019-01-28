<?php

namespace App\Http\Controllers\Test;

use App\ImageSelectTest;
use App\ImageSelectTestResult;
use App\Test;
use App\TestParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ImageSelectTestController extends TestType
{

    public function __construct()
    {
        $this->middleware('auth')->except(['image']);
        $this->middleware('owns:Test')->except(['index', 'create', 'store', 'image']);
        $this->middleware('testType:ImageSelectTest')->except(['index', 'create', 'store', 'image']);
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

        $tests = Test::where("user_id", "=", Auth::id())->where("testable_type", "=", "App\ImageSelectTest");

        if (!empty($keyword)) {
            $tests = $tests->where('name', 'LIKE', "%$keyword%");
        }

        $tests = $tests->latest()->paginate($perPage);

        return view('crud.image-select.list', ["data" => $tests, "name" => "Image Select Test", "search" => $keyword]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('crud.image-select.create', ["url" => route("image-select.index")]);
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
            'images' => 'required',
            'images.*' => 'image',
            'max' => "required|numeric|min:0"
        ]);

        $data = $request->all();

        $images = $request->images;

        $imageData = array();

        foreach ($images as $image) {
            $photoName = $image->store('image-select');

            list($folder, $filename) = explode("/", $photoName);

            $imageData[] = ["image" => $filename];
        }


        $test = ImageSelectTest::create($data);

        $test->imageSelectImages()->createMany($imageData);


        return redirect(route("image-select.index"))->with('flash_message', 'Word Test added!');
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
        $multiWord = Test::findOrFail($id)->testable;

        return view('crud.image-select.show', ['test' => $multiWord]);
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

        return view('crud.image-select.edit', array_merge(compact('data'),
            ["url" => route("image-select.update", ["id" => $id])]));
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
            'images' => 'required',
            'images.*' => 'image',
            'max' => "required|numeric|min:0"
        ]);

        $data = $request->all();

        $images = $request->images;

        $imageData = array();

        foreach ($images as $image) {
            $photoName = $image->store('image-select');

            list($folder, $filename) = explode("/", $photoName);

            $imageData[] = ["image" => $filename];
        }

        $test = Test::findOrFail($id)->testable;

        $test->update($data);

        $test->imageSelectImages()->delete();

        $test->imageSelectImages()->createMany($imageData);

        return redirect(route("image-select.index"))->with('flash_message', 'Order Test updated!');
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
        Test::findOrFail($id)->testable->delete();

        return redirect(route("image-select.index"))->with('flash_message', 'Word deleted!');
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

        return view("test.image-select.index", ["test" => $map]);
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
        $imageTest = $test->testable;

        $request->validate(["images" => "required"],
            ["images.*" => "required|numeric|between:0," . $imageTest->imageSelectImages->count()]);

        foreach ($request->images as $image) {
            $results = ImageSelectTestResult::create([
                    "image_select_image_id" => $imageTest->imageSelectImages[$image]->id]
            );

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
        $test = Test::findOrFail($id)->testable;

        return view("test.image-select.results", ["test" => $test]);
    }


    public function getResultsData(Request $request, $id)
    {
        $query = parent::getResultsData($request, $id);

        $results = $query->with("testresultsable")->get();

        $result = $results->pluck("testresultsable");

        $test = Test::findOrFail($id);

        $images = $test->testable->imageSelectImages;

        $count = [];
        foreach ($images as $image) {
            ;
            $imgCount = $result->where("image_select_image_id", $image->id)->count();
            $row[] = ["Image " . $image->id, $imgCount,
                "<img class='img-fluid' style='max-height:300px' src='" . route("image-select.image", ["image" => $image->image]) . "'>"];
        }
        $count = array_merge($count, $row);

        return $count;
    }

    public function image(Request $request, $imageURL)
    {
        return response()->file(Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . "image-select/" . $imageURL);
    }

}
