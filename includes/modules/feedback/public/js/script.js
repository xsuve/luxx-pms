/* Feedback Module */

$(function() {

	// Add Feedback Date
	$('#addFeedbackDateDatepicker').datepicker({
  	format: 'yyyy-mm-dd',
  	zIndex: 9998
	});

  $('.feedback-description-preview').on('click', function() {
    var id = $(this).data('feedback-id');
    $(this).hide();
    $('.feedback-description[data-feedback-id="' + id + '"]').slideToggle();
  });
  $('.feedback-description').on('click', function() {
    var id = $(this).data('feedback-id');
    $(this).hide();
    $('.feedback-description-preview[data-feedback-id="' + id + '"]').show();
  });

});