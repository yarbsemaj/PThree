@extends('layouts.card')

@section("title","Add tests to ".$testSeries->name)
@section('card-body')
    <div class="row">
        <div class="col-6">
            <h1>Test in this series</h1>
            <form id="test-form" action="{{route("test-series.setup-test-save",["id"=>$testSeries->id])}}"
                  method="post">
                {{csrf_field()}}
                <ul id="sortable1" class="connectedSortable list-group rounded">
                    @foreach($currentTests as $currentTest)
                        <li class="list-group-item list-group-item-{{$currentTest->testable->colourClass}}">
                            {{$currentTest->name}}
                            <input type="hidden" name="name[]" value="{{$currentTest->id}}">
                        </li>
                    @endforeach
                </ul>
            </form>
        </div>
        <div class="col-6">
            <h1>Test not yet used</h1>
            <ul id="sortable2" class="connectedSortable list-group rounded">
                @foreach($unusedTests as $unusedTest)
                    <li class="list-group-item list-group-item-{{$unusedTest->testable->colourClass}}">
                        {{$unusedTest->name}}
                        <input type="hidden" name="name[]" value="{{$unusedTest->id}}">
                    </li>

                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section("card-footer")
    <button onclick="$('#test-form').submit()" class="btn btn-outline-primary float-right">Save <i
                class="far fa-save"></i></button>
@endsection

@push("styles")
    <style>
        .connectedSortable {
            min-height: 20px;
            background-color: var(--gray);
        }
    </style>
@endpush

@push("scripts")
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function () {
            $("#sortable1, #sortable2").sortable({
                connectWith: ".connectedSortable"
            }).disableSelection();
        });
    </script>
@endpush