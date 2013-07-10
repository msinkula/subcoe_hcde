(function($)
{

    var settings =
    {
        'feeds'             : 
        {
            'gcal'          : null,
            'ypipes'        : null
        },
        'order_by'          : "starttime",
        'max_results'       : 10,
        'single_events'     : true,
        'sort_order'        : "ascending",
        'future_events'     : true,
        'dst'               : false
    };

    var methods = 
    {
        init : function(options)
        {
            settings = $.extend(settings, options);

            if (settings.feeds == null)
                $.error('\'feeds\' argument required in constructor');

            this.coeEvents("update");

            return this;
        },

        update : function()
        {
            var container = this;

            var events = [];
            var async_count = 0;
            var total_feeds = settings.feeds.ypipes.length + settings.feeds.gcal.length;

            $.each(settings.feeds.gcal, function(fNum, feed)
            {
                var json = "//www.google.com/calendar/feeds/";

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

                        events = $.merge(events, parseGCalFeed(data));

                        if (async_count == total_feeds) 
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

            $.each(settings.feeds.ypipes, function(fNum, feed)
            {
                var json = "//pipes.yahoo.com/pipes/pipe.run?_id=";

                json += encodeURIComponent(feed);

                json += "&_render=json&_callback=?";

                $.getJSON(json,
                    function(data) 
                    {
                        ++async_count;

                        events = $.merge(events, parsePipesFeed(data));

                        if (async_count == total_feeds) 
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

    function parsePipesFeed(data)
    {
        var events = [];
        var dst = (settings.dst) ? "PDT" : "PST";

        if (data.value.items)
        {
            $.each(data.value.items, function(eNum, entry) 
            {
                if (entry.title)
                {
                    var e = {};

                    e.when = {};

                    // parse a start time and determine an end time
                    var fulldesc = entry["description"].split("|");
                    var fulltime = fulldesc[0].split('-');

                    if ($.trim(fulltime[1]))
                    {
                        var starttime = new Date(fulltime[0] + " " + dst);
                        e.when.startTime = starttime.toGMTString();

                        // remove hour and ampm
                        var afulltime = fulltime[0].split(" ");
                        afulltime.pop();
                        afulltime.pop();
                        afulltime.pop();

                        var endtime = new Date(afulltime.join(" ") + fulltime[1] + " " + dst);
                        e.when.endTime = endtime.toGMTString();

                        e.content = strip(fulldesc[1]);
                        e.title = entry["y:title"];

                        if (entry.link)
                        {
                            e.related_link = entry.link;
                        }
                        else
                        {
                            var month = starttime.getMonth() + 1;
                            if (month < 10) month = "0" + month;

                            var day = starttime.getDate();

                            var year = starttime.getFullYear();

                            e.related_link = "http://myuw.washington.edu/cal/eventView.do?date=" + year + month + day + "&calendar=coecal&eventId=" + entry['y:id'].value.split("@")[0];
                        }

                        events[eNum] = e;
                    }
                }
            });
        }

        return events;
    }

    function parseGCalFeed(data)
    {

        var events = [];
        var dst = (settings.dst) ? "PDT" : "PST";

        if (data.feed.entry)
        {
            $.each(data.feed.entry, function(eNum, entry) 
            {
                var e = {};

                e.when = entry["gd$when"][0];

                // IE8 doesn't like the default google timestrings
                var temptime = e.when.startTime.split('T');
                var temptime2 = temptime[0].split("-");
                var tempyear = temptime2[0];
                temptime2[0] = temptime2[1];
                temptime2[1] = temptime2[2];
                temptime2[2] = tempyear;
                temptime[0] = temptime2.join("-");
                temptime[1] = temptime[1].split(".000")[0];
                e.when.startTime = temptime.join(' ') + ' ' + dst;
                // safari and ff dont like dashes
                e.when.startTime = e.when.startTime.replace(/-/g, "/");

                temptime = e.when.endTime.split('T');
                temptime2 = temptime[0].split("-");
                tempyear = temptime2[0];
                temptime2[0] = temptime2[1];
                temptime2[1] = temptime2[2];
                temptime2[2] = tempyear;
                temptime[0] = temptime2.join("-");
                temptime[1] = temptime[1].split(".000")[0];
                e.when.endTime = temptime.join(' ') + ' ' + dst;
                e.when.endTime = e.when.endTime.replace(/-/g, "/");

                // make sure the dates play nice with the JS Date object
                if (e.when.startTime.length == 10)
                    e.when.startTime += ' 00:00:00 ' + dst;
                if (e.when.endTime.length == 10)
                    e.when.endTime += ' 00:00:00 ' + dst;

                e.content = strip(entry.content["$t"]);
                e.title = entry.title["$t"];

                if (entry.link)
                {
                    $.each(entry.link, function(lNum, link)
                    {
                        /*
                        if (link.rel == "related")
                            e.related_link = link.href;
                        else if (link.rel == "alternate")
                            e.calendar_link = link.href;
                        */
                        if (link.rel == "alternate")
                            e.related_link = link.href;
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

                    html += '<div class="event">';
                    html += (event.related_link) ? 
                        '<h3><a title="' + event.content + '" href="' + event.related_link + '">' + event.title + '</a></h3>' :
                        '<h3 title="' + event.content + '">' + event.title + '</h3>';
                    html += (event.calendar_link) ?
                        '<h4><a href="' + event.calendar_link + '">' + time + '</a></h4>' :
                        '<h4>' + time + '</h4>';
                    html += '</div>';

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
        
        // need to make sure all browsers show PST time
        var start_date = new Date(start);
        var end_date   = new Date(end);

        // time difference depends on dst
        var offset = ((settings.dst) ? 7 : 8) * 60 * 60 * 1000;
        var uOffset = start_date.getTimezoneOffset() * 60 * 1000;

        start_date = new Date(start_date.getTime() + uOffset - offset);
        end_date = new Date(end_date.getTime() + uOffset - offset);

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

    $.fn.coeEvents = function(method)
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