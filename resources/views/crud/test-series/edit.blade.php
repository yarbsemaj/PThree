@extends('layouts.form.root')

@section("title", "Update ".$testseries->name)

@section("form")
    @method('PUT')
    @include("crud.test-series.form")
@endsection
