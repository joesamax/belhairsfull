( function( $, api ){

	wp.customize.panel( 'mobile_menu_builder_panel', function( section ) {
		section.expanded.bind( function( isExpanding ) {
			if ( isExpanding ) {
				$( 'body' ).addClass( 'preview-mobile' );
			}
		});
	});
	
} )( jQuery, wp.customize );