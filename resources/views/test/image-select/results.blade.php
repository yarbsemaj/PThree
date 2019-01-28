@extends ("layouts.results")

@section("card-header",$test->test->name)
@section('card-body')
    <div id="charDiv" style="height: 700px; width: 100%">
    </div>
@endsection

@push("scripts")
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        var resultURL = "{{route("image-select.results.data",["id"=>$test->test->id])}}?{!!http_build_query(request()->all())!!}";


        $(function () {
            $.getJSON(resultURL, function (data) {
                console.log(data);

                google.charts.load('current', {packages: ['corechart', 'bar']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var dataTable = new google.visualization.DataTable();
                    dataTable.addColumn('string', 'Image Name');
                    dataTable.addColumn('number', 'Count');
                    // A column for custom tooltip content
                    dataTable.addColumn({type: 'string', role: 'tooltip', 'p': {'html': true}});

                    dataTable.addRows(data);
                    var options = {
                        title: "Number who expressed preference for each option",
                        chartArea: {width: '100%'},
                        tooltip: {isHtml: true},
                        orientation: "horizontal",
                        vAxis: {
                            format: '0',
                            minorGridlines: {"count": 0}
                        },
                        hAxis: {
                            title: 'Selection',
                            minValue: 0,
                        },
                    };
                    var chart = new google.visualization.BarChart(document.getElementById('charDiv'));
                    chart.draw(dataTable, options);
                }
            });
        });
    </script>
@endpush()

@push("styles")
    <link href="{{asset("css/jqcloud.css")}}" rel="stylesheet"/>
@endpush()