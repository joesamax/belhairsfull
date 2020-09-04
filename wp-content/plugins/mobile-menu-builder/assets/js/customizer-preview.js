( function( $ ){

	wp.customize( 'mobile_menu_builder_customizer[menuCount]', function( value ) {
		value.bind( function( to ){
			var menuLinks = $('.mobile-menu-builder-customizer--container .mobile-menu-builder--links:visible').length;
			to 			  = parseInt( to );
			// console.log( menuLinks + '-' + to );
			if( menuLinks > to ){
				for (var i = to + 1; i <= 5; i++) {
					$('.mobile-menu-builder-customizer--container .mobile-menu-builder--links:nth-child('+ i +')').hide();	
				}
			}else if( menuLinks < to ){
				for (var i = menuLinks; i <= to; i++) {
					$('.mobile-menu-builder-customizer--container .mobile-menu-builder--links:nth-child('+ i +')').show();	
				}
			}
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[enableAnimation]', function( value ) {
        value.bind( function( to ){
            var menuHeight  = $( '.mobile-menu-builder-customizer--container' ).outerHeight();
            if( to ){
                $( 'body' ).addClass( 'mobile-menu-builder--animate' );
            }else{
                $( 'body' ).removeClass( 'mobile-menu-builder--animate' );
            }     
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[position]', function( value ) {
        value.bind( function( to ){
            var menuHeight  = $( '.mobile-menu-builder-customizer--container' ).outerHeight();

            $('body').removeClass( 'mobile-menu-builder--top mobile-menu-builder--bottom' );
            $('body').addClass( 'mobile-menu-builder--' + to );

            var popup       = $( '.mobile-menu-builder-popup--container' );

            if( popup.length > 0 ){
                popup.css({ 'padding-bottom' : menuHeight + 'px', 'padding-top' : '0px' });

                if( to == 'top' ){
                    popup.css({ 'padding-bottom' : '0px' ,'padding-top' : menuHeight + 'px' });
                }
            }
        });
    });
	
    wp.customize( 'mobile_menu_builder_customizer[hideIcon]', function( value ) {
        value.bind( function( to ){
            if( to ){
                $('.mobile-menu-builder--icon').hide();
            }else{
                $('.mobile-menu-builder--icon').show();
            }
        });
    });
    
    wp.customize( 'mobile_menu_builder_customizer[hideLabel]', function( value ) {
        value.bind( function( to ){
            if( to ){
                $('.mobile-menu-builder--label').hide();
            }else{
                $('.mobile-menu-builder--label').show();
            }
        });
    });

	wp.customize( 'mobile_menu_builder_customizer[containerbg]', function( value ) {
		value.bind( function( to ){
            $('.mobile-menu-builder-customizer--container').css( { 'background-color': to } );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[containerbr]', function( value ) {
		value.bind( function( to ){
            $('.mobile-menu-builder-customizer--container').css( { 'border-color': to } );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[textColor]', function( value ) {
		value.bind( function( to ){
            $('.mobile-menu-builder--label').css( { 'color': to } );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[iconColor]', function( value ) {
		value.bind( function( to ){
            $('.mobile-menu-builder--icon').css( { 'color': to } );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[linkOpacity]', function( value ) {
		value.bind( function( to ){
            $('.mobile-menu-builder--links:not(.mobile-menu-builder--current-page) a').css( { 'opacity': parseInt( to )/100 } );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[font]', function( value ) {
        value.bind( function( to ){
            $( 'head link[rel="stylesheet"]' ).last().after("<link rel='stylesheet' href='//fonts.googleapis.com/css?family="+ to +":100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' type='text/css' media='screen'>");
       		$( '.mobile-menu-builder--label' ).css({ 'font-family': to  });
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[iconSize]', function( value ) {
		value.bind( function( to ){
            $('.mobile-menu-builder--icon').css( { 'font-size': to } );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[labelSize]', function( value ) {
		value.bind( function( to ){
            $('.mobile-menu-builder--label').css( { 'font-size': to } );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[menuHoverBg]', function( value ) {
		value.bind( function( to ){
            $('.mobile-menu-builder--current-page a').css( { 'background-color': to } );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[iconHoverColor]', function( value ) {
		value.bind( function( to ){
            $('.mobile-menu-builder--current-page a .mobile-menu-builder--icon').css( { 'color': to } );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[textHoverColor]', function( value ) {
		value.bind( function( to ){
            $('.mobile-menu-builder--current-page a .mobile-menu-builder--label').css( { 'color': to } );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[linkHoverOpacity]', function( value ) {
		value.bind( function( to ){
            $('.mobile-menu-builder--current-page.mobile-menu-builder--links a').css( { 'opacity': parseInt( to )/100 } );
        });
    });

	wp.customize( 'mobile_menu_builder_customizer[menu-1-icon]', function( value ) {
		value.bind( function( to ){
			if( to == '' ){
				$('.mobile-menu-builder--link-1').addClass( 'mobile-menu-builder--noicon' );
			}else{
				$('.mobile-menu-builder--link-1').removeClass( 'mobile-menu-builder--noicon' );
			}
            $('.mobile-menu-builder--link-1 .mobile-menu-builder--icon').removeAttr('class');;
            $('.mobile-menu-builder--link-1 i').attr( 'class', 'mobile-menu-builder--icon ' + to );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[menu-1-label]', function( value ) {
		value.bind( function( to ){
			if( to == '' ){
				$('.mobile-menu-builder--link-1').addClass( 'mobile-menu-builder--nolabel' );
			}else{
				$('.mobile-menu-builder--link-1').removeClass( 'mobile-menu-builder--nolabel' );
			}

            $('.mobile-menu-builder--link-1 .mobile-menu-builder--label').html( to );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[menu-2-icon]', function( value ) {
		value.bind( function( to ){
			if( to == '' ){
				$('.mobile-menu-builder--link-2').addClass( 'mobile-menu-builder--noicon' );
			}else{
				$('.mobile-menu-builder--link-2').removeClass( 'mobile-menu-builder--noicon' );
			}
            $('.mobile-menu-builder--link-2 .mobile-menu-builder--icon').removeAttr('class');;
            $('.mobile-menu-builder--link-2 i').attr( 'class', 'mobile-menu-builder--icon ' + to );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[menu-2-label]', function( value ) {
		value.bind( function( to ){
			if( to == '' ){
				$('.mobile-menu-builder--link-2').addClass( 'mobile-menu-builder--nolabel' );
			}else{
				$('.mobile-menu-builder--link-2').removeClass( 'mobile-menu-builder--nolabel' );
			}
            $('.mobile-menu-builder--link-2 .mobile-menu-builder--label').html( to );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[menu-3-icon]', function( value ) {
		value.bind( function( to ){
			if( to == '' ){
				$('.mobile-menu-builder--link-3').addClass( 'mobile-menu-builder--noicon' );
			}else{
				$('.mobile-menu-builder--link-3').removeClass( 'mobile-menu-builder--noicon' );
			}
            $('.mobile-menu-builder--link-3 .mobile-menu-builder--icon').removeAttr('class');;
            $('.mobile-menu-builder--link-3 i').attr( 'class', 'mobile-menu-builder--icon ' + to );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[menu-3-label]', function( value ) {
		value.bind( function( to ){
			if( to == '' ){
				$('.mobile-menu-builder--link-3').addClass( 'mobile-menu-builder--nolabel' );
			}else{
				$('.mobile-menu-builder--link-3').removeClass( 'mobile-menu-builder--nolabel' );
			}
            $('.mobile-menu-builder--link-3 .mobile-menu-builder--label').html( to );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[menu-4-icon]', function( value ) {
		value.bind( function( to ){
			if( to == '' ){
				$('.mobile-menu-builder--link-4').addClass( 'mobile-menu-builder--noicon' );
			}else{
				$('.mobile-menu-builder--link-4').removeClass( 'mobile-menu-builder--noicon' );
			}
            $('.mobile-menu-builder--link-4 .mobile-menu-builder--icon').removeAttr('class');;
            $('.mobile-menu-builder--link-4 i').attr( 'class', 'mobile-menu-builder--icon ' + to );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[menu-4-label]', function( value ) {
		value.bind( function( to ){
			if( to == '' ){
				$('.mobile-menu-builder--link-4').addClass( 'mobile-menu-builder--nolabel' );
			}else{
				$('.mobile-menu-builder--link-4').removeClass( 'mobile-menu-builder--nolabel' );
			}
            $('.mobile-menu-builder--link-4 .mobile-menu-builder--label').html( to );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[menu-5-icon]', function( value ) {
		value.bind( function( to ){
			if( to == '' ){
				$('.mobile-menu-builder--link-5').addClass( 'mobile-menu-builder--noicon' );
			}else{
				$('.mobile-menu-builder--link-5').removeClass( 'mobile-menu-builder--noicon' );
			}
            $('.mobile-menu-builder--link-5 .mobile-menu-builder--icon').removeAttr('class');;
            $('.mobile-menu-builder--link-5 i').attr( 'class', 'mobile-menu-builder--icon ' + to );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[menu-5-label]', function( value ) {
		value.bind( function( to ){
			if( to == '' ){
				$('.mobile-menu-builder--link-5').addClass( 'mobile-menu-builder--nolabel' );
			}else{
				$('.mobile-menu-builder--link-5').removeClass( 'mobile-menu-builder--nolabel' );
			}
            $('.mobile-menu-builder--link-5 .mobile-menu-builder--label').html( to );
        });
    });


    //popup
    wp.customize( 'mobile_menu_builder_customizer[popupBg]', function( value ) {
        value.bind( function( to ){
            $('.mobile-menu-builder-popup--container').css( { 'background-color': to } );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[popupTextAlign]', function( value ) {
        value.bind( function( to ){
            $('.mobile-menu-builder-popup--inner').removeClass( 'mobile-menu-builder-popup--left mobile-menu-builder-popup--center mobile-menu-builder-popup--right' );
            $('.mobile-menu-builder-popup--inner').addClass( 'mobile-menu-builder-popup--' + to );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[popupHeadingColor]', function( value ) {
        value.bind( function( to ){
            $('.mobile-menu-builder-popup--inner h3.widgettitle').css( { 'color': to } );
        });
    });
    wp.customize( 'mobile_menu_builder_customizer[popupHeadingSize]', function( value ) {
        value.bind( function( to ){
            $('.mobile-menu-builder-popup--inner h3.widgettitle').css( { 'font-size': to } );
        });
    });


    wp.customize( 'mobile_menu_builder_customizer[popupTextColor]', function( value ) {
        value.bind( function( to ){
            $('.mobile-menu-builder-popup--inner, .mobile-menu-builder-popup--inner p, .mobile-menu-builder-popup--inner li, .mobile-menu-builder-popup--inner a').css( { 'color': to } );
        });
    });
    wp.customize( 'mobile_menu_builder_customizer[popupTextSize]', function( value ) {
        value.bind( function( to ){
            $('.mobile-menu-builder-popup--inner, .mobile-menu-builder-popup--inner p, .mobile-menu-builder-popup--inner li, .mobile-menu-builder-popup--inner a').css( { 'font-size': to } );
        });
    });

    wp.customize( 'mobile_menu_builder_customizer[popupFontFamily]', function( value ) {
        value.bind( function( to ){
            $( 'head link[rel="stylesheet"]' ).last().after("<link rel='stylesheet' href='//fonts.googleapis.com/css?family="+ to +":100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' type='text/css' media='screen'>");
            $( '.mobile-menu-builder-popup--inner h3.widgettitle, .mobile-menu-builder-popup--inner, .mobile-menu-builder-popup--inner p, .mobile-menu-builder-popup--inner li, .mobile-menu-builder-popup--inner a' ).css({ 'font-family': to  });
        });
    });


} )( jQuery );