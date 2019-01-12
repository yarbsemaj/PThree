@extends('layouts.card')

@section("title",$map->name)
@section('card-body')
    @markdown($map->description)
    <div class="card-group">
        <div class="card col-4" style="padding: 0px;">
            <div class="card-header">Pin Types</div>
            <ul class="list-group list-group-flush">
                @foreach($map->mapPins as $mapPin)
                    <li class="list-group-item">
                        <img src="/img/pins/{{$loop->index}}.png" class="img-fluid"
                             style="width: 30px; height: 30px"/> <b>{{$mapPin->name}}</b></li>
                @endforeach
            </ul>
        </div>
        <div class="card col-8" style="padding: 0px;">
            <div class="card-block">
                <div class="card-header">Map</div>
                <img class="img-fluid" src="{{route("map.image",["id"=>$map->map])}}">
            </div>
        </div>

    </div>
    <br>
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
                @foreach($map->test->testSeries as $testParticipant)
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


