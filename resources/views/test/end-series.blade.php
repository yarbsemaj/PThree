@extends("layouts.card")

@section("title", $testSeries->name)

@section("content")
    <canvas style="position: absolute; top: 0; left: 0; z-index: -1000" id="confettie"></canvas>
    @parent
@endsection

@section("card-body")
    <div class="text-center">
        <h1>Congratulation!</h1>
        <h3>Question complete!</h3>
        <h5>All your responses have been recorded anomalously.</h5>
        <img class="img-fluid" src="{{asset("img/party-popper.png")}}">
        <br>
        <br>
        <div class="text-secondary">
            If you wish to remove yourself from this research, you can contact {{$testSeries->user->name}} via email at
            <a href="mailto:{{$testSeries->user->email}}">{{$testSeries->user->email}}</a> and quote your unique
            reference
            code <b>{{$testParticipant->token}}</b> and they will happy to permanently erase all your results
        </div>
        @endsection

        @push("scripts")
            <script src="{{asset("js/confetti.js")}}"></script>

            <script>
                $(function () {
                    var confettiSettings = {target: 'confettie'};
                    var confetti = new ConfettiGenerator(confettiSettings);
                    confetti.render();
                });</script>
    @endpush