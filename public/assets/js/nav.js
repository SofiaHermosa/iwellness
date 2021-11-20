var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
    var currentScrollPos = window.pageYOffset;
    console.log(currentScrollPos);
    if (currentScrollPos <= 100) {
        document.querySelector(".nav").style.top = "0";
    } else {
        if (prevScrollpos > currentScrollPos) {
            document.querySelector(".nav").style.top = "0";
        } else {
            document.querySelector(".nav").style.top = "-100px";
        }
    }

    if (currentScrollPos >= 3600) {
        $(".goTopBtn").fadeOut();
    } else {
        if (currentScrollPos >= 560) {
            $(".goTopBtn").fadeIn();
        } else {
            $(".goTopBtn").fadeOut();
        }
    }
    prevScrollpos = currentScrollPos;
}

$(".nav--link").click(function(e) {
    e.preventDefault();
    var div = $(this).attr('href');
    $('html, body').animate({
        scrollTop: $(div).offset().top
    }, 1000);
});