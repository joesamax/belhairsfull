(function( $ ) {

	'use strict';

	$(function(){

		var getUrlParameter = function getUrlParameter(sParam) {
		    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
		        sURLVariables = sPageURL.split('&'),
		        sParameterName,
		        i;
		    for (i = 0; i < sURLVariables.length; i++) {
		        sParameterName = sURLVariables[i].split('=');
		        if (sParameterName[0] === sParam) {
		            return sParameterName[1] === undefined ? true : sParameterName[1];
		        }
		    }
		};
		var wpAction = getUrlParameter('action'),
			loginText = object_name.accountloginText;
		if ( wpAction == "lostpassword"  ) { loginText = object_name.lostpasswordText; }
		if ( wpAction == "register" ) { loginText = object_name.registerText; }
		$( "#login h1" ).remove();
		$( "<div class='login-icon'>Login</div> <h4 class='login-text'>" + loginText + "</h4> <div class='login-divider'></div><div class='form-wrapper'></div>" ).prependTo( "#login > form" );
		$( "#login > form p" ).detach().appendTo('.form-wrapper')
		$( "#login .message" ).click(function() { $(this).fadeOut("slow"); });
		$( "#login form label" ).each(function() {
			var placeholdertext = $(this).text();
			$(this).find("input").attr( 'placeholder', placeholdertext );
		});
		$( "#login > form br" ).remove();
		var label = $('#loginform p:first-child label, #loginform p:first-child + p label, #registerform p:first-child label, #registerform p:first-child + p label, #lostpasswordform p:first-child label'),
			navdash = $("#login p#nav");
        label.contents().filter(function(){return this.nodeType === 3 && this.nodeValue.trim().length > 0}).remove();
        navdash.contents().filter(function(){return this.nodeType === 3 && this.nodeValue.trim().length > 0}).remove();
		$( "html" ).css( "visibility", "visible" ); // show html after page load.

	});

})( jQuery );

