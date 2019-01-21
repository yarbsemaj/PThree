@extends('layouts.form.root')

@section("title", "Update ".$data->name)

@section("form")
    @method('PUT')
    @include("crud.order.form")
@endsection
