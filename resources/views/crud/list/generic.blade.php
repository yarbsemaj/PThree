@extends('layouts.panel')

@section("title", $name)

@section("body")
    @include("crud.list.list")
    <div class="text-center">
        {{ $data->links() }}
    </div>

    @includeWhen(isset($guidance),"layouts.help")
@endsection
