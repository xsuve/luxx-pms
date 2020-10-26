/* Timetrack Module */

// Config
var URL = 'http://localhost/luxx/'; // Change this to your URL.

$(function() {

  var timetrackToggled = false;
  $('#timetrackBtn').on('click', function() {
    if(timetrackToggled == false) {
      $('.timetrack-dropdown').show();
      timetrackToggled = true;
    } else {
      $('.timetrack-dropdown').hide();
      timetrackToggled = false;
    }
  });
  $(document).on('click', function() {
    $('.timetrack-dropdown').hide();
    timetrackToggled = false;
  });
  $('#timetrackBtn, .timetrack-dropdown').on('click', function(e) {
    e.stopPropagation();
  });

});

function addTimerTime(id) {
  $.ajax({
    type: 'POST',
    url: URL + 'modules/executemoduleaction/timetrack/addtimertime/' + id
  });

  var timerTime = $('.timetrack-timer[data-timetrack-timer-id="' + id + '"]').data('timetrack-timer-time');
  $('.timetrack-timer[data-timetrack-timer-id="' + id + '"]').text(timerTime + 1);
  $('.timetrack-timer[data-timetrack-timer-id="' + id + '"]').data('timetrack-timer-time', timerTime + 1);

  setTimeout(function() {
    addTimerTime(id);
  }, 60000);
}
