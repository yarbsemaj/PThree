<?php

namespace App\Http\Controllers\Test;

use App\OrderTest;
use App\OrderTestResult;
use App\Test;
use App\TestParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderTestController extends TestType
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('owns:Test')->except(['index', 'create', 'store']);
        $this->middleware('testType:OrderTest')->except(['index', 'create', 'store']);

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

        $tests = Test::where("user_id", "=", Auth::id())->where("testable_type", "=", "App\OrderTest");

        if (!empty($keyword)) {
            $tests = $tests->where('name', 'LIKE', "%$keyword%");
        }

        $tests = $tests->latest()->paginate($perPage);

        return view('crud.order.list', ["data" => $tests, "name" => "Order", "search" => $keyword]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('crud.order.create', ["url" => route("order.index")]);
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
            'words' => 'required'
        ]);

        $data = $request->all();
        $words = collect($data["words"]);

        $words = $words->map(function ($item, $key) {
            return ["name" => $item];
        });

        $orderTest = OrderTest::create($data);

        $orderTest->orderTestWords()->createMany($words->toArray());

        return redirect(route("order.index"))->with('flash_message', 'Order Test added!');
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
        $order = Test::findOrFail($id)->testable;

        return view('crud.order.show', ['test' => $order]);
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

        return view('crud.order.edit', array_merge(compact('data'),
            ["url" => route("order.update", ["id" => $id])]));
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
            'words' => 'required'
        ]);

        $orderTest = Test::findOrFail($id)->testable;

        $data = $request->all();

        $orderTest->update($data);

        $orderTest->orderTestWords()->delete();

        $words = collect($data["words"]);

        $words = $words->map(function ($item, $key) {
            return ["name" => $item];
        });

        $orderTest->orderTestWords()->createMany($words->toArray());


        return redirect(route("order.index"))->with('flash_message', 'Order Test updated!');
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

        return redirect(route("order.index"))->with('flash_message', 'Map deleted!');
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

        return view("test.order.index", ["test" => $map]);
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
        $orderTest = $test->testable;

        $request->validate(["words" => "required"],
            ["words.*" => "required|numeric|between:0," . $orderTest->orderTestWords->count()]);

        $index = 1;

        foreach ($request->words as $word) {
            $results = OrderTestResult::create([
                    "position" => $index,
                    "order_test_word_id" => $orderTest->orderTestWords[$word]->id]
            );

            $results->testResult()->create(["test_participant_id" => $participant->id, "test_id" => $id]);
            $index++;
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


        return view("test.order.results", ["test" => $test]);
    }


    public function getResultsData(Request $request, $id)
    {
        $query = parent::getResultsData($request, $id);

        $results = $query->with("testresultsable")->get();

        $result = $results->pluck("testresultsable");

        $test = Test::findOrFail($id);

        $words = $test->testable->orderTestWords;

        $count = array();

        for ($i = 1; $i < $words->count() + 1; $i++) {
            $row = ["Position $i"];
            foreach ($words as $word) {
                $word = $result->where("order_test_word_id", $word->id)->where("position", $i);
                $row[] = $word->count();
            }
            $count[] = $row;
        }

        $wordName = $words->pluck("name");
        return array_merge([array_merge(["Position"], $wordName->toArray())], $count);
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
        return view("test.order.mouse", ["test" => $test]);
    }
}
