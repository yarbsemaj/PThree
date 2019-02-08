@extends('layouts.test.show')

@section('additional-info')
    <div class="card-group">
        <div class="card col-4" style="padding: 0px;">
            <div class="card-header">Pin Types</div>
            <ul class="list-group list-group-flush">
                @foreach($test->mapPins as $mapPin)
                    <li class="list-group-item">
                        <img src="/img/pins/{{$loop->index}}.png" class="img-fluid"
                             style="width: 30px; height: 30px"/> <b>{{$mapPin->name}}</b></li>
                @endforeach
            </ul>
        </div>
        <div class="card col-8" style="padding: 0px;">
            <div class="card-block">
                <div class="card-header">Map</div>
                <img class="img-fluid" src="{{route("map.image",["id"=>$test->map])}}">
            </div>
        </div>
    </div>
    <br>
@endsection

