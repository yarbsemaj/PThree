@extends('layouts.form.root')

@section("title", "Test Series")

@section("form")
    {!! Form::open(['route' => 'test-series.store']) !!}
    <input class="form-control" type="text" value="{{$name ?? ""}}">
    <input class="btn btn-primary btn-block" type="submit">
    {!! Form::close() !!}
@endsection
