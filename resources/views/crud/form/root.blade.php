@extends('layouts.panel_sidebar')

@section("title", $title)

@push("scripts")
    <script src="{{asset("js/chosen.jquery.min.js")}}"></script>
    <link href="{{asset("css/chosen.css")}}" rel="stylesheet">
    <script>
        $(function () {
            $(".choosen").chosen();
        })
    </script>
@endpush

@section("sidebar")
    <div class="panel">
        <div class="panel-body">
            @include("crud.form.relationship_buttons_redirect")
        </div>
    </div>
@endsection
