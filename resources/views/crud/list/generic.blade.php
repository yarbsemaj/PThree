@extends('layouts.app')

@section("title", $name)

@section("content")
    <div class="container">
    @include("crud.list.list")
    </div>
@endsection
