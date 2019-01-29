@extends ("layouts.test")

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
    <a id="submit" onclick="
    axios.post('', $('#answerForm').serialize())
            .then(function (response) {
                             submitMouse();
            })" class="btn btn-outline-success btn-lg float-right">Save and Continue <i
                class="far fa-hand-point-right"></i></a>
@endsection

@push("scripts")
    <script>
        $(function () {
            var limit = {{$test->max}};
            if (limit != 0) {
                $('input.single-checkbox').on('change', function (evt) {
                    if ($('input.single-checkbox:checked').length > limit) {
                        this.checked = false;
                    }
                });
            }
        });
    </script>
@endpush()

@push("styles")
    <link href="{{asset("css/checbox.css")}}" rel="stylesheet"/>
@endpush()
