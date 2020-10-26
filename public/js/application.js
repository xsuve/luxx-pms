'use strict';

// Config
var URL = 'http://localhost/luxx/'; // Change this to your URL.

$(function() {

	// Sidebar & Topbar
	var pathname = window.location.pathname;
	var sidebarLink = pathname.split('/')[2];
  var actionLink = pathname.split('/')[3];
  /*
    ... .split('/')[1] -> [1] -> ex. http://demo.com/luxx/
    ... .split('/')[2] -> [2] -> ex. http://demo.com/luxx/projects/
    ... .split('/')[3] -> [3] -> ex. http://demo.com/demo/luxx/projects/
  */
  var searchIcon = '';
  var x = document.createElement('span');
	$('#' + sidebarLink + 'Link').addClass('active');
	switch(sidebarLink) {
    case 'dashboard':
      $('.topbar-title').text('Dashboard');
      $('.topbar-link-box-icon.to-change').removeClass('fe fe-plus').addClass('fe fe-tiled');
      $('.topbar-add-link').attr('href', URL + 'dashboard');
      x.innerHTML = '&#xf14e;&nbsp;&nbsp;Search contacts, projects or invoices';
      $('#searchBar').attr('placeholder', x.textContent);
    break;
		case 'contacts':
      if(actionLink) {
        $('.topbar-link-box-icon.to-change').removeClass('fe fe-plus').addClass('fe fe-arrow-left');
        $('.topbar-add-link').attr('href', URL + 'contacts');
        $('#searchBar').hide();
        switch(actionLink) {
          case 'add':
            $('.topbar-title').text('Add contact');
          break;
          case 'edit':
            $('.topbar-title').text('Edit contact');
          break;
          case 'view':
            $('.topbar-title').text('View contact');
          break;
        }
      } else {
        $('.topbar-title').text('Contacts');
        $('.topbar-add-link').attr('href', URL + 'contacts/add');
        x.innerHTML = '&#xf14e;&nbsp;&nbsp;Search by contact name, e-mail or category';
        $('#searchBar').attr('placeholder', x.textContent);
      }
		break;
		case 'projects':
      if(actionLink) {
        $('.topbar-link-box-icon.to-change').removeClass('fe fe-plus').addClass('fe fe-arrow-left');
        $('.topbar-add-link').attr('href', URL + 'projects');
        $('#searchBar').hide();
        switch(actionLink) {
          case 'add':
            $('.topbar-title').text('Add project');
          break;
          case 'edit':
            $('.topbar-title').text('Edit project');
          break;
          case 'view':
            $('.topbar-title').text('View project');
          break;
          case 'task':
            $('.topbar-title').html('Edit task');
          break;
          case 'worker':
            $('.topbar-title').html('Edit worker');
          break;
          case 'kanban':
            $('.topbar-title').html('Kanban board');
          break;
        }
      } else {
        $('.topbar-title').text('Projects');
        $('.topbar-add-link').attr('href', URL + 'projects/add');
        x.innerHTML = '&#xf14e;&nbsp;&nbsp;Search by project title or category';
        $('#searchBar').attr('placeholder', x.textContent);
      }
		break;
		case 'invoices':
      if(actionLink) {
        $('.topbar-link-box-icon.to-change').removeClass('fe fe-plus').addClass('fe fe-arrow-left');
        $('.topbar-add-link').attr('href', URL + 'invoices');
        $('#searchBar').hide();
        switch(actionLink) {
          case 'add':
            $('.topbar-title').text('Add invoice');
            $('.add-invoice-form').hide();
          break;
          case 'edit':
            $('.topbar-title').text('Edit invoice');
          break;
          case 'view':
            $('.topbar-title').text('View invoice');
          break;
          case 'item':
            $('.topbar-title').text('Edit item');
          break;
          case 'email':
            $('.topbar-title').text('E-mail invoice');
          break;
        }
      } else {
        $('.topbar-title').text('Invoices');
        $('.topbar-add-link').attr('href', URL + 'invoices/add');
        x.innerHTML = '&#xf14e;&nbsp;&nbsp;Search by invoice contact name, contact e-mail or category';
        $('#searchBar').attr('placeholder', x.textContent);
      }
		break;
		case 'modules':
      if(actionLink) {
        var moduleName = pathname.split('/')[4];
        if($('#' + moduleName + 'Link').length) {
          $('#' + moduleName + 'Link').addClass('active');
          $('#modulesLink').removeClass('active');
        }
        $('.topbar-title').text(moduleName.charAt(0).toUpperCase() + moduleName.slice(1));

        $('.topbar-link-box-icon.to-change').removeClass('fe fe-plus').addClass('fe fe-arrow-left');
        $('.topbar-add-link').attr('href', URL + 'modules');
        $('#searchBar').hide();
        switch(actionLink) {
          case 'view':
            var moduleName = pathname.split('/')[4];
            if($('#' + moduleName + 'Link').length) {
              $('#' + moduleName + 'Link').addClass('active');
              $('#modulesLink').removeClass('active');
            }
            $('.topbar-title').text(moduleName.charAt(0).toUpperCase() + moduleName.slice(1));
          break;
        }
      } else {
        $('.topbar-title').text('Modules');
        $('.topbar-add-link').attr('href', URL + 'modules/install');
        $('#searchBar').hide();
      }
		break;
    case 'categories':
      if(actionLink) {
        $('.topbar-link-box-icon.to-change').removeClass('fe fe-plus').addClass('fe fe-arrow-left');
        $('.topbar-add-link').attr('href', URL + 'categories');
        $('#searchBar').hide();
        switch(actionLink) {
          case 'edit':
            $('.topbar-title').text('Edit category');
          break;
        }
      } else {
        $('.topbar-title').text('Categories');
        $('.topbar-link-box-icon.to-change').removeClass('fe fe-plus').addClass('fe fe-tag');
        $('.topbar-add-link').attr('href', URL + 'categories');
        $('#searchBar').hide();
      }
    break;
    case 'account':
      $('.topbar-title').text('Account');
      $('.topbar-link-box-icon.to-change').removeClass('fe fe-plus').addClass('fe fe-user');
      $('.topbar-add-link').attr('href', URL + 'account');
      $('#searchBar').hide();
    break;
	}

  // Projects
  $('#addProjectDeadlineDatepicker').datepicker({
      format: 'yyyy-mm-dd',
      zIndex: 9998
  });

  // Invoices
  $('#addInvoiceDueDateDatepicker').datepicker({
      format: 'yyyy-mm-dd',
      zIndex: 9998
  });

  // Search Bar
  $('#searchBar').on('keyup', function() {
    var query = $(this).val().toLowerCase();
    if (query != '') {
      $('.hide-on-search').css('display', 'none');
      var results = $('.box[data-search*="' + query + '"]');
      var data = results.data('search');
      if (results.length) {
        $('.box').parents('.box-col').hide();
        results.parents('.box-col').show();
      } else {
        $('.box').parents('.box-col').hide();
      }
    } else {
      $('.hide-on-search').css('display', 'block');
      $('.box').parents('.box-col').show();
    }
  });

  // Project Tasks
  $('.task-checkbox input').on('change', function() {
    var id = $(this).data('task-id');

    if(this.checked) {
      $.ajax({
        type: 'POST',
        url: URL + 'projects/completetask/' + id
      });

      $('.project-task-title[data-task-id="' + id + '"]').removeClass('c-text');
      $('.project-task-title[data-task-id="' + id + '"]').addClass('c-gray');
    } else {
      $.ajax({
        type: 'POST',
        url: URL + 'projects/activatetask/' + id
      });

      $('.project-task-title[data-task-id="' + id + '"]').removeClass('c-gray');
      $('.project-task-title[data-task-id="' + id + '"]').addClass('c-text');
    }
  });

  // Add Invoice
  $('#addInvoiceContactSelect').on('change', function() {
    $('#addInvoiceContactEmailInput').val($(this).find(':selected').data('contact-email'));
    $('#addInvoiceContactNameInput').val($(this).find(':selected').data('contact-name'));
    $('#addInvoiceContactPhoneInput').val($(this).find(':selected').data('contact-phone'));
    $('#addInvoiceContactAddressInput').val($(this).find(':selected').data('contact-address'));
  });

  // Attachment Input
  $('.attachmentInput').on('change', function() {
    $('.attachmentInputFileName').text(this.value.split('\\').pop().split('/').pop());
    $('.attachment-upload-btn').css('visibility', 'visible');
  });

  // Kanban Board
  $('.kanban-board-body').sortable({
    connectWith: '.kanban-board-body',
    revert: '200',
    zIndex: 9992,
    cursor: 'move',
    receive: function(event, ui) {
      var taskID = ui.item.data('kanban-board-task-id');
      var categoryID = $(this).data('kanban-board-category-id');
      $.ajax({
        type: 'POST',
        url: URL + 'projects/updatetaskcategory/' + taskID,
        data: {
          category_id: categoryID
        }
      });

      ui.item.removeClass('border-top-' + ui.sender.data('kanban-board-category-color'));
      ui.item.addClass('border-top-' + $(this).data('kanban-board-category-color'));
    }
  }).disableSelection();

  $('.kanban-board-footer').on('click', function() {
    var categoryID = $(this).data('kanban-board-category-id');
    var inputBox = '<div class="box b-white form-input-box kanban-board-input-box" data-kanban-board-category-id="' + categoryID + '"><textarea class="text c-text" style="min-height: 70px;" placeholder="Enter the task title"></textarea></div>';
    $('.kanban-board-body[data-kanban-board-category-id="' + categoryID + '"]').append(inputBox);
    $(this).hide();
    $('.kanban-board-footer-onadd-wrapper[data-kanban-board-category-id="' + categoryID + '"]').show();
  });

  $('.kanban-board-footer-onadd.addcancel').on('click', function() {
    var categoryID = $(this).data('kanban-board-category-id');
    $('.kanban-board-input-box[data-kanban-board-category-id="' + categoryID + '"]').remove();
    $('.kanban-board-footer-onadd-wrapper[data-kanban-board-category-id="' + categoryID + '"]').hide();
    $('.kanban-board-footer[data-kanban-board-category-id="' + categoryID + '"]').show();
  });

  $('.kanban-board-footer-onadd.addcomplete').on('click', function() {
    var projectID = $(this).data('project-id');
    var categoryID = $(this).data('kanban-board-category-id');
    var categoryColor = $(this).data('kanban-board-category-color');
    var taskTitle = $('.kanban-board-input-box[data-kanban-board-category-id="' + categoryID + '"] textarea').val();
    if(taskTitle != '') {
      $.ajax({
        type: 'POST',
        url: URL + 'projects/kanbanaddtask',
        data: {
          project_id: projectID,
          task_category_id: categoryID,
          task_worker_id: 0,
          task_title: taskTitle
        },
        success: function(taskID) {
          if(taskID != 0) {
            var taskBox = '<div class="box b-white p-all-15 kanban-board-task border-top-' + categoryColor + '" data-kanban-board-task-id="' + taskID + '"><div class="kanban-board-task-delete b-gray-secondary text-center"><a href="' + URL + 'projects/kanbandeletetask/' + taskID + '"><i class="fe fe-trash c-gray v-middle"></i></a></div><div class="row"><div class="col-lg-2 p-right-0"><div class="form-checkbox task-checkbox"><input type="checkbox" name="status" data-task-id="' + taskID + '"><span class="b-gray-secondary v-middle text-center"><i class="fe fe-check v-middle c-white"></i></span></div></div><div class="col-lg-10 p-left-0"><div class="project-task-title caption c-text">' + taskTitle + '</div></div></div></div>';
            $('.kanban-board-body[data-kanban-board-category-id="' + categoryID + '"]').append(taskBox);
            $('.kanban-board-input-box[data-kanban-board-category-id="' + categoryID + '"]').remove();
            $('.kanban-board-footer-onadd-wrapper[data-kanban-board-category-id="' + categoryID + '"]').hide();
            $('.kanban-board-footer[data-kanban-board-category-id="' + categoryID + '"]').show();
          }
        },
        error: function() {
          $('.kanban-board-input-box[data-kanban-board-category-id="' + categoryID + '"]').remove();
          $('.kanban-board-footer-onadd-wrapper[data-kanban-board-category-id="' + categoryID + '"]').hide();
          $('.kanban-board-footer[data-kanban-board-category-id="' + categoryID + '"]').show();
        }
      });
    }
  });

  // Notifications
  var notificationsToggled = false;
  $('#notificationsBtn').on('click', function() {
    if(notificationsToggled == false) {
      $('.notifications-dropdown').show();
      notificationsToggled = true;
    } else {
      $('.notifications-dropdown').hide();
      notificationsToggled = false;
    }
  });
  $(document).on('click', function() {
    $('.notifications-dropdown').hide();
    notificationsToggled = false;
  });
  $('#notificationsBtn, .notifications-dropdown').on('click', function(e) {
    e.stopPropagation();
  });

  $('.notification-element').on('click', function() {
    var id = $(this).data('notification-id');
    $.ajax({
      type: 'POST',
      url: URL + 'notifications/markviewednotification/' + id
    });
  });

});
