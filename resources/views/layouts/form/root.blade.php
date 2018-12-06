@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
            @yield("form")
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script src="{{asset("js/chosen.jquery.min.js")}}"></script>
    <link href="{{asset("css/chosen.css")}}" rel="stylesheet">
    <script>
        $(function () {
            $(".choosen").chosen();
        })
    </script>
@endpush
