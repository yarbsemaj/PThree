<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\TestParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestParticipantController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('owns:TestParticipant')->except(['index']);
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

        $testParticipant = TestParticipant::whereHas("testSeries", function ($query) {
            return $query->where("user_id", "=", Auth::id());
        });

        if (!empty($keyword)) {
            $testParticipant = $testParticipant->where('token', 'LIKE', "%$keyword%");
        }

        $testParticipant = $testParticipant->latest()->paginate($perPage);

        return view('crud.test-participant.list', ["data" => $testParticipant, "name" => "Test Participants", "search" => $keyword]);
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
        $participant = TestParticipant::findOrFail($id);

        return view('crud.test-participant.show', ['data' => $participant]);
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
        TestParticipant::destroy($id);

        return redirect(route("test-series.index"))->with('flash_message', 'Test Series deleted!');
    }
}
