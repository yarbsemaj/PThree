@extends('layouts.card')

@section("title",$testseries->name)
@section('card-body')
    @markdown($testseries->description)

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
                            <a href="">
                                {{$testParticipant->id}}
                            </a>
                        </td>
                        <td>
                            {{$testParticipant->policeForce->name}}
                        </td>
                        <td>
                            {{$testParticipant->routeIntoForce->name}}
                        </td>
                        <td>
                            {{$testParticipant->updated_at}}
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
@endsection


