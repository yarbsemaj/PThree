@extends ("layouts.list")

@section("list")
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Options</th>
        </tr>
        </thead>
        @foreach($data as $datum)
            <tr>
                <td>
                    <a href="{{route("test-series.show",["id"=>$datum->id])}}">
                        {{$datum->name}}
                    </a>
                </td>
                <td>
                    {{route("test.index",["url_token"=>$datum->url_token])}}
                </td>
                <td>
                    {{Form::open(['url' => route("test-series.destroy",["id"=>$datum->id])])}}
                    <div class="btn-group" role="group">
                        <a class="btn btn-success" href="{{route("test-series.setup-test",["id"=>$datum->id])}}">
                            <i class="fas fa-plus"></i></a>
                        <a class="btn btn-info" href="{{route("test-series.edit",["id"=>$datum->id])}}">
                            <i class="fas fa-pencil-alt"></i></a>
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