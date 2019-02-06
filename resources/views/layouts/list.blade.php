@extends('layouts.app')

@section("title", $name)

@section("content")
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(array("method"=>"get")) }}
                        <div class="row">
                            <div class="input-group mb-3">
                                <input type="text" value="{{$search}}" class="form-control" name="search"
                                       placeholder="Search for...">
                                <div class="input-group-append">
                                    <input type="submit" class="btn btn-outline-secondary" value=Search>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}

                        @yield("flavor-text")

                        <a class="btn btn-lg btn-block btn-success"
                           href="{{route(Route::currentRouteName())."/create"}}">Add</a>
                        <br>
                        @if(!$data->isEmpty())
                            @yield("list")
                        @else
                            <div class="text-center">
                                <H3> We could not not find any {{$name}}
                                </h3>
                                <img class="img-responsive" style="margin-bottom: -20px"
                                     src="{{asset("img/srug.png")}}">
                            </div>
                        @endif
                        {!!$data->links()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
