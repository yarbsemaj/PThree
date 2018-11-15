@extends("crud.form.generic")

@section("body")
    <style>
        .editor-toolbar.fullscreen {
            z-index: 1001;
        }
    </style>
    @parent
    <script>
        var simplemde = new SimpleMDE({
            forceSync: true,
            showIcons: ["table", "heading-smaller", "horizontal-rule", "heading-bigger", "strikethrough"],
            hideIcons: ["image", "heading"]
        });
    </script>
    @include("crud.form.relationship_buttons")
@endsection

@push("scripts")
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endpush

