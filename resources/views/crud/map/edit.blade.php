@extends('layouts.form.root')

@section("title", "Update ".$map->name)

@section("form")
    @method('PUT')
    @include("crud.map.form")
@endsection
