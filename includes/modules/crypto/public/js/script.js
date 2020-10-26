/* Crypto Module */

// URL
var URL = 'http://localhost/luxx/'; // Change this to your URL.

$(function() {

	// Add Reminder
	$('.openAddCryptocurrencyButton').on('click', function() {
	    $('#addCryptocurrencyBox').show();
	});
	$('#closeAddCryptocurrencyButton').on('click', function() {
	    $('#addCryptocurrencyBox').hide();
	});

});