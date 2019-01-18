@extends("layouts.card")

@section("title", "Welcome")

@section("card-body")
    <div class="text-center">
        <h1>Welcome!</h1>
        <h2>{{$testSeries->name}}</h2>
        <h4>{{$testSeries->user->name}} (<a href="mailto:{{$testSeries->user->email}}">{{$testSeries->user->email}}</a>)
        </h4>
    </div>
    @markdown($testSeries->description)
    <div class="text-center">
        <h5>All your responses are kept anonymous and cannot be traced back to you.</h5>
    </div>

    <a href="{{route("test.basics",["test_token"=>$testSeries->url_token])}}"
       class="btn btn-lg btn-block btn-outline-primary">Begin</a>
@endsection
