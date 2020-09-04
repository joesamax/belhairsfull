/**
 * Create Popup Menu Expander
 *
 * @author  Jeffrey Carandang
 */

var mobileMenuBuilderExpander = ( function( $ ) {
	'use strict';

	/**
	 * Trigger popup on menu click
	 *
	 * @since 1.0
	 */
	var menuClick = function() {
		var getFill  = $( '.mobile-menu-builder--link-1 svg' ).css('fill');
		var svgClose = '<span class="mobile-menu-builder--svgClose"><svg xmlns="http://www.w3.org/2000/svg" style="fill:'+ getFill +';" viewBox="0 0 512 512"><path d="M278.6 256l68.2-68.2c6.2-6.2 6.2-16.4 0-22.6-6.2-6.2-16.4-6.2-22.6 0L256 233.4l-68.2-68.2c-6.2-6.2-16.4-6.2-22.6 0-3.1 3.1-4.7 7.2-4.7 11.3 0 4.1 1.6 8.2 4.7 11.3l68.2 68.2-68.2 68.2c-3.1 3.1-4.7 7.2-4.7 11.3 0 4.1 1.6 8.2 4.7 11.3 6.2 6.2 16.4 6.2 22.6 0l68.2-68.2 68.2 68.2c6.2 6.2 16.4 6.2 22.6 0 6.2-6.2 6.2-16.4 0-22.6L278.6 256z"/></svg></span>';
		$( document ).on( 'click', '.mobile-menu-builder--opener a', function(e){
			
			if( $( '.mobile-menu-builder-popup--container' ).is(':visible') ){
				$( '.mobile-menu-builder--clicked .mobile-menu-builder--svgClose' ).remove();
				$( '.mobile-menu-builder--clicked .mobile-menu-builder--icon' ).css({ 'font-size' : '' })
				$( '.mobile-menu-builder--opener a' ).removeClass( 'mobile-menu-builder--clicked' );
			}else{
				var h = parseFloat( $(this).height() ) - 3;
				$( this ).addClass( 'mobile-menu-builder--clicked' );
				$( this ).find( '.mobile-menu-builder--icon' ).css({ 'font-size' : h + 'px' });

				if( !$( this ).parent().hasClass( 'mobile-menu-builder-customizer--expander' ) ){
					$( this ).append(  $( svgClose ).css({ 'width' : h + 'px' })  );
				}
			}

			$( '.mobile-menu-builder-popup--container' ).fadeToggle( 150 );
			
			e.preventDefault();
			e.stopImmediatePropagation();
		} );
	},

	/**
	 * Sync Popup padding to menu height
	 *
	 * @since 1.0
	 */
	syncHeight = function(){
		var menuHeight 	= $( '.mobile-menu-builder-customizer--container' ).outerHeight();
		var popup 		= $( '.mobile-menu-builder-popup--container' );

		if( popup.length > 0 ){
			popup.css({ 'padding-bottom' : menuHeight + 'px', 'padding-top' : '0px' });

			if( $( 'body' ).hasClass( 'mobile-menu-builder--top' ) ){
				popup.css({ 'padding-bottom' : '0px' ,'padding-top' : menuHeight + 'px' });
			}
		}

		//add body margin
		if( $( 'body' ).hasClass( 'mobile-menu-builder--top' ) ){
			var mTop = parseFloat( $( 'body.mobile-menu-builder--top' ).css('margin-top') );
			$( 'body.mobile-menu-builder--top' ).css({ 'margin-top' : ( menuHeight + mTop ) + 'px' })
		}else if( $( 'body' ).hasClass( 'mobile-menu-builder--bottom' ) ){
			var mBottom = parseFloat( $( 'body.mobile-menu-builder--bottom' ).css('margin-bottom') );
			$( 'body.mobile-menu-builder--bottom' ).css({ 'margin-bottom' : ( menuHeight + mBottom ) + 'px' })
		}
	},

	onResize = function(){
		$( window ).on( 'resize', function(){
			if( !$( '.mobile-menu-builder-customizer--container' ).is(':visible') ){
				$( '.mobile-menu-builder-popup--container' ).hide();
				$( '.mobile-menu-builder--opener a' ).removeClass( 'mobile-menu-builder--clicked' );
			}
			
			// if( isPortrait() ){
				forceVisible();
			// }
			
		} );
	},

	onScroll = function(){
		// Hide Header on on scroll down
		var didScroll;
		var lastScrollTop = 0;
		var delta = 5;



		$(window).scroll(function(event){
		    // didScroll = true;

		    hasScrolled();
		});

		// setInterval(function() {
		//     if ( didScroll ) {
		//         hasScrolled();
		//         didScroll = false;
		//     }
		// }, 150);

		function hasScrolled() {
		    var st = $( window ).scrollTop();

		    if( $( '.mobile-menu-builder-popup--container' ).is(':visible') ){
				return;
			}

			if( !$( 'body' ).hasClass( 'mobile-menu-builder--animate' ) ){
				return;
			}

		    // Make sure they scroll more than delta
		    // if( Math.abs(lastScrollTop - st) <= delta ){
		    // 	return;
		    // }
		    
		    // If they scrolled down and are past the navbar, add class .mmb--up.
		    // This is necessary so you never see what is "behind" the navbar.
		    if ( st > lastScrollTop && st > 0 ){
		        // Scroll Down
		        $('.mobile-menu-builder-customizer--container').removeClass( 'mmb--down' ).addClass( 'mmb--up' );

		    } else {
		        // Scroll Up
		        $('.mobile-menu-builder-customizer--container').removeClass( 'mmb--up' ).addClass( 'mmb--down' );
		    }
		    
		    lastScrollTop = st;
		}
	},

	forceVisible = function(){
		if( navigator.userAgent.match(/(iPod|iPhone|iPad)/) ){
			var windowHeight = window.innerHeight ? window.innerHeight : $(window).height();
			var screenHeight = screen.availHeight ? screen.availHeight : windowHeight;
			var screenWidth = screen.availWidth ? screen.availWidth : windowHeight;
			if( windowHeight < screenHeight ){
				$('.mobile-menu-builder-customizer--container').removeClass( 'mmb--up' ).addClass( 'mmb--down' );
			}
			if( window.orientation !== 'undefined' && window.orientation == 90 ){
				if( windowHeight < screenWidth  ){
					$('.mobile-menu-builder-customizer--container').hide().css({ 'bottom' : $('.mobile-menu-builder-customizer--container').height() - 12 }).fadeIn();
				}else{
					$('.mobile-menu-builder-customizer--container').hide().css({ 'bottom' : 0 }).fadeIn();
				}
			}else{
				$('.mobile-menu-builder-customizer--container').hide().css({ 'bottom' : 0 }).fadeIn();
			}
		}
	},

	isPortrait = function(){
	    return window.innerHeight > window.innerWidth;
	},

	/**
	 * Initialize Menu.
	 *
	 * Internal functions to execute on full page load.
	 *
	 * @since 1.0
	 */
	load = function() {
		menuClick();
		syncHeight();
		onScroll();
		onResize();
	};

	// Expose the load and ready functions.
	return {
		load: load
	};

})( jQuery );

jQuery( document ).ready( mobileMenuBuilderExpander.load );