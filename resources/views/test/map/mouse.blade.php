@extends ("layouts.test.mouse-display-wide")

@section("card-header",$test->test->name)
@section('card-body')
    <div class="row no-gutters">
        <div class="col-2">
            <ul class="list-group list-group-flush">
                @foreach($test->mapPins as $mapPin)
                    <li class="list-group-item pinType @if($loop->first)active @endif" data-pin-type="{{$loop->index}}">
                        <img src="/img/pins/{{$loop->index}}.png" class="img-fluid"
                             style="width: 30px; height: 30px"/> <b>{{$mapPin->name}}</b></li>
                @endforeach
            </ul>
        </div>
        <div class="col-10">
            <img style="width: 100%" src="{{route("map.image",["id"=>$test->map])}}"></img>
        </div>
    </div>
@endsection

@section("card-footer")
    <a class="btn btn-outline-success btn-lg float-right">Save and Continue <i
                class="far fa-hand-point-right"></i></a>
@endsection
