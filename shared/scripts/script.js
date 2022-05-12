$(function () {
    $('.slide-depoimentos').slick({
        arrows: false,
        dots: true,
        infinite: true,
        speed: 600,
        slidesToShow: 1,
        autoplay: true,
        autoplaySpeed: 2000
    });

    /** COOKIE **/
    $(".btn-cookie").on("click", function () {
        setCookie("lgpd","true", 1);
        $("#cookie").fadeOut(500);
    });

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
});