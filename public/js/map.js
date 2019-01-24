var canvas;
var ctx;

var img = new Image();

var pin = [];

var pinType = 0;

var closnes = 0.02;
var pins = [];


$(function(){
    canvas = document.getElementById('map');
    ctx = canvas.getContext('2d');
    img.src = $("#map").data("img-src");

    img.onload = setTimeout(setupCanvas, 1500);

    loadPins();
});

function setupCanvas() {
    $("#loading").hide();
    drawScreen();
    $(window).resize(function () {
        drawScreen()
    });

    $("#map").click(function(e){
        pinsRemoved = false;
        cursorPos = getCursorPosition(canvas,e);
        pins.forEach(function(element, index){
            if(Math.abs(cursorPos.x-element.x)<closnes&&Math.abs(cursorPos.y-element.y)<closnes){
                pins.splice(index,1);
                pinsRemoved = true;
            }
        });
        if(!pinsRemoved){
            pins.push(getCursorPosition(canvas,e));
        }
        drawScreen();
    });

    $(".pinType").click(function (e) {
        $(".pinType").removeClass("active");
        target = $(e.currentTarget);
        pinType = target.data("pin-type");
        target.addClass("active");
    });

    $("#submit").click(function (e) {
        axios.post('', {pins})
            .then(function (response) {
                window.onbeforeunload = null;
                window.location.href = '';
            })
    });
}


function getCursorPosition(canvas, event) {
    var rect = canvas.getBoundingClientRect();
    var x = event.clientX - rect.left;
    var y = event.clientY - rect.top;
    return {"x": x / canvas.width, "y": y / canvas.height, "type": pinType}
}


function loadPins() {
    for (var i = 0; i < 9; i++) {
        pin[i] = new Image();
        pin[i].src = "/img/pins/" + i + ".png";
    }
}

function drawScreen(){
    canvas.width = $("#map").parent().width();
    canvas.height = canvas.width/img.width*img.height;

    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.drawImage(img, 0, 0,canvas.width,canvas.height);
    drawPins();
}


function drawPins(){
    pins.forEach(function(element){
        ctx.drawImage(pin[element.type], element.x * canvas.width - 17.5, element.y * canvas.height - 17.5, 40, 40);
    });
}