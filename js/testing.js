(function($) 
{

    $(function() {

        $("a").each(function(i, e)
        {
            var href = $(this).attr("href");
            if (href.search("javascript:") < 0)
            {
                if (href.split('?').length > 1)
                    href += '&mobile';
                else
                    href += '?mobile';
            }

            $(this).attr('href', href);
        });

        $("#image-hider").click(function()
        {
            $("#panel img").toggle();
            $("#panel").find(".vidint, imgRight, imgLeft").toggle();
        })

    });

})(jQuery);