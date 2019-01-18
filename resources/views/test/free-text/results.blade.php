@extends ("layouts.results")

@section("card-header",$test->test->name)
@section('card-body')
    <div id="pointCloud" style="height: 500px; width: 100%">
    </div>

    <div id="table_div">
    </div>
@endsection

@section("additional-filters")
@endsection


@push("scripts")
    <script src="{{asset("js/jqcloud.js")}}"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        var resultURL = "{{route("free-text.results.data",["id"=>$test->test->id])}}?{!!http_build_query(request()->all())!!}";

        var answers;

        $(function () {
            $.getJSON(resultURL, function (data) {
                console.log(data);
                answers = data.answers;
                google.charts.load('current', {'packages': ['table']});
                google.charts.setOnLoadCallback(drawTable);


                function drawTable() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Participant');
                    data.addColumn('string', 'Answer');
                    data.addColumn('string', 'Test Series');
                    data.addColumn('string', 'Police Force');
                    data.addColumn('string', 'Route Into Role');
                    data.addColumn('number', 'Years in role');
                    data.addColumn('number', 'Training Complected');
                    data.addRows(answers);

                    var table = new google.visualization.Table(document.getElementById('table_div'));

                    table.draw(data, {width: '100%', height: '100%'});
                }


                setTimeout(function () {
                    $('#pointCloud').jQCloud(data.tagCloud);
                }, 100);
            });
        });
    </script>
@endpush()

@push("styles")
    <link href="{{asset("css/jqcloud.css")}}" rel="stylesheet"/>
@endpush()