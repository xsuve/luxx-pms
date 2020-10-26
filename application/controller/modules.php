<?php

class Modules extends Controller {

  public function index() {
    $account = $this->getSessionAccount();

    if($account != null) {
      $modules_model = $this->loadModel('ModulesModel');

      $modules = $modules_model->getInstalledModules($account->id);

      require 'application/views/_templates/header.php';
      require 'application/views/_templates/topbar.php';
      require 'application/views/_templates/sidebar.php';
      require 'application/views/_templates/alerts.php';
      require 'application/views/modules/index.php';
      require 'application/views/_templates/footer.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

  public function install() {
    $account = $this->getSessionAccount();

    if($account != null) {
      require 'application/views/_templates/header.php';
      require 'application/views/_templates/topbar.php';
      require 'application/views/_templates/sidebar.php';
      require 'application/views/_templates/alerts.php';
      require 'application/views/modules/install.php';
      require 'application/views/_templates/footer.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // View
  public function view($module = null) {
    if(isset($module) && $module != null) {
      $account = $this->getSessionAccount();

      if($account != null) {
        $modules_model = $this->loadModel('ModulesModel');

        require 'application/views/_templates/header.php';
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/topbar.php';
        require 'application/views/_templates/sidebar.php';
        require 'application/views/_templates/alerts.php';
        $modules_model->loadModuleView($module);
        require 'application/views/_templates/footer.php';
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'modules');
    }
  }

  // Edit
  public function edit($module = null, $id = null) {
    if(isset($module) && $module != null && isset($id) && $id != null) {
      $account = $this->getSessionAccount();

      if($account != null) {
        $modules_model = $this->loadModel('ModulesModel');

        require 'application/views/_templates/header.php';
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/topbar.php';
        require 'application/views/_templates/sidebar.php';
        require 'application/views/_templates/alerts.php';
        $modules_model->loadModuleEdit($module, $id);
        require 'application/views/_templates/footer.php';
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'modules');
    }
  }

  // Load Module
  public function loadModule($module) {
    $account = $this->getSessionAccount();

    if($account != null) {
      $modules_model = $this->loadModel('ModulesModel');
      $modules_model->loadModule($module);
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Display Widget
  public function displayWidget($module) {
    if(isset($module) && $module != null) {
      $account = $this->getSessionAccount();

      if($account != null) {
        $modules_model = $this->loadModel('ModulesModel');
        $display_widget = $modules_model->displayWidget($account->id, $module);

        $_SESSION['alert'] = $display_widget;
        header('location: ' . URL . 'modules/view/' . $module);
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'modules/view/' . $module);
    }
  }

  // Hide Widget
  public function hideWidget($module) {
    if(isset($module) && $module != null) {
      $account = $this->getSessionAccount();

      if($account != null) {
        $modules_model = $this->loadModel('ModulesModel');
        $hide_widget = $modules_model->hideWidget($account->id, $module);

        $_SESSION['alert'] = $hide_widget;
        header('location: ' . URL . 'modules/view/' . $module);
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'modules/view/' . $module);
    }
  }

  // Pin Module
  public function pinModule($module) {
    if(isset($module) && $module != null) {
      $account = $this->getSessionAccount();

      if($account != null) {
        $modules_model = $this->loadModel('ModulesModel');
        $pin_module = $modules_model->pinModule($account->id, $module);

        $_SESSION['alert'] = $pin_module;
        header('location: ' . URL . 'modules/view/' . $module);
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'modules/view/' . $module);
    }
  }

  // Unpin Module
  public function unpinModule($module) {
    if(isset($module) && $module != null) {
      $account = $this->getSessionAccount();

      if($account != null) {
        $modules_model = $this->loadModel('ModulesModel');
        $unpin_module = $modules_model->unpinModule($account->id, $module);

        $_SESSION['alert'] = $unpin_module;
        header('location: ' . URL . 'modules/view/' . $module);
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'modules/view/' . $module);
    }
  }

  // Execute Module Action
  public function executeModuleAction($module, $action, $value = null) {
    $account = $this->getSessionAccount();

    if($account != null) {
      $modules_model = $this->loadModel('ModulesModel');
      $modules_model->executeModuleAction($module, $action, $value);
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Install Module
  public function installModule() {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_install_module'])) {
        if(!empty($_FILES['module']) && $_FILES['module']['size'] != 0) {
          $modules_model = $this->loadModel('ModulesModel');

          $install_module = $modules_model->installModule($account->id, $_FILES['module']);

          if(isset($install_module) && $install_module != null) {
            $_SESSION['alert'] = $install_module;
            header('location: ' . URL . 'modules');
          }
        } else {
          $_SESSION['alert'] = 'Please choose a module archive to install.';
          header('location: ' . URL . 'modules');
        }
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Delete Module
  public function deleteModule($module) {
    $account = $this->getSessionAccount();

    if($account != null) {
      $modules_model = $this->loadModel('ModulesModel');

      $delete_module = $modules_model->deleteModule($account->id, $module);

      if(isset($delete_module) && $delete_module != null) {
        $_SESSION['alert'] = $delete_module;
        header('location: ' . URL . 'modules');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

}

?>