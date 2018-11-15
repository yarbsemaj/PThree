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
       class="btn btn-block btn-primary">{{_t("Add $name")}} <i class="fas fa-plus-circle"></i></a>
    <br>
@endif

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>{{_t($name)}}
            <a tabindex="0" role="button" data-toggle="popover" data-trigger="focus"
               title="{{$name}} List"
               data-content="{{_t("Click a $name to edit its details.")}}">[?]</a>
        </th>
        @foreach(array_slice($fields,1) as $field)
            <th>{{_t(ucwords(str_replace('_', ' ', $field)))}}</th>
        @endforeach
        <th>{{_t("Image")}}</th>
        @if($delete)
            <th>{{_t("Delete")." $name"}}</th>
        @endif
    </tr>
    </thead>
    @foreach($data as $datum)
        <tr>
            <td>
                @if(hasUsageRight($datum))
                    <a href="{{route($route.".edit",array_merge(["id"=>$datum->id],$params))}}">
                        @endif
                        {{_t($datum[$fields[0]])}}
                        @if(hasUsageRight($datum))
                    </a>
                @endif
            </td>
            @foreach(array_slice($fields,1) as $field)
                <td>{{_t($datum[$field])}}</td>
            @endforeach
            <td><img src="{{route($imgRoute,["id"=>$datum->id])}}" class="img-responsive img-rounded"></td>
            @if($delete)
                <td>
                    @if(hasUsageRight($datum))
                        {{Form::open(['url' => route("$route.delete",$params)])}}
                        {{Form::hidden("id",$datum->id)}}
                        <button type="submit" class="btn btn-danger" style="display: block; margin: 0 auto;">
                            {{_t("Remove")}} <i class="far fa-trash-alt"></i>
                        </button>
                        {{Form::close()}}
                    @endif
                </td>
            @endif
        </tr>
    @endforeach
</table>