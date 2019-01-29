@extends ("layouts.app")
@section('content')
    <div class="container" style="max-width:1500px; padding-bottom: 65px">
        <div id="heat-map" style="z-index: 99">
            <div class="card" id="test-body">
                <canvas id="mouse-overlay"
                        style="width: 100%; position: absolute; top: 0; bottom: 0; z-index: 100"></canvas>
                <div class="card-header">
                    @yield("card-header")
                </div>
                <div>@yield("description")</div>
                @yield("card-body")
                <div class="card-footer">
                    @yield("card-footer")
                </div>
            </div>
        </div>
    </div>

    <div style="position: fixed; bottom: 0; left: 0; height: 60px; width: 100%; z-index: 200" class="card">
        <div class="card-body">
            <i id="play-button" style="font-size: 2em; display: none;" onclick="play()" class="fas fa-play"></i>
            <i id="pause-button" style="font-size: 2em; display: inline;" onclick="pause()" class="fas fa-pause"></i>
            <div style="padding-left: 15px; display: inline">
                <input style="display: inline; width: calc(100% - 58px); position: relative; top: -5px;"
                       type="range" id="scrobber">
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script src="{{ asset('js/heatmap.min.js') }}"></script>
    <script src="{{asset("js/mousePlayback.js")}}"></script>
@endpush