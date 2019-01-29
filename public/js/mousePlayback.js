var canvas;
var ctx;
var jsonObj;

var max;
var min;

var heatmap;

$(function () {
    canvas = document.getElementById('mouse-overlay');
    ctx = canvas.getContext('2d');

    $.getJSON(window.location.href + '/data.json', function (data) {
        jsonObj = data;

        if (jsonObj.length != 0) {

            max = Math.max.apply(Math, jsonObj.map(function (o) {
                return o.time_stamp;
            }));
            min = Math.min.apply(Math, jsonObj.map(function (o) {
                return o.time_stamp;
            }));

            $("#scrobber").attr("max", max);
            $("#scrobber").attr("min", min);
            $("#scrobber").attr("value", min);

            heatmap = h337.create({
                container: document.getElementById("heat-map")
            });

            drawMouseOverlay();

            pause();

            playLoop();
            $("#scrobber").change(function () {
                drawMouseOverlay();
            });


            $(window).resize(function () {
                drawMouseOverlay();
            });
        }

    });

});

function drawMouseOverlay() {
    canvas.width = $("#test-body").width();
    canvas.height = $("#test-body").height();

    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawLine();
    drawHeatMap();
}

function drawLine() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.moveTo(jsonObj[0].x * canvas.width, jsonObj[0].y * canvas.height);

    var lastElement;

    jsonObj.forEach(function (element) {
        if (element.time_stamp <= $("#scrobber").val()) {
            ctx.lineTo(element.x * canvas.width, element.y * canvas.height);
            ctx.lineWidth = 5;
            ctx.strokeStyle = "red";
            ctx.stroke();
            if (element.event != null && element.event.type == "click") {
                ctx.beginPath();
                ctx.strokeStyle = "blue";
                ctx.lineWidth = 5;
                ctx.arc(element.x * canvas.width, element.y * canvas.height, 50, 0, 2 * Math.PI);
                ctx.stroke();
            }
            ctx.beginPath();
            ctx.moveTo(element.x * canvas.width, element.y * canvas.height);

            lastElement = element;
        }
    });

    if (lastElement != null) {
        ctx.fillStyle = "green";
        ctx.arc(lastElement.x * canvas.width, lastElement.y * canvas.height, 20, 0, 2 * Math.PI);
        ctx.fill();
    }
}

function play() {
    isPlaying = true;
    $("#play-button").hide();
    $("#pause-button").show();

}

function pause() {
    isPlaying = false;
    $("#play-button").show();
    $("#pause-button").hide();
}

function playLoop() {
    setTimeout(function () {
        if (isPlaying) {
            $("#scrobber").val(function (i, oldval) {
                return parseInt(oldval, 10) + 100;
            });
            if ($("#scrobber").val() >= max) {
                pause();
            }

            drawMouseOverlay();

        }
        playLoop();
    }, 100);
}

function drawHeatMap() {

    normalisedArray = [];

    jsonObj.forEach(function (element) {
        if (element.time_stamp <= $("#scrobber").val()) {
            normalisedArray.push({
                x: Math.round(element.x * canvas.width),
                y: Math.round(element.y * canvas.height),
                value: 1
            })
        }
    });

    heatmap.repaint();

    heatmap.setData({
        max: 10,
        data: normalisedArray,
    });
}



