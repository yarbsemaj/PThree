@extends('layouts.test.show')

@section("title",$test->name)

@section("additional-info")
    <div class="card-deck">
        @foreach($test->imageSelectImages as $image)
            <div class="card">
                <div class="card-body">
                    <img class="img-fluid" src="{{route("image-select.image",["file"=>$image->image])}}">
                </div>
            </div>
        @endforeach
    </div>
    <br>
@endsection