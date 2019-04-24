var canvas;
var ctx;

var img = new Image();

var pin = [];

var dataToDisplay = [];
var originalData = [];

var normalisedArray = [];

var closnes = 0.02;

var heatmap;

$(function () {
    $.getJSON(resultURL, function (data) {
        console.log(data);
        dataToDisplay = data;
        originalData = data;
    });

    canvas = document.getElementById('map');
    ctx = canvas.getContext('2d');
    img.src = $("#map").data("img-src");

    img.onload = setTimeout(setupCanvas, 2000);

    loadPins();
});

function setupCanvas() {
    $("#loading").hide();
    drawScreen();
    heatmap = h337.create({
        container: document.getElementById("heatmap")
    });
    drawHeatMap();
    setupTable();
    $(window).resize(function () {
        drawScreen();
        drawHeatMap();
    });
}

function setupTable() {
    google.charts.load('current', {'packages': ['table']});
    google.charts.setOnLoadCallback(drawTable);

    function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Pin #');
        data.addColumn('string', 'Participant');
        data.addColumn('string', 'Test Series');
        data.addColumn('string', 'Pin type');
        data.addColumn('string', 'Reason');
        originalData.forEach(function (element) {
            data.addRow([element.id,
                element.test_result.test_participant.token,
                element.test_result.test_participant.test_series.name,
                element.map_pin.name,
                element.reason]);
        });

        var table = new google.visualization.Table(document.getElementById('table_div'));

        table.draw(data, {page: "eanable", pageSize: 15, width: '100%', height: '100%'});

        google.visualization.events.addListener(table, 'select', selectHandler);

        function selectHandler() {
            dataToDisplay = [];
            selections = table.getSelection();
            if (selections.length != 0) {
                selections.forEach(function (element) {
                    dataToDisplay.push(originalData[element.row])
                });
            } else {
                dataToDisplay = originalData;
            }
            drawScreen();
            drawHeatMap();
        }

        $(document).keyup(function (e) {
            if (e.key === "Escape") {
                table.setSelection();
                dataToDisplay = originalData;
                drawScreen();
                drawHeatMap();
            }
        });

        $("#heatmap").click(function (e) {
            clickPosition = getCursorPosition(canvas, e);
            dataToDisplay.forEach(function (element) {
                if (Math.abs(clickPosition.x - element.x) < closnes && Math.abs(clickPosition.y - element.y) < closnes) {
                    index = originalData.indexOf(element);
                    table.setSelection([{row: index}]);
                    var page = (Math.floor(index / 15) + 1).toString();
                    $(".google-visualization-table-page-number:contains('" + page + "')")[0].click()
                }
            });
            drawScreen();
            drawHeatMap();
        });
    }
}

function getCursorPosition(canvas, event) {
    var rect = canvas.getBoundingClientRect();
    var x = event.clientX - rect.left;
    var y = event.clientY - rect.top;
    return {"x": x / canvas.width, "y": y / canvas.height}
}

function loadPins() {
    for (var i = 0; i < 9; i++) {
        pin[i] = new Image();
        pin[i].src = "/img/pins/" + i + ".png";
    }
}

function drawScreen() {
    canvas.width = $("#map").parent().width();
    canvas.height = canvas.width / img.width * img.height;

    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
    drawPins();
}

function drawHeatMap() {
    normalisedArray = [];
    dataToDisplay.forEach(function (element) {
        normalisedArray.push({
            x: Math.round(element.x * canvas.width),
            y: Math.round(element.y * canvas.height),
            value: 5
        })
    });

    heatmap.repaint();

    heatmap.setData({
        max: 10,
        data: normalisedArray,
    });
}

function drawPins() {
    dataToDisplay.forEach(function (element) {
        ctx.drawImage(pin[element.pinIndex], element.x * canvas.width - 17.5, element.y * canvas.height - 17.5, 40, 40);
    });
}