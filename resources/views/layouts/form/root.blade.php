@extends('layouts.card')

@section('card-body')
    {!! Form::open(['url' => $url]) !!}
    @yield("form")
    <br>
    <input class="btn btn-primary btn-block" type="submit">
    {!! Form::close() !!}
    <script>
        $(function () {
            var simplemde = new SimpleMDE({
                forceSync: true,
                showIcons: ["table", "heading-smaller", "horizontal-rule", "heading-bigger", "strikethrough"],
                hideIcons: ["image", "heading"]
            });
        });
    </script>
@endsection

@push("scripts")
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="{{asset("js/chosen.jquery.min.js")}}"></script>
    <script>
        $(function () {
            $(".choosen").chosen();
        })
    </script>
@endpush


@push("styles")
    <style>
        .editor-toolbar.fullscreen {
            z-index: 1001;
        }
    </style>
    <link href="{{asset("css/chosen.css")}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endpush()

