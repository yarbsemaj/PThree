@extends ("layouts.app")
@section('content')
    <div class="container" style="max-width:1500px">
        <div class="card">
            <div class="card-header">
                @yield("card-header")
            </div>
            <div class="row no-gutters">
                <div class="col-2" style="background-color: var(--light);">
                    <div class="container">
                        <form style="padding-top: 10px" action="" method="get">
                        <h2>Filters</h2>
                        <div class="form-group">
                            <label>Route Into Role</label>
                            {{ Form::select("routeIntoRole[]", $routeIntroRole,request()->routeIntoRole,['multiple'=>true, "class"=>"choosen"]) }}
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            {{ Form::select("country[]",$country,request()->country,['multiple'=>true, "class"=>"choosen"]) }}
                        </div>
                        <div class="form-group">
                            <label>Police Force</label>
                            {{ Form::select("policeForce[]",$policeForce,request()->policeForce,['multiple'=>true, "class"=>"choosen"]) }}
                        </div>
                        <div class="form-group">
                            <label>Year in Roles</label>
                            <div class="input-group mb-3">
                                {{ Form::select("minYearsInRole",$yearInRole,request()->minYearsInRole,
                                ["class"=>"custom-select", "placeholder"=>"All"]) }}
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon1">
                                        {{"<"}}x<
                                    </span>
                                </div>
                                {{ Form::select("maxYearsInRole",$yearInRole,request()->maxYearsInRole,
                                ["class"=>"custom-select", "placeholder"=>"All"]) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Length of training</label>
                            <div class="input-group mb-3" id="lot">
                                {{ Form::select("minTraining",$training,request()->minTraining,
                                ["class"=>"custom-select", "placeholder"=>"All"]) }}
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon1">
                                        {{"<"}}x<
                                    </span>
                                </div>
                                {{ Form::select("maxTraining",$training,request()->maxTraining,
                                ["class"=>"custom-select", "placeholder"=>"All"]) }}
                            </div>
                        </div>
                        @yield("additional-filters")
                        <div class="form-group">
                            <label>Test Series</label>
                            {{ Form::select("testSeries[]",$testSeries,request()->testSeries,['multiple'=>true, "class"=>"choosen"]) }}
                        </div>
                        <div class="form-group">
                            <label>Test Participant</label>
                            {{ Form::select("testParticipant[]",$testParticipant,request()->testParticipant,['multiple'=>true, "class"=>"choosen"]) }}
                        </div>
                        <div class="text-center">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-outline-primary">Filter <i
                                            class="fas fa-filter"></i></button>
                                <button type="button" class="btn btn-outline-danger"
                                        onclick="window.location.href =location.pathname;">
                                    Clear<i class="fas fa-broom"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                        @hassection("tips")
                            <br>
                            <h2>Tips</h2>
                            @yield("tips")
                        @endif
                    </div>
                </div>
                <div class="col-10">
                    @yield("card-body")
                </div>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.choosen').select2({
                placeholder: 'All',
                width: '100%',
                allowClear: true
            });
        });
    </script>
@endpush

@push("styles")
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
@endpush()