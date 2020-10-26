<?php

class Manager extends Controller {

    // Box
  public function index() {
    $account = $this->getSessionAccount();

    if($account != null) {
      require 'includes/modules/manager/views/_templates/header.php';
      require 'includes/modules/manager/views/_templates/box.php';
    } else {
        header('location: ' . URL . 'login');
    }
  }

  // View
  public function view() {
    $account = $this->getSessionAccount();

    if($account != null) {
      $module_model = $this->loadModuleModel('manager', 'ManagerModel');
      
      require 'includes/modules/manager/views/_templates/header.php';
      require 'includes/modules/manager/views/index.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

    // Load Widget
    public function loadWidget() {
        $account = $this->getSessionAccount();

        if($account != null) {
            $module_model = $this->loadModuleModel('manager', 'ManagerModel');

            require 'includes/modules/manager/views/_templates/header.php';
            require 'includes/modules/manager/views/_templates/widget.php';
        } else {
            header('location: ' . URL . 'login');
        }
    }
    
}