<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TestSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestSeriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('owns:TestSeries')->except(['index','create','store']);
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

        $testseries = TestSeries::where("user_id","=",Auth::id());

        if (!empty($keyword)) {
            $testseries = $testseries->where('title', 'LIKE', "%$keyword%");
        }

        $testseries = $testseries->latest()->paginate($perPage);

        return view('crud.list.generic',["data"=>$testseries,"name"=>"Test Series","search" => $keyword]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('crud.test-series.create');
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
			'title' => 'required|max:10'
		]);
        $requestData = $request->all();
        
        TestSeries::create($requestData);

        return redirect('admin/test-series')->with('flash_message', 'TestSeries added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $testseries = TestSeries::findOrFail($id);

        return view('admin.test-series.show', compact('testseries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $testseries = TestSeries::findOrFail($id);

        return view('admin.test-series.edit', compact('testseries'));
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
			'title' => 'required|max:10'
		]);
        $requestData = $request->all();
        
        $testseries = TestSeries::findOrFail($id);
        $testseries->update($requestData);

        return redirect('admin/test-series')->with('flash_message', 'TestSeries updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        TestSeries::destroy($id);

        return redirect('admin/test-series')->with('flash_message', 'Test Series deleted!');
    }
}
