var mousePositions = [];

var currentMousePos = {x: -1, y: -1};


$(function () {
    $(document).mousemove(function (event) {
        currentMousePos.x = event.pageX;
        currentMousePos.y = event.pageY;
    });


    $("#test-body").click(function (event) {
        addMousePositionToStack(JSON.stringify(simpleKeys(event)))
    });

    mouseLoop();
});

function mouseLoop() {
    setTimeout(function () {
        if ($('#test-body:hover').length != 0) {
            addMousePositionToStack(null)
        }
        mouseLoop();
    }, 200);
}

function getMouseX() {
    return (currentMousePos.x - $("#test-body").offset().left) / $("#test-body").width();
}

function getMouseY() {
    return (currentMousePos.y - $("#test-body").offset().top) / $("#test-body").height();
}

function getCurrentTime() {
    return (new Date()).getTime()
}

function addMousePositionToStack(event) {
    mousePositions.push({x: getMouseX(), y: getMouseY(), event: event, time_stamp: getCurrentTime()});
}

function simpleKeys(original) {
    return Object.keys(original).reduce(function (obj, key) {
        obj[key] = typeof original[key] === 'object' ? '{ ... }' : original[key];
        return obj;
    }, {});
}

function submitMouse(original) {
    axios.post(window.location.href + '/mouse', {mousePositions})
        .then(function (response) {
            window.location.href = '';
        });
}