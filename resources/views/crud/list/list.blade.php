 {{ Form::open(array("method"=>"get")) }}
    <div class="row">
        <div class="input-group">
            <input type="text" value="{{$search}}" class="form-control" name="search"
                   placeholder="{{"Search for"}}...">
            <span class="input-group-btn">
        <input type="submit" class="btn btn-default" value=Search">
      </span>
        </div>
    </div>
    {{ Form::close() }}

@if(isset($favourText))
    {{$favourText}}
@endif()

 <a class="btn btn-lg btn-block btn-success" href="{{route(Route::currentRouteName())."/create"}}">Add</a>

@if(!$data->isEmpty())
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>{{$name}}</th>
            @foreach(array_slice($fields,1) as $field)
                <th>{{ucwords(str_replace('_', ' ', $field))}}</th>
            @endforeach
                <th>Delete</th>
        </tr>
        </thead>
        @foreach($data as $datum)
            <tr>
                <td>
                        <a href="{{route($route.".edit"),array_merge(["id"=>$datum->id])}}">
                            {{$datum[$fields[0]]}}
                        </a>
                </td>
                @foreach(array_slice($fields,1) as $field)
                    <td>{{preg_match("#[0-9]{2}\/[0-9]{2}\/[0-9]{4}#",$datum[$field])?$datum[$field]:$datum[$field]}}</td>
                @endforeach
                    <td>
                            {{Form::open(['url' => route($route.".".(isset($deletePrams["route"])?$deletePrams["route"]:"delete"),$params)])}}
                            {{Form::hidden("id",$datum->id)}}
                            <button type="submit"
                                    class="btn btn-{{isset($deletePrams['btnType'])?$deletePrams['btnType']:"danger"}}"
                                    style="display: block; margin: 0 auto;">
                                Delete
                                <i class="far fa-trash-alt"></i>
                            </button>
                            {{Form::close()}}
                    </td>
            </tr>
        @endforeach
    </table>
@else
    <div class="col-md-9">
       <H3> We could not not find any {{$name}}
        </h3>
    </div>
    <div class="col-md-3 hidden-xs hidden-sm">
        <img style="
    margin-top: -15px;
    margin-left: 31px;" class="img-responsive" src="{{asset("static_img/cobweb.png")}}">
    </div>
@endif

@push("scripts")
    <script src="{{asset("js/chosen.jquery.min.js")}}"></script>
    <link href="{{asset("css/chosen.css")}}" rel="stylesheet">
    <script>
        $(function () {
            $(".filter-bar").click(function () {
                setTimeout(function () {
                    $(".choosen").chosen();
                }, 10);
            });
        });

    </script>
@endpush
