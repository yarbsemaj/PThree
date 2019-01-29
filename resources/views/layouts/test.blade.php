@extends ("layouts.app")
@section('content')
    <div class="container">
        <div class="col-8 mx-auto">
            <div class="card" id="test-body">
        <div class="card-header">
            @yield("card-header")
        </div>
        <div>@yield("description")</div>
        <div class="card-body">
            @yield("card-body")
        </div>
        <div class="card-footer">
            @yield("card-footer")
        </div>
    </div>
    </div>
    </div>
@endsection

@push("scripts")
    <script src="{{asset("js/mouseTracking.js")}}"></script>
@endpush