@extends('layouts.card')

@section("title",$data->token)
@section('card-body')
    <div class="card">
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item"><b>Country: </b>{{$data->country->name}}</li>
                <li class="list-group-item"><b>Police Force: </b>{{$data->policeForce->name}}</li>
                <li class="list-group-item"><b>Route Into Role: </b>{{$data->routeIntoRole->name}}</li>
                <li class="list-group-item"><b>Years in the role: </b>{{$data->years_in_role}}</li>
                <li class="list-group-item"><b>Training competed: </b>{{$data->training}}</li>
            </ul>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header">Tests</div>
        <div class="card-body">

            @foreach($data->testResults->groupBy("test_id") as $id=>$test)
                <li class="list-group-item list-group-item-{{$test->first()->test->testable->colourClass}}">
                    <a href="{{route($test->first()->test->testable->routeName.".show",["id"=>$test->first()->test->id])}}">
                        {{$test->first()->test->name}}</a>
                </li>
            @endforeach
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header">Test Series</div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Test Serise ID</th>
                    <th>Name</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tr>
                    <td>
                        <a href="{{route("test-series.show",["id"=>$data->testSeries->id])}}">
                            {{$data->testSeries->url_token}}
                        </a>
                    </td>
                    <td>
                        {{$data->testSeries->name}}
                    </td>
                    <td>
                        {{$data->testSeries->updated_at}}
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection


