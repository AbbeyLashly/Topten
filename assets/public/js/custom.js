// JavaScript Document
(function($) {
	"use strict";
	/**
	 * Lastest tweets
	 */
	var swbignews_LastestTweet = function() {
		$('.shw-widget .latest-tweets ul li').prepend('<span class="icon fa fa-twitter fa-fw"></span>');
	};
	
	//weather widget js
	var swbignews_WeatherWidget = function() {
		$(".weather-news").each(function() {
			var weather_class = $(this).attr('class').split(" ");
			var location = $(this).attr('data-item');
			if(location){
				$.simpleWeather({
					location: location,
					woeid: '',
					unit: 'c',
					success: function(weather) {
						if( weather ) {
							var html = '<div class="location-link"><a href="#"><i class="fa fa-location-arrow mrs"></i>' + weather.city + ', ' + weather.country + '</a><div class="clearfix"></div></div>';
							html += '<div class="section-content">';
							html += '<div class="today-weather"><div class="today-weather-wrapper"><div class="icon-weather"><i class="icons icon-' + weather.code + '"></i></div><div class="temp-wrapper"><div class="temp">' + weather.temp + '&deg;</div></div><div class="info-wrapper"><div class="info"><p>' + weather.currently + '</p><small>' + weather.forecast[0].date + '</small></div></div></div></div>';
							html += '<div class="next-day-weather"><div class="row">';
							for (var i = 1; i < 4; i++) {
								html += '<div class="col-md-4 text-center col-xs-4"><i class="icon-weather icon-' + weather.forecast[i].code + '"></i><div class="temp">' + weather.forecast[i].low + '&deg; - ' + weather.forecast[i].high + '&deg; </div><div class="date-weather date1">' +
									weather.forecast[i].date + '</div></div>';
							}
							html += '</div></div>';
							html += '</div>';
							$(".weather-news."+weather_class[1]).html(html);
						}
					},
					error: function(error) {
						$(".weather-news."+weather_class[1]).html('<p>' + error + '</p>');
					}
				});
			}
		});
	};
	
	/**
	 * Initial Script
	 */
	$(document).ready(function() {
		swbignews_LastestTweet();
		swbignews_WeatherWidget();
	});
})(jQuery);