jQuery(document).ready(function($) {
	
	"use strict";
	
	/* Wait until Google client library is loaded */
	window.onGoogleLibraryLoad = function() {
		
		var gotwplrButton = $('#gotwplr-signin-btn'),
			loginForm = $('#loginform');
		
		gotwplrButton.show();
		
		if (gotwplrButton.hasClass('form_before')) {
			gotwplrButton.insertBefore(loginForm);
		} else if (gotwplrButton.hasClass('form_top')) {
			gotwplrButton.prependTo(loginForm);
		} else if (gotwplrButton.hasClass('form_bottom')) {
			gotwplrButton.appendTo(loginForm);
		}
	}
});