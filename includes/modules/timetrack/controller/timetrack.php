<?php

class Timetrack extends Controller {

  // Box
  public function index() {
    $account = $this->getSessionAccount();

    if($account != null) {
      require 'includes/modules/timetrack/views/_templates/header.php';
      require 'includes/modules/timetrack/views/_templates/box.php';
    } else {
        header('location: ' . URL . 'login');
    }
  }

  // View
  public function view() {
    $account = $this->getSessionAccount();

    if($account != null) {
      $modules_model = $this->loadModel('ModulesModel');
      $widget_status = $modules_model->getWidgetDisplayStatus('timetrack');
      $pinned_status = $modules_model->getPinnedStatus('timetrack');

      $module_model = $this->loadModuleModel('timetrack', 'TimetrackModel');
      $tracked_times = $module_model->getAccountTrackedTimes($account->id);
      $stats_tracked_times = $module_model->getAccountTrackedTimes($account->id);

      $projects_model = $this->loadModel('ProjectsModel');
      $projects = $projects_model->getAccountProjects($account->id);

      // $_SESSION['timetrack'] = null;

      require 'includes/modules/timetrack/views/_templates/header.php';
      require 'includes/modules/timetrack/views/index.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Edit
  public function edit($id = null) {
    if(isset($id) && $id != null) {
      $account = $this->getSessionAccount();

      if($account != null) {
        $module_model = $this->loadModuleModel('timetrack', 'TimetrackModel');

        //$expense = $module_model->getExpenseData($id);

        if($expense != false) {
          require 'includes/modules/timetrack/views/_templates/header.php';
          require 'includes/modules/timetrack/views/edit.php';
        } else {
          $_SESSION['alert'] = 'That tracked time does not exist.';
          $this->redirect(URL . 'modules/view/timetrack');
        }
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'modules/view/expenses');
    }
  }

  // Widget
  public function widget() {
    $account = $this->getSessionAccount();

    if($account != null) {
      $module_model = $this->loadModuleModel('timetrack', 'TimetrackModel');

      require 'includes/modules/timetrack/views/_templates/header.php';
      require 'includes/modules/timetrack/views/_templates/widget.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Start New Timer
  public function startNewTimer() {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_start_new_timer'])) {
        $module_model = $this->loadModuleModel('timetrack', 'TimetrackModel');
        $start_new_timer = $module_model->startNewTimer($account->id, $_POST['tracked_time_title'], $_POST['project_id'], $_POST['start_from']);
        if(isset($start_new_timer) && $start_new_timer != null) {
          $_SESSION['alert'] = $start_new_timer;
          header('location: ' . URL . 'modules/view/timetrack');
        }

        header('location: ' . URL . 'modules/view/timetrack');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Add Timer Time
  public function addTimerTime($id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      $module_model = $this->loadModuleModel('timetrack', 'TimetrackModel');
      $add_timer_time = $module_model->addTimerTime($id);
    } else {
      header('location: ' . URL . 'login');
    }
  }

}

?>
