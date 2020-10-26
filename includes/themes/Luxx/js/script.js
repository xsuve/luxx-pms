'use strict';

$(function() {
	// Navbar Links
	$('.navbar-custom-links a').on('click', function() {
	    var href = $(this).attr('href');
	    $('html, body').animate({scrollTop: $(href).offset().top}, 'slow');
	});

	$('.navbar-custom-mobile-menu-button').on('click', function() {
		$('.navbar-custom-links-col').toggle('fast');
	});
});