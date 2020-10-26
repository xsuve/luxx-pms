/* Calendar Module */

$(function() {

  // Add Event Date
	$('#addEventStartDateDatepicker, #addEventEndDateDatepicker').datepicker({
	  	format: 'yyyy-mm-dd',
	  	zIndex: 9998
	});

  // Add Event All Day
  $('#addEventAllDayCheckbox').change(function() {
    if(this.checked) {
      $('#addEventAllDayCheckbox').val(this.checked);
    } else {
      $('#addEventAllDayCheckbox').val(this.checked);
    }
  });

});

// Calendar
document.addEventListener('DOMContentLoaded', function() {
  var calendarBox = document.getElementById('calendarBox');

  var calendar = new FullCalendar.Calendar(calendarBox, {
    plugins: ['interaction', 'dayGrid', 'timeGrid'],
    defaultView: 'dayGridMonth',
    header: {
      left: 'title',
      center: '',
      right: 'dayGridMonth,prev,next'
    },
    slotLabelFormat: {
      hour12: false,
      hour: 'numeric',
      minute: '2-digit',
      meridiem: false
    },
    events: events,
    editable: true,
    navLinks: true,
    navLinkDayClick: 'timeGridDay',
    eventColor: '#54a0f7',
    eventTextColor: '#fff',
    eventTimeFormat: {
      hour12: false,
      hour: 'numeric',
      minute: '2-digit',
      meridiem: false
    },
    eventDrop: function(data) {
      var eventStartDate = new Date(data.event._instance.range.start);
      var eventEndDate = new Date(data.event._instance.range.end);
      $.ajax({
        type: 'POST',
        url: URL + 'modules/executemoduleaction/calendar/updateevent/' + data.event._def.publicId,
        data: {
          startDate: eventStartDate.toISOString(),
          endDate: eventEndDate.toISOString()
        },
        success: function(res) {
          //
        }
      });
    },
    eventResize: function(data) {
      var eventStartDate = new Date(data.event._instance.range.start);
      var eventEndDate = new Date(data.event._instance.range.end);
      $.ajax({
        type: 'POST',
        url: URL + 'modules/executemoduleaction/calendar/updateevent/' + data.event._def.publicId,
        data: {
          startDate: eventStartDate.toISOString(),
          endDate: eventEndDate.toISOString()
        },
        success: function(res) {
          //
        }
      });
    },
    eventClick: function(data) {
      if(data.view.title != 'timeGridDay') {
        this.changeView('timeGridDay', data.event._instance.range.start);
      }
    }
  });

  calendar.render();
});