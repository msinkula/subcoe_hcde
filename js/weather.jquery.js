(function($)
{

    var settings =
    {
        'feed'              : null,
        'icon_url'          : "https://www.washington.edu/static/image/weather/", 
    };

    var methods = 
    {
        init : function(options)
        {
            settings = $.extend(settings, options);

            if (settings.feed == null)
                $.error('\'feeds\' argument required in constructor');

            this.weather("update");

            return this;
        },

        update : function()
        {
            var container = this;

            if (settings.feed != null)
            {
                var json = "https://ajax.googleapis.com/ajax/services/feed/load?v=1.0&callback=?&q=";

                json += encodeURIComponent(settings.feed);

                $.getJSON(json,
                    function(data) 
                    {
                        var feed = data.responseData.feed;

                        var temp = feed.entries[0].title.split("| ")[1];
                        var temp_text = "Seattle " + temp;

                        var weather = feed.entries[1].title.split("| ")[1];

                        var icon = feed.entries[2].title.split("| ")[1];
                        var icon_url = settings.icon_url + icon + ".png";

                        container.find("span.weather-city a").text(temp_text);
                        container.find("img")
                            .attr("src", icon_url)
                            .attr("alt", weather)
                            .attr("title", weather);

                        //container.slideDown("slow");
                    }
                );
            }

            return this;
        },

        settings : function()
        {
            return settings;
        }

    };

    $.fn.weather = function(method)
    {
        if (methods[method])
        {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        }
        else if (typeof method === 'object' || !method)
        {
            return methods.init.apply(this, arguments);
        }
        else
        {
            $.error('Method ' + method + ' does not exist in jQuery.gCalEvents');
        }
    };

})(jQuery);