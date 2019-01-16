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
                    <a href="{{route("map.show",["id"=>$datum->id])}}">
                        {{$datum->name}}
                    </a>
                </td>
                <td>
                    <img class="img-fluid" src="{{route("map.image",["id"=>$datum->testable->map])}}">
                </td>
                <td class="text-center">
                    <a class="btn btn-outline-primary" href="{{route("map.results",["id"=>$datum->id])}}">
                        Results
                        <i class="fas fa-poll"></i></a>
                    <a class="btn btn-outline-secondary" href="{{route("map.preview",["id"=>$datum->id])}}">
                        Preview
                        <i class="fas fa-search"></i>
                    </a>
                    <a class="btn btn-info" href="{{route("map.edit",["id"=>$datum->id])}}">
                        Edit <i class="fas fa-pencil-alt"></i></a>
                    {{Form::open(['url' => route("map.destroy",["id"=>$datum->id])])}}
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-danger"
                                style="display: block; margin: 0 auto;">
                            Delete
                            <i class="far fa-trash-alt"></i>
                        </button>
                    {{Form::close()}}
                </td>
            </tr>
        @endforeach
    </table>
@endsection