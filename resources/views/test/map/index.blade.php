@extends ("layouts.app")
@section('content')
    <div class="container">
                <canvas id="map"></canvas>
    </div>
@endsection

@push("scripts")
    <script src="{{ asset('js/map.js') }}"></script>
@endpush()