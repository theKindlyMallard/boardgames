$(document).on('click', '#main-navbar-brand', function(event){
    event.preventDefault();
    var body = $("html, body");
    body.stop().animate(
        {scrollTop: 0}, 
        666
    );
});

function startTime() {
    document.getElementById('startClock').style.display = 'none';
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('clock').innerHTML =
    h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}

function checkTime(i) {
    if (i < 10) {i = "0" + i};
    return i;
}
