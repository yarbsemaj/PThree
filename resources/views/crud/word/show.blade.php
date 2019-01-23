@extends('layouts.test.show')

@section("title",$test->name)

@section("additional-info")
    <ul class="list-group">
        <ul class="list-group">
            @foreach($test->wordTestWords as $wordTestWord)
                <li class="list-group-item">
                    {{$wordTestWord->name}}
                </li>
            @endforeach
        </ul>
    </ul>
    <br>
@endsection