(function($)
{

	var settings =
	{
		'user'			: null,
		'count'			: 5,
		'include_rts'	: true
	};

	//var tweets = [];

	var methods = 
	{
		init : function(options)
		{
			settings = $.extend(settings, options);

			if (settings.user == null)
				$.error('\'user\' argument required in tweets constructor');

			this.tweets("update");

			return this;
		},

		update : function()
		{
			var http = "http://api.twitter.com/1/statuses/user_timeline.json?";

			http += "callback=?";
			http += "&include_rts=" + ((settings.include_rts) ? "t" : "f");
			http += "&include_entities=t";
			http += "&count=" + settings.count;
			http += "&screen_name=" + settings.user;

			var container = this;

			$.getJSON(http, function(data) {

				container.children().remove();

				$.each(data, function(tNum, tweet)
				{
					var tweetTime = tweet.created_at; // we want the time of this tweet, even if it is a retweet

					var rt = '';

					if (tweet.retweeted_status) 
					{
						rt = '<div class="tweet-rt">Retweeted by <a href="http://twitter.com/' + tweet.user.screen_name + '">' + tweet.user.screen_name + '</a></div>';
					
						tweet = tweet.retweeted_status; // switch to retweet data if it is a retweet
					}

					var text = parseEntities(tweet);

					var time = '<a class="tweet-time" href="http://twitter.com/' + settings.user + '/status/' + tweet.id_str + '">' + 
						parseTime((Date.parse((new Date()).toString()) - Date.parse(tweetTime)) / 1000) + '</a>';

					var reply = '<a class="tweet-reply" href="http://twitter.com/intent/tweet?in_reply_to=' + tweet.id_str + '">Reply</a>';

					var retweet = '<a class="tweet-retweet" href="http://twitter.com/intent/retweet?tweet_id=' + tweet.id_str + '">Retweet</a>';

					var fav = '<a class="tweet-fav" href="http://twitter.com/intent/favorite?tweet_id=' + tweet.id_str + '">Favorite</a>';					


                    var t = '<div class="tweet">';

					t += '<div class="tweet-user-img"><a href="http://twitter.com/' + tweet.user.screen_name + 
						'"><img src="' + tweet.user.profile_image_url + '" alt="' + tweet.user.name + '" /></a></div>';

					tc = '<div class="tweet-content">';


					tc += '<div class="tweet-user"><a href="http://twitter.com/' + tweet.user.screen_name + 
						'"><span class="tweet-screenname" title="' + tweet.user.description + '">' + tweet.user.screen_name + '</span></a>' + 
						'<span class="tweet-username">' + tweet.user.name + '</span></div>';

					tc += '<div class="tweet-text">' + text + '</div>';

					tc += '<div class="tweet-ui">' + time + fav + retweet + reply + '</div>';

					tc += rt + '</div>';

                    t +=  tc + '</div>';

					container.append(t);
				});
				

			});

			return this;
		},

		settings : function()
		{
			return settings;
		}

	};

	function parseTime(seconds)
	{
		var time = "";
		if (seconds < 60)
		{
			time = seconds + " seconds ago";
		}
		else if (seconds < (60 * 60))
		{
			if (seconds < 60 * 2)
				time = "1 minute ago";
			else
				time = Math.floor(seconds / 60) + " minutes ago";
		}
		else if (seconds < (60 * 60 * 24))
		{
			if (seconds < 60 * 60 * 2)
				time = "about 1 hour ago";
			else
				time = "about " + Math.floor(seconds / 60 / 60) + " hours ago";
		}
		else if (seconds < (60 * 60 * 24 * 7))
		{
			if (seconds < 60 * 60 * 24 * 2)
				time = "Yesterday";
			else
				time = Math.floor(seconds / 60 / 60 / 24) + " days ago";
		}
		else
		{
			if (seconds < 60 * 60 * 24 * 7 * 2)
				time = "1 week ago";
			else
				time = Math.floor(seconds / 60 / 60 / 24 / 7) + " weeks ago";
		}
		return time;
	}

	function parseEntities(tweet)
	{
		var eMap = {};
		$.each(tweet.entities.hashtags, function(eNum, hashtag)
		{
			eMap[hashtag.indices[0]] = [
				hashtag.indices[1],
				'<a class="hashtag" href="http://twitter.com/search?q=%23' + hashtag.text + '" target="_blank">#' + hashtag.text + '</a>'
			];
		});
		$.each(tweet.entities.urls, function(eNum, url)
		{
			eMap[url.indices[0]] = [
				url.indices[1],
				'<a href="' + url.expanded_url + '" target="_blank">' + url.display_url + '</a>'
			];
		});
		$.each(tweet.entities.user_mentions, function(eNum, mention)
		{
			eMap[mention.indices[0]] = [
				mention.indices[1],
				'&#64;<a class="mention" title="' + mention.name + '" href="http://twitter.com/' + mention.screen_name + '" target="_blank">' + mention.screen_name + '</a>'
			];
		});

		var text = "";
		var last_i = 0;

		for (var i = 0; i < tweet.text.length; ++i)
		{
			var ind = eMap[i];
			if (ind)
			{
				var end = ind[0];
				var rep = ind[1];
				if (i > last_i)
					text += tweet.text.substring(last_i, i);
				text += rep;
				i = end - 1;
				last_i = end;
			}
		}
		if (i > last_i)
			text += tweet.text.substring(last_i, i);

		return text;
	}

	$.fn.tweets = function(method)
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
			$.error('Method ' + method + ' does not exist in jQuery.tweets');
		}
	};

})(jQuery);