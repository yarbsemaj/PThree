@php if(isset($redirect))
$params = ["redirect"=>$redirect];
else
$params =[];
if (!isset($delete))
$delete = true;
@endphp

@if(isset($search))
    {{ Form::open(array("method"=>"get")) }}
    <div class="row">
        <div class="input-group">
            <input type="text" value="{{$search}}" class="form-control" name="search"
                   placeholder="{{_t("Search for")}}...">
            <span class="input-group-btn">
        <input type="submit" class="btn btn-default" value="{{_t("Search")}}">
      </span>
        </div>
    </div>
    {{ Form::close() }}
@endif

@if($add)
    <a href="{{route($route.".add",$params)}}"
       class="btn btn-block btn-primary">{{"Add $name"}} <i class="fas fa-plus-circle"></i></a>
    <br>
@endif


@if(isset($favourText))
    {{$favourText}}
@endif()

@if((isset($multiSelect) && count($multiSelect)) || (isset($singleSelect)&& count($singleSelect)))
    <div class="panel panel-info filter-bar">
        <div class="panel-heading expand collapsed" data-toggle="collapse"
             data-target="#{{$expGroupGroup = str_random()}}">
            <h4 class="panel-title" style="display: inline">
                Filter results
            </h4>
        </div>
        <div id="{{$expGroupGroup}}" class="panel-collapse collapse">
            <div class="panel-body">
                @if(isset($multiSelect))
                    {{Form::open(["method"=>"GET", "id"=>"filter-form"])}}
                    @foreach($multiSelect as $item => $values)
                        {{camelCaseToHuman($item)}}
                        <div class="input-group">
                            {{ Form::select("filter[$item][data][]", $values->pluck("name","id"),null,['multiple'=>true, "class"=>"form-control choosen"]) }}
                            <span class="input-group-addon">
                                No {{camelCaseToHuman($item)}}
                                {{ Form::checkbox("filter[$item][null]",true,null) }}
                            </span>
                        </div>
                    @endforeach
                @endif
                @if(isset($singleSelect))

                    @foreach($singleSelect as $item => $values)
                            {{camelCaseToHuman($item)}}
                            <div class="input-group">
                                {{ Form::select("filter[$item][data][]", $values->pluck("name","id"),null,['multiple'=>true, "class"=>"form-control choosen"]) }}
                                <span class="input-group-addon">
                                No {{camelCaseToHuman($item)}}
                                {{ Form::checkbox("filter[$item][null]",true,null) }}
                            </span>
                            </div>
                    @endforeach
                @endif
                {{Form::submit("Filter",["class"=>"btn btn-primary center-block", "style"=>"margin-top:5px", "onclick"=>"console.log($('#filter-form').serializeArray() )"])}}
                {{Form::close()}}
            </div>
        </div>
    </div>
@endif

@if(!$data->isEmpty())
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>{{_t($name)}}</th>
            @foreach(array_slice($fields,1) as $field)
                <th>{{_t(ucwords(str_replace('_', ' ', $field)))}}</th>
            @endforeach
            @if($delete)
                <th>{{_t(isset($deletePrams['name'])?$deletePrams['name']:"Delete")}}</th>
            @endif
        </tr>
        </thead>
        @foreach($data as $datum)
            <tr>
                <td>
                    @if(hasUsageRight($datum)&&(!isset($link)||$link))
                        <a href="{{route($route.".".(isset($routeSuffix)?$routeSuffix:"edit"),array_merge(["id"=>$datum->id],$params))}}">
                            @endif
                            {{_t($datum[$fields[0]])}}
                            @if(hasUsageRight($datum)&&(!isset($link)||$link))
                        </a>
                    @endif
                </td>
                @foreach(array_slice($fields,1) as $field)
                    <td>{{preg_match("#[0-9]{2}\/[0-9]{2}\/[0-9]{4}#",$datum[$field])?$datum[$field]:_t($datum[$field])}}</td>
                @endforeach
                @if($delete)
                    <td>
                        @if(hasUsageRight($datum))
                            {{Form::open(['url' => route($route.".".(isset($deletePrams["route"])?$deletePrams["route"]:"delete"),$params)])}}
                            {{Form::hidden("id",$datum->id)}}
                            <button type="submit"
                                    class="btn btn-{{isset($deletePrams['btnType'])?$deletePrams['btnType']:"danger"}}"
                                    style="display: block; margin: 0 auto;">
                                {{_t(isset($deletePrams['name'])?$deletePrams['name']:"Delete")}}
                                <i class="{{isset($deletePrams['icon'])?$deletePrams['icon']:"far fa-trash-alt"}}"></i>
                            </button>
                            {{Form::close()}}
                        @endif
                    </td>
                @endif
            </tr>
        @endforeach
    </table>
@else
    <div class="col-md-9">
        <h3>{!!_t("We couldn't find any")." ".wrapInTag(_t($name),"i","'")."."!!}
            @if(isset(request()->filter))
        {!!_t("If you are using any filters you may wish to remove some of them and try again.")!!}
                @endif
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
