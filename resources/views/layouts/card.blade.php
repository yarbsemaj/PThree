@extends("layouts.app")

@section("content")
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">@yield("title")</div>
                    <div class="card-body">
                        @yield("card-body")
                    </div>
                    @hasSection("card-footer")
                        <div class="card-footer">
                            @yield("card-footer")
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection()