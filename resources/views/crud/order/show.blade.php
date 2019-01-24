@extends('layouts.test.show')

@section("title",$test->name)

@section("additional-info")
    <ul class="list-group">
        <ul class="list-group">
            @foreach($test->orderTestWords as $orderTestWord)
                <li class="list-group-item">
                    {{$orderTestWord->name}}
                </li>
            @endforeach
        </ul>
    </ul>
    <br>
@endsection
