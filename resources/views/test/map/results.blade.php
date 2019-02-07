@extends ("layouts.results-wide")

@section("card-header",$test->test->name)
@section('card-body')
    <div id="loading" class="text-center">
        <br>
        <img src="/img/load.gif">
    </div>
    <div id="heatmap">
        <canvas style="z-index: 1000" id="map" data-img-src="{{route("map.image",["id"=>$test->map])}}"></canvas>
    </div>

    <div id="table_div"></div>
@endsection

@section("tips")
    <ul>
        <li>User CTRL + Click to select multiple rows from the results table.</li>
        <li>Hit esc to clear your selection in the results table.</li>
        <li>Click on a pin on the map to find it in the table</li>
    </ul>
@endsection

@push("scripts")
    <script src="{{ asset('js/map_results.js') }}"></script>
    <script src="{{ asset('js/heatmap.min.js') }}"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <script>
        var resultURL = "{{route("map.results.data",["id"=>$test->test->id])}}?{!!http_build_query(request()->all())!!}";
    </script>
@endpush()