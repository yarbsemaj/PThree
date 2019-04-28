@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card-deck">
            <div class="card">
                <div class="card-header">Test Types</div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item"><a href="{{route("map.index")}}">Map Test</a></li>
                        <li class="list-group-item"><a href="{{route("free-text.index")}}">Free Text Question</a></li>
                        <li class="list-group-item"><a href="{{route("order.index")}}">Order Test</a></li>
                        <li class="list-group-item"><a href="{{route("word.index")}}">Word Selection Test</a></li>
                        <li class="list-group-item"><a href="{{route("image-select.index")}}">Image Selection Test</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Test Series</div>
                <div class="card-body">
                    <img class="img-fluid" src="{{asset('img/link.png')}}">
                    <a class="btn btn-lg btn-block btn-success" href="{{route("test-series.index")}}">View Test
                        Series</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Responses</div>
                <div class="card-body">
                    <img class="img-fluid" src="{{asset('img/srug.png')}}">
                    <a class="btn btn-lg btn-block btn-success" href="{{route("test-participant.index")}}">View Test
                        Participants</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
