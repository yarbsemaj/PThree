@extends ("layouts.app")
@section('content')
    <div class="container">
    <div class="card">
        <div class="card-header">
            @yield("card-header")
        </div>
        <div class="card-body">
            <p class="card-text">@yield("description")</p>
            @yield("card-body")
        </div>
        <div class="card-footer">
            @yield("card-footer")
        </div>
    </div>
    </div>
@endsection