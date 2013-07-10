(function($) {

    var nav = $("#navg");
    var panel = $("#panel");

    var navTop = nav.offset().top;
    var navHeight = nav.outerHeight();

    $(window).bind("scroll", function() {
        if ($(window).scrollTop() > navTop)
        {
            nav.addClass("fixed");
            panel.css("margin-top", navHeight + "px");
        }
        else
        {
            nav.removeClass("fixed");
            panel.css("margin-top", "0");
        }
    });


})(jQuery);