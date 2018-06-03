$(document).on('click', '#main-navbar-brand', function(event){
    event.preventDefault();
    var body = $("html, body");
    body.stop().animate(
        {scrollTop: 0}, 
        666
    );
});