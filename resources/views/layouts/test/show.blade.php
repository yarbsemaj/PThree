@extends('layouts.card')

@section("title",$test->name)
@section('card-body')
    @markdown($test->description)

    @yield("additional-info")

    <div class="card">
        <div class="card-header">Results</div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Participant ID</th>
                    <th>Force</th>
                    <th>Occupation</th>
                    <th>Date</th>
                </tr>
                </thead>
                @foreach($testParticipants as $testParticipant)
                    <tr>
                        <td>
                            <a href="{{route("test-participant.show",["id"=>$testParticipant->id])}}">
                                {{$testParticipant->token}}
                            </a>
                        </td>
                        <td>
                            {{$testParticipant->policeForce->name}}
                        </td>
                        <td>
                            {{$testParticipant->routeIntoRole->name}}
                        </td>
                        <td>
                            {{$testParticipant->updated_at}}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header">Test Series</div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Participant ID</th>
                    <th>Name</th>
                    <th>Date</th>
                </tr>
                </thead>
                @foreach($testSeriess as $testSeries)
                    <tr>
                        <td>
                            <a href="{{route("test-series.show",["id"=>$testSeries->id])}}">
                                {{$testSeries->id}}
                            </a>
                        </td>
                        <td>
                            {{$testSeries->name}}
                        </td>
                        <td>
                            {{$testSeries->name}}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection