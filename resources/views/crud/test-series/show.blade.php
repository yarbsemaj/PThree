@extends('layouts.card')

@section("title",$testseries->name)
@section('card-body')
    @markdown($testseries->description)

    <a class="btn-primary btn btn-block"
       href="{{route("test-series.consent-form",["formURL"=>$testseries->consent_form])}}">View consent form</a>
    <br>
    <div class="card">
        <div class="card-body">{{route("test.index",["url_token"=>$testseries->url_token])}}</div>
    </div>
    <br>
    <div class="card">
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
                @foreach($testseries->testParticipants as $testParticipant)
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
        <div class="card-body">
            <ul class="list-group rounded">
                @foreach($testseries->tests as $test)
                    <li class="list-group-item list-group-item-{{$test->testable->colourClass}}">
                        <a href="{{route($test->testable->routeName.".show",["id"=>$test->id])}}">{{$test->name}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

