@extends ("layouts.test-wide")

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
            <div id="loading" class="text-center">
                <br>
                <img src="/img/load.gif">
            </div>
            <canvas id="map" data-img-src="{{route("map.image",["id"=>$test->map])}}"></canvas>
        </div>
    </div>

    @if($test->test->description)
        <div class="modal show" tabindex="-1" role="dialog" id="descriptionModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Description</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @markdown($test->test->description)
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Continue</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section("card-footer")
    <a id="submit" class="btn btn-outline-success btn-lg float-right">Save and Continue <i
                class="far fa-hand-point-right"></i></a>
@endsection
@push("scripts")
    <script src="{{ asset('js/map.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#descriptionModal').modal('show');
        });
    </script>
@endpush()