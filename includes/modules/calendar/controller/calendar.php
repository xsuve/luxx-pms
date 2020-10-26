<?php

class Calendar extends Controller {

  // Box
  public function index() {
    $account = $this->getSessionAccount();

    if($account != null) {
      require 'includes/modules/calendar/views/_templates/header.php';
      require 'includes/modules/calendar/views/_templates/box.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // View
  public function view() {
    $account = $this->getSessionAccount();

    if($account != null) {
      $modules_model = $this->loadModel('ModulesModel');
      $widget_status = $modules_model->getWidgetDisplayStatus('calendar');
      $pinned_status = $modules_model->getPinnedStatus('calendar');

      $module_model = $this->loadModuleModel('calendar', 'CalendarModel');
      $events = $module_model->getAccountEvents($account->id);
      
      require 'includes/modules/calendar/views/_templates/header.php';
      require 'includes/modules/calendar/views/index.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Edit
  public function edit($id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      $module_model = $this->loadModuleModel('calendar', 'CalendarModel');
      
      $event = $module_model->getEventData($id);

      require 'includes/modules/calendar/views/_templates/header.php';
      require 'includes/modules/calendar/views/edit.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Widget
  public function widget() {
    $account = $this->getSessionAccount();

    if($account != null) {
      $module_model = $this->loadModuleModel('calendar', 'CalendarModel');
      $events = $module_model->getAccountEvents($account->id);

      require 'includes/modules/calendar/views/_templates/header.php';
      require 'includes/modules/calendar/views/_templates/widget.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Add Event
  public function addEvent() {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_add_event'])) {
        $module_model = $this->loadModuleModel('calendar', 'CalendarModel');
        $add_event = $module_model->addEvent($account->id, $_POST['event_title'], $_POST['event_all_day'], $_POST['event_start_date'], $_POST['event_end_date'], $_POST['event_color']);
        if(isset($add_event) && $add_event != null) {
          $_SESSION['alert'] = $add_event;
          header('location: ' . URL . 'modules/view/calendar');
        }

        header('location: ' . URL . 'modules/view/calendar');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Edit Event
  public function editEvent($id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_edit_event'])) {
        $module_model = $this->loadModuleModel('calendar', 'CalendarModel');
        $edit_event = $module_model->editEvent($id, $_POST['event_title'], $_POST['event_all_day'], $_POST['event_start_date'], $_POST['event_end_date'], $_POST['event_color']);
        if(isset($edit_event) && $edit_event != null) {
          $_SESSION['alert'] = $edit_event;
          header('location: ' . URL . 'modules/edit/calendar/' . $id);
        }

        header('location: ' . URL . 'modules/edit/calendar/' . $id);
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Update Event
  public function updateEvent($event_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      $module_model = $this->loadModuleModel('calendar', 'CalendarModel');
      $edit_event = $module_model->updateEvent($event_id, $_POST['startDate'], $_POST['endDate']);
      if(isset($edit_event) && $edit_event != null) {
        print($edit_event);
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Delete Event
  public function deleteEvent($event_id) {
    $account = $this->getSessionAccount();
    
    if($account != null) {
      if(isset($event_id)) {
        $module_model = $this->loadModuleModel('calendar', 'CalendarModel');

        $event_data = $module_model->getEventData($event_id);
        if($event_data->account_id == $account->id) {
          $delete_event = $module_model->deleteEvent($event_id);
          if(isset($delete_event) && $delete_event != null) {
            $_SESSION['alert'] = $delete_event;
            header('location: ' . URL . 'modules/view/calendar');
          }

          header('location: ' . URL . 'modules/view/calendar');
        } else {
          $_SESSION['alert'] = 'You do not have permission to do this.';
          header('location: ' . URL . 'modules');
        }
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }
    
}

?>