(function ($) {
	"use strict";
	$('ul.insta-user.' + user_vars.user_query).spectragram('getUserFeed', {
		query: user_vars.user_query,
		size: user_vars.user_size,
		max: user_vars.user_max
	});
}(jQuery));