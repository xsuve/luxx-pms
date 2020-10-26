/* SaaS Module */

$(function() {

  // Admin Only
  $('#addPlanAdminOnlyCheckbox').change(function() {
    if(this.checked) {
      $('#addPlanAdminOnlyCheckbox').val(this.checked);
    } else {
      $('#addPlanAdminOnlyCheckbox').val(this.checked);
    }
  });

	// Kanban board
  $('#addPlanKanbanBoardCheckbox').change(function() {
    if(this.checked) {
      $('#addPlanKanbanBoardCheckbox').val(this.checked);
    } else {
      $('#addPlanKanbanBoardCheckbox').val(this.checked);
    }
  });

  // E-mail invoice
  $('#addPlanEmailInvoiceCheckbox').change(function() {
    if(this.checked) {
      $('#addPlanEmailInvoiceCheckbox').val(this.checked);
    } else {
      $('#addPlanEmailInvoiceCheckbox').val(this.checked);
    }
  });

  // Download invoice
  $('#addPlanDownloadPDFCheckbox').change(function() {
    if(this.checked) {
      $('#addPlanDownloadPDFCheckbox').val(this.checked);
    } else {
      $('#addPlanDownloadPDFCheckbox').val(this.checked);
    }
  });

  // Pop Box Close
  $('.pop-box-close').on('click', function() {
    $('html').removeClass('no-scroll');
  });

});