@extends ("layouts.results-wide")

@section("card-header",$test->test->name)
@section('card-body')
    <div id="loading" class="text-center">
        <br>
        <img src="/img/load.gif">
    </div>
    <div id="heatmap">
        <canvas id="map" data-img-src="{{route("map.image",["id"=>$test->map])}}"></canvas>
    </div>
@endsection

@section("additional-filters")
    <div class="form-group">
        <lable>Pins</lable>
        {{ Form::select("mapPins[]",$test->mapPins->pluck("name","id"),request()->mapPins,['multiple'=>true, "class"=>"form-control chosenPins"]) }}
    </div>
@endsection


@push("scripts")
    <script src="{{ asset('js/map_results.js') }}"></script>
    <script src="{{ asset('js/heatmap.min.js') }}"></script>
    <script>
        var resultURL = "{{route("map.results.data",["id"=>$test->test->id])}}?{!!http_build_query(request()->all())!!}";

        console.log(resultURL);

        function formatState(state) {

            var baseUrl = "/img/pins";
            var state = $(
                '<span><img src="' + baseUrl + '/' + $(".chosenPins [value='" + state.id + "']").index() + '.png" ' +
                'style="width: 20px; height: 20px" /> ' + state.text + '</span>'
            );
            return state;
        }

        $(document).ready(function () {
            $('.chosenPins').select2({
                placeholder: 'All',
                width: '100%',
                templateResult: formatState,
                templateSelection: formatState,
            });
        });
    </script>
@endpush()