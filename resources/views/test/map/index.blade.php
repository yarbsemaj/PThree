@extends ("layouts.test")
@section('card-body')
        <canvas id="map"></canvas>
@endsection

@section("card-footer")
    <a class="btn btn-outline-success btn-lg float-right">Next <i class="far fa-hand-point-right"></i></a>
@endsection
@push("scripts")
    <script src="{{ asset('js/map.js') }}"></script>
@endpush()