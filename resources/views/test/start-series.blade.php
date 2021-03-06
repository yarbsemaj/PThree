@extends("layouts.card")

@section("title", $testSeries->name)

@section("card-body")

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h4>Before the survey begins please provide some basic information about your training, past experiences and force
        your part of.</h4>

    {!! Form::open(['url' => route("test.store",["url_token"=>$testSeries->url_token])]) !!}
    <div class="form-group">
        <h5>What country is your police force located?</h5>
        {!! Form::select('country',array_merge([""=>""],$country->pluck('name', 'name')->toArray()),null,["class"=>"chosenFreeText","required"=>"true"]); !!}
    </div>
        <div class="form-group">
            <h5>What police force are you a member of?</h5>
            {!! Form::select('policeForce',array_merge([""=>""],$policeForce->pluck('name', 'name')->toArray()),null,["class"=>"chosenFreeText","required"=>"true"]); !!}
        </div>
        <div class="form-group">
            <h5>What was your role before entering the police?</h5>
            {!! Form::select('routeIntoRole', array_merge([""=>""],$routeIntoRole->pluck('name', 'name')->toArray()),null,["class"=>"chosenFreeText","required"=>"true"]); !!}
        </div>
        <div class="form-group">
            <h5>What year did you you complete your CPTD training?</h5>
            <select class="form-control chosen" name="training">
                @for($i=0; $i<60; $i++)
                    <option value="{{date("Y")-$i}}">{{date("Y")-$i}}</option>
                @endfor
            </select>
        </div>
        <div class="form-group">
            <h5>How long have you been in your current role?</h5>
            <select class="form-control chosen" required name="yearsInRole">
                <option value="0">Less that a year</option>
                <option value="1">More than 1 year but less that 2 years</option>
                @for($i=2; $i<58; $i++)
                    <option value="{{$i}}">More than {{$i}} years but less than {{$i+1}} years</option>
                @endfor
            </select>
        </div>
    <div class="input-group justify-content-center">
        <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
        </div>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" required name="consent">
        <label class="form-check-label">
            I have read and agree to this
            <a href="{{route("test-series.consent-form",["formURL"=>$testSeries->consent_form])}}">consent form.</a>
        </label>
    </div>
    <br>
    <div class="input-group">
        <button class="btn-outline-success btn-block btn" type="submit">Begin <i class="fas fa-arrow-right"></i>
        </button>
        {!! Form::close() !!}
    </div>
@endsection

@push("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
        $(document).ready(function () {
            $('.chosen').select2({
                width: '100%'
            });

            $('.chosenFreeText').select2({
                placeholder: 'Start typing to find an option',
                tags: true,
                width: '100%'
            });
        });
    </script>
@endpush

@push("styles")
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
@endpush()