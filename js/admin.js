(function ($) {
	"use strict";
	$(function () {
		
		// - add classes and ids Instagram feed settings form -
		$('body.settings_page_instawp-options table.form-table').last().addClass('image-feed');
		$('table.image-feed tr:nth-child(2)').attr('id', 'hash-tag').addClass('byhash');
		$('table.image-feed tr:nth-child(3)').attr('id', 'user').addClass('byuser');
		
		// - hide fields that aren't required based on the "displayby" selection - 
		$(function() {
			var $tr = $('table.image-feed').find('tr.byhash, tr.byuser')
			$('[name="instawp_options[displayby]"]').change(function() {
				if (this.value == 'none') {
                	$('.byhash, .byuser').hide();
            	}
				else {
					$tr.hide().filter('.' + this.value).show('600', function() { 
						$($tr).find('input:hidden').val('');
					});
            	}
			}).change();
		});
	});
	
	// - reset the form to make another shortcode -
	$(function() {
		$('#reset').click(function(){
			$(':input','.image-feed')
				.not(':button, :submit, :reset, :hidden')
				.val('')
				.removeAttr('selected');
			$('[name="instawp_options[displayby]"]').val('none');
			$('.byhash, .byuser, #insta-shortcode').fadeOut('300');
			$('[name="instawp_options[max]"]').val('10');
			$('[name="instawp_options[size]"]').val('medium');
		});
		
		$("#reset").appendTo(".submit");
	
	});
	
}(jQuery));