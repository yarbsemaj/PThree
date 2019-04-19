<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Rules\Owns;
use App\Test;
use App\TestSeries;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TestSeriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['consentForm']);
        $this->middleware('owns:TestSeries')->except(['index', 'create', 'store', 'consentForm']);
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

        $testseries = TestSeries::where("user_id","=",Auth::id());

        if (!empty($keyword)) {
            $testseries = $testseries->where('name', 'LIKE', "%$keyword%");
        }

        $testseries = $testseries->latest()->paginate($perPage);

        return view('crud.test-series.list', ["data" => $testseries, "name" => "Test Series", "search" => $keyword]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('crud.test-series.create', ["url" => route("test-series.store")]);
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
            'consent_form' => 'required|file|mimes:pdf,doc,docx'
        ]);
        $consentForm = request()->file('consent_form')->store('consent_form');

        list($folder, $filename) = explode("/", $consentForm);

        $data = $request->all();
        $data["consent_form"] = $filename;

        TestSeries::create($data);

        return redirect(route("test-series.index"))->with('flash_message', 'TestSeries added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return View
     */
    public function show($id)
    {
        $testseries = TestSeries::findOrFail($id);

        return view('crud.test-series.show', ['testseries' => $testseries]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return View
     */
    public function edit($id)
    {
        $testseries = TestSeries::findOrFail($id);

        return view('crud.test-series.edit', array_merge(compact('testseries'),
            ["url" => route("test-series.update", ["id" => $id])]));
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
            'consent_form' => 'required|file|mimes:pdf,doc,docx'
		]);
        $consentForm = request()->file('consent_form')->store('consent_form');

        list($folder, $filename) = explode("/", $consentForm);

        $data = $request->all();
        $data["consent_form"] = $filename;

        $testseries = TestSeries::findOrFail($id);
        $testseries->update($data);

        return redirect(route("test-series.index"))->with('flash_message', 'Test Series updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        TestSeries::destroy($id);
        return redirect(route("test-series.index"))->with('flash_message', 'Test Series deleted!');
    }

    public function setupTest(Request $request, $id)
    {
        $allTests = Test::where('user_id', Auth::id())->get();

        $testSeries = TestSeries::findOrFail($id);
        $currentTests = $testSeries->tests;
        $unusedTests = $allTests->diff($currentTests);

        return view("crud.test-series.add-test",
            ["testSeries" => $testSeries, "currentTests" => $currentTests, "unusedTests" => $unusedTests]);
    }

    public function saveSetupTest(Request $request, $id)
    {

        $this->validate($request, [
            'name.*' => [new Owns(Test::class)]
        ]);

        $testSeries = TestSeries::findOrFail($id);
        $testSeries->tests()->detach();
        $testSeries->tests()->attach($request->name);

        return redirect()->route("test-series.index");
    }

    public function consentForm(Request $request, $formURL)
    {
        return response()->file(Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . "consent_form/" . $formURL);
    }
}
