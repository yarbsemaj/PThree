@extends ("layouts.app")
@section('content')
    <div class="container" style="max-width:1500px">
        <div class="card" id="test-body">
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
@endsection

@push("scripts")
    <script src="{{asset("js/mouseTracking.js")}}"></script>
@endpush