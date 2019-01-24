@extends ("layouts.list")

@section("list")
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Test Series</th>
            <th>Police Force</th>
            <th>Country</th>
            <th>Route Into Role</th>
            <th>Options</th>
        </tr>
        </thead>
        @foreach($data as $datum)
            <tr>
                <td>
                    <a href="{{route("test-participant.show",["id"=>$datum->id])}}">
                        {{$datum->token}}
                    </a>
                </td>
                <td>
                    {{$datum->testSeries->name}}
                </td>
                <td>
                    {{$datum->country->name}}
                </td>
                <td>
                    {{$datum->policeForce->name}}
                </td>
                <td>
                    {{$datum->routeIntoRole->name}}
                </td>
                <td>
                    {{Form::open(['url' => route("test-participant.destroy",["id"=>$datum->id])])}}
                    @method('DELETE')
                    <button type="submit"
                            class="btn btn-danger"
                            style="display: block; margin: 0 auto;">
                        <i class="far fa-trash-alt"></i>
                    </button>
                    {{Form::close()}}
                </td>
            </tr>
        @endforeach
    </table>
@endsection