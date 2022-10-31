(function($) {
	'use strict';
	$( document ).on(
		"click",
		".wp-adminify-author-link-to-data-uri",
		function() {
			window.open( $( this ).data( "adminify-comment-uri" ) );
		}
	);
})( jQuery );
