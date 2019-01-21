@extends ("layouts.results")

@section("card-header",$test->test->name)
@section('card-body')
    <div id="charDiv" style="height: 700px; width: 100%">
    </div>
@endsection

@section("additional-filters")
@endsection


@push("scripts")
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        var resultURL = "{{route("order.results.data",["id"=>$test->test->id])}}?{!!http_build_query(request()->all())!!}";

        var answers;

        $(function () {
            $.getJSON(resultURL, function (data) {
                console.log(data);
                answers = data.answers;

                google.charts.load('current', {packages: ['corechart', 'bar']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var table = google.visualization.arrayToDataTable(data);

                    var options = {
                        title: "Number who expressed prefrence for each option",
                        chartArea: {width: '65%'},
                        orientation: "horizontal",
                        vAxis: {
                            format: '0',
                            minorGridlines: {"count": 0}
                        },
                        hAxis: {
                            title: 'Preference',
                            minValue: 0,
                        },
                    };
                    var chart = new google.visualization.BarChart(document.getElementById('charDiv'));
                    chart.draw(table, options);
                }
            });
        });
    </script>
@endpush()

@push("styles")
    <link href="{{asset("css/jqcloud.css")}}" rel="stylesheet"/>
@endpush()