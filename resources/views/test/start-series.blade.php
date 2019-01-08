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

    @markdown($testSeries->description)
    Before the survey begins please provide some basic information about your traning, past experiences and force your part of

    {!! Form::open(['url' => route("test.store",["url_token"=>$testSeries->url_token])]) !!}

    <div class="card">
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
                <option>I have received no formal training</option>
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
    </div>
    <div class="input-group">
        <button class="btn-outline-success btn-block btn" type="submit">Begin <i class="fas fa-arrow-right"></i>
        </button>
        {!! Form::close() !!}

    </div>

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
@endsection


@push("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

@endpush


@push("styles")
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
@endpush()