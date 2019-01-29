<?php

namespace App\Http\Controllers\Test;

use App\MultiWordTest;
use App\MultiWordTestResult;
use App\Test;
use App\TestParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WordTestController extends TestType
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('owns:Test')->except(['index', 'create', 'store']);
        $this->middleware('testType:MultiWordTest')->except(['index', 'create', 'store']);
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

        $tests = Test::where("user_id", "=", Auth::id())->where("testable_type", "=", "App\MultiWordTest");

        if (!empty($keyword)) {
            $tests = $tests->where('name', 'LIKE', "%$keyword%");
        }

        $tests = $tests->latest()->paginate($perPage);

        return view('crud.word.list', ["data" => $tests, "name" => "Word", "search" => $keyword]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('crud.word.create', ["url" => route("word.index")]);
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
            'words' => 'required',
            'max' => "required|numeric|min:0"
        ]);

        $data = $request->all();
        $words = collect($data["words"]);

        $words = $words->map(function ($item, $key) {
            return ["name" => $item];
        });

        $orderTest = MultiWordTest::create($data);

        $orderTest->wordTestWords()->createMany($words->toArray());

        return redirect(route("word.index"))->with('flash_message', 'Word Test added!');
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

        return view('crud.word.show', ['test' => $multiWord]);
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

        return view('crud.word.edit', array_merge(compact('data'),
            ["url" => route("word.update", ["id" => $id])]));
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
                'words' => 'required',
                'max' => "required|numeric|min:0"]
        );

        $wordTest = Test::findOrFail($id)->testable;

        $data = $request->all();

        $wordTest->update($data);

        $wordTest->wordTestWords()->delete();

        $words = collect($data["words"]);

        $words = $words->map(function ($item, $key) {
            return ["name" => $item];
        });

        $wordTest->wordTestWords()->createMany($words->toArray());


        return redirect(route("word.index"))->with('flash_message', 'Order Test updated!');
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

        return redirect(route("word.index"))->with('flash_message', 'Word deleted!');
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

        return view("test.word.index", ["test" => $map]);
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
        $wordTest = $test->testable;

        $request->validate(["words" => "required"],
            ["words.*" => "required|numeric|between:0," . $wordTest->wordTestWords->count()]);

        foreach ($request->words as $word) {
            $results = MultiWordTestResult::create([
                    "word_test_word_id" => $wordTest->wordTestWords[$word]->id]
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

        return view("test.word.results", ["test" => $test]);
    }


    public function getResultsData(Request $request, $id)
    {
        $query = parent::getResultsData($request, $id);

        $results = $query->with("testresultsable")->get();

        $result = $results->pluck("testresultsable");

        $test = Test::findOrFail($id);

        $words = $test->testable->wordTestWords;

        $count = [["Word", "Responses"]];
        foreach ($words as $word) {
            ;
            $wordCount = $result->where("word_test_word_id", $word->id)->count();
            $row[] = [$word->name, $wordCount];
        }
        $count = array_merge($count, $row);

        return $count;
    }

    public function getMouse(Request $request, $testID, $participantID): View
    {
        $test = Test::findOrFail($testID)->testable;
        return view("test.word.mouse", ["test" => $test]);
    }

}
