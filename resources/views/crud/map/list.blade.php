@extends ("layouts.list")

@section("list")
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Map</th>
            <th>Option</th>
        </tr>
        </thead>
        @foreach($data as $datum)
            <tr>
                <td>
                    <a href="{{route("map.show",["id"=>$datum->testable->id])}}">
                        {{$datum->name}}
                    </a>
                </td>
                <td>
                    <img class="img-fluid" src="{{route("map.image",["id"=>$datum->testable->map])}}">
                </td>
                <td>
                    {{Form::open(['url' => route("map.destroy",["id"=>$datum->testable->id])])}}
                    <div class="btn-group" role="group">
                        <a class="btn btn-info" href="{{route("map.edit",["id"=>$datum->testable->id])}}"><i
                                    class="fas fa-pencil-alt"></i></a>
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-danger"
                                style="display: block; margin: 0 auto;">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>
                    {{Form::close()}}
                </td>
            </tr>
        @endforeach
    </table>
@endsection