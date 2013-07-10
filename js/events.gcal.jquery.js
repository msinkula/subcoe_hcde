(function($)
{

    var settings =
    {
        'feeds'             : null,
        'order_by'          : "starttime",
        'max_results'       : 10,
        'single_events'     : true,
        'sort_order'        : "ascending",
        'future_events'     : true
    };

    var methods = 
    {
        init : function(options)
        {
            settings = $.extend(settings, options);

            if (settings.feeds == null)
                $.error('\'feeds\' argument required in constructor');

            this.gCalEvents("update");

            return this;
        },

        update : function()
        {
            var container = this;

            var events = [];
            var async_count = 0;

            $.each(settings.feeds, function(fNum, feed)
            {
                var json = "http://www.google.com/calendar/feeds/";

                json += encodeURIComponent(feed);

                json += "/public/full?alt=json-in-script&callback=?";

                json += "&orderby=" + settings.order_by;
                json += "&max-results=" + settings.max_results;
                json += "&singleevents=" + ((settings.single_events) ? "true" : "false");
                json += "&futureevents=" + ((settings.future_events) ? "true" : "false");
                json += "&sortorder=" + settings.sort_order;

                $.getJSON(json,
                    function(data) 
                    {
                        ++async_count;

                        events = $.merge(events, parseFeed(data));

                        if (async_count == settings.feeds.length) 
                        {
                            events.sort(function(a, b)
                            {
                                return new Date(a.when.startTime) - new Date(b.when.startTime);
                            });
                            insertEvents(container, events);
                        }
                    }
                );
            });

            return this;
        },

        settings : function()
        {
            return settings;
        }

    };

    function parseFeed(data)
    {

        var events = [];

        if (data.feed.entry)
        {
            $.each(data.feed.entry, function(eNum, entry) 
            {
                var e = {};

                // make sure the dates play nice with the JS Date object
                e.when = entry["gd$when"][0];
                if (e.when.startTime.length == 10)
                    e.when.startTime += 'T00:00:00.000';
                if (e.when.endTime.length == 10)
                    e.when.endTime += 'T00:00:00.000';


                e.content = strip(entry.content["$t"]);
                e.title = entry.title["$t"];

                if (entry.link)
                {
                    $.each(entry.link, function(lNum, link)
                    {
                        if (link.rel == "related")
                            e.related_link = link.href;
                        else if (link.rel == "alternate")
                            e.calendar_link = link.href;
                    });
                }

                events[eNum] = e;
            });
        }

        return events;
    }

    function insertEvents(container, events)
    {
        container.children().remove();

        var html = '';

        var prevDay = 0;
        var prevMonth = '';
        if (events)
        {
            var count = 0;
            $.each(events, function(eNum, event)
            {
                if (++count <= settings.max_results)
                {
                    var start = new Date(event.when.startTime);

                    var day = start.getDate();
                    var month = start.toDateString().split(" ")[1];
                    var time = formatTime(event.when.startTime, event.when.endTime);

                    if (prevMonth != month || (prevDay != day && prevMonth == month))
                    {
                        if (prevDay != 0)
                            html += '<div class="clear"></div>' + '</div>'; // second div closes eventgroup
                        html += '<div class="eventgroup">';
                        html += '<div class="eventdate"><h4>' + month + '</h4><h3>' + day + '</h3></div>';
                    }

                    html += '<div class="event">' + 
                        '<h3><a title="' + event.content + '" href="' + event.related_link + '">' + event.title + '</a></h3>' + 
                        '<h4><a href="' + event.calendar_link + '">' + time + '</a></h4>' +
                        '</div>';

                    prevDay = day;
                    prevMonth = month;
                }
            });

            html += '<div class="clear"></div>' + '</div>';
        }

        //container.hide();
        container.append($(html));
        //container.slideDown(1000);
    }

    function strip(html)
    {
        return $("<div>" + html + "</div>").text();
    }

    function formatTime(start, end)
    {

        // convert to pst
        start = start.replace('Z', '-08:00');
        end = end.replace('Z', '-08:00');
        

        var start_date = new Date(start);
        var end_date   = new Date(end);
        var time = start_date.toTimeString().split(" ")[0].split(":");
        var startt = (time[0] > 12) ? (time[0] - 12) + ':' + time[1] : ((time[0] < 10) ? time[0].substr(1) : time[0]) + ':' + time[1];

        startt += time[0] > 11 ? " pm" : " am";

        if (end_date.getTime() - start_date.getTime() > 1000 * 60 * 60 * 12)
        {
            return startt;
        }
        else
        {
            time = end_date.toTimeString().split(" ")[0].split(":");

            var endt;
            if (time[0] > 12)
                endt = (time[0] - 12) + ":" + time[1] + ' pm';
            else if (time[0] == 12)
                endt = '12:' + time[1] + ' pm';
            else if (time[0] == 0)
                endt = '12:' + time[1] + ' am';
            else
                endt = time[0] + ':' + time[1] + ' am';

            return startt + ' - ' + endt;
        }
    }

    $.fn.gCalEvents = function(method)
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