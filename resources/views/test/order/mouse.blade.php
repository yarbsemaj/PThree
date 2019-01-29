@extends ("layouts.test.mouse-display")

@section("card-header","Please answer the following question")
@section('card-body')
    <h1>{{$test->name}}</h1>
    @markdown($test->description)
    Please place the following words in order
    <form id="answerForm">
        <ul class="list-group rounded sortable">
            @foreach($test->orderTestWords as $orderTestWord)
                <li class="list-group-item">
                    {{$orderTestWord->name}}
                    <input type="hidden" name="words[]" value="{{$loop->index}}">
                </li>
            @endforeach
        </ul>
    </form>
@endsection

@section("card-footer")
    <a id="submit" class="btn btn-outline-success btn-lg float-right">Save and Continue <i
                class="far fa-hand-point-right"></i></a>
@endsection

@push("styles")
    <style>
        .sortable {
            min-height: 20px;
            background-color: var(--gray);
        }
    </style>
@endpush
