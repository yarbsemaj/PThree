@extends ("layouts.test.mouse-display")

@section("card-header","Please answer the following question")
@section('card-body')
    <h1>{{$test->name}}</h1>
    @markdown($test->description)
    <form id="answerForm">
        <input type="text" name="answer" required class="form-control" placeholder="Answer">
    </form>
@endsection

@section("card-footer")
    <a id="submit" class="btn btn-outline-success btn-lg float-right">Save and Continue <i
                class="far fa-hand-point-right"></i></a>
@endsection
