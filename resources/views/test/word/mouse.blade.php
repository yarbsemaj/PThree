@extends ("layouts.test.mouse-display")

@section("card-header","Please answer the following question")
@section('card-body')
    <h1>{{$test->name}}</h1>
    @markdown($test->description)
    <form id="answerForm">
        <div class="funkyradio">
            @foreach($test->wordTestWords as $orderTestWord)
                <div class="funkyradio-success">
                    <input class="single-checkbox" type="checkbox" name="words[]" value="{{$loop->index}}"
                           id="checkbox{{$loop->index}}"/>
                    <label for="checkbox{{$loop->index}}">{{$orderTestWord->name}}</label>
                </div>
            @endforeach
        </div>
    </form>
@endsection

@section("card-footer")
    <a id="submit" class="btn btn-outline-success btn-lg float-right">Save and Continue <i
                class="far fa-hand-point-right"></i></a>
@endsection

@push("styles")
    <link href="{{asset("css/checbox.css")}}" rel="stylesheet"/>
@endpush()
