@extends("layouts.card")

@section("title", "Saving and continuing")

@section("card-body")
    <div class="text-center">
        <img class="img-fluid" width="45%" src="{{asset("img/ballot-box.png")}}">
        <h5>All your responses are kept anonymous and cannot be traced back to you.</h5>
        <p><b>You can use the link below to jum back in where you left off at any time.</b></p>
        <h5><b>{{route("test.display",["participant_id"=>$testParticipant->token])}}</b></h5>
    </div>

    <a href="{{route("test.display",["participant_id"=>$testParticipant->token])}}"
       class="btn btn-lg btn-block btn-outline-primary">Continue</a>
@endsection
