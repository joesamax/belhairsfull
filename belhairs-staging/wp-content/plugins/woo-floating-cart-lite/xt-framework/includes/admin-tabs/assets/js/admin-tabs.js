;( function( $ ) {
	'use strict';

	$(document).ready(function() {

		if($('#fs_affiliation_content_wrapper').length) {

			var $messages = $('#fs_affiliation_content_wrapper #messages');

			if($messages.text().trim() === '') {
				$messages.html('');
			}
		}

	});

})( jQuery );