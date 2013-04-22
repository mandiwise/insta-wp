(function ($) {
	"use strict";
	$('ul.insta-hash.' + tag_vars.tag_query).spectragram('getRecentTagged', {
		query: tag_vars.tag_query,
		size: tag_vars.tag_size,
		max: tag_vars.tag_max
	});	
}(jQuery));