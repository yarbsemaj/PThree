var canvas;
var ctx;

var img = new Image();
var pin = new Image();

var closnes = 0.01;
var pins = [];


pin.src="/img/pin.png";

$(function(){
    canvas = document.getElementById('map');
    ctx = canvas.getContext('2d');

    $(window).resize(function () {
        drawScreen()
    });
    img.src = "https://www.insidermedia.com/uploads/news/stanneylands-road-wilmslow-174-homes-barratt-david-wilson-homes-north-west-planning-layout-resized.jpg"
    img.onload = function() {drawScreen()};

    $("#map").click(function(e){
        pinsRemoved = false;
        cursorPos = getCursorPosition(canvas,e);
        pins.forEach(function(element,index){
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

    function drawPins(){
        pins.forEach(function(element){
            ctx.drawImage(pin, element.x-15, element.y-15,30,30);
        });
    }
});



function getCursorPosition(canvas, event) {
    var rect = canvas.getBoundingClientRect();
    var x = event.clientX - rect.left;
    var y = event.clientY - rect.top;
    return {"x":x/canvas.width,"y":y/canvas.height}
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
        ctx.drawImage(pin, element.x*canvas.width-17.5, element.y*canvas.height-17.5,35,35);
    });
}