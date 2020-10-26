<?php

class Crypto extends Controller {

    // Box
  public function index() {
    $account = $this->getSessionAccount();

    if($account != null) {
      require 'includes/modules/crypto/views/_templates/header.php';
      require 'includes/modules/crypto/views/_templates/box.php';
    } else {
        header('location: ' . URL . 'login');
    }
  }

  // View
  public function view() {
    $account = $this->getSessionAccount();

    if($account != null) {
      $module_model = $this->loadModuleModel('crypto', 'CryptoModel');
      
      require 'includes/modules/crypto/views/_templates/header.php';
      require 'includes/modules/crypto/views/index.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

    // Load Widget
    public function loadWidget() {
        $account = $this->getSessionAccount();

        if($account != null) {
            $module_model = $this->loadModuleModel('crypto', 'CryptoModel');

            require 'includes/modules/crypto/views/_templates/header.php';
            require 'includes/modules/crypto/views/_templates/widget.php';
        } else {
            header('location: ' . URL . 'login');
        }
    }

    // Add Cryptocurrency
    public function addCryptocurrency() {
        $account = $this->getSessionAccount();

        if($account != null) {
            if(isset($_POST['submit_add_cryptocurrency'])) {
                $module_model = $this->loadModuleModel('crypto', 'CryptoModel');
                $add_cryptocurrency = $module_model->addCryptocurrency($account->id, $_POST['cryptocurrency'], $_POST['amount']);
                if(isset($add_cryptocurrency) && $add_cryptocurrency != null) {
                    $_SESSION['alert'] = $add_cryptocurrency;
                    header('location: ' . URL . 'modules');
                }

                header('location: ' . URL . 'modules');
            }
        } else {
            header('location: ' . URL . 'login');
        }
    }

    // Delete Cryptocurrency
    public function deleteCryptocurrency($cryptocurrency_id) {
        $account = $this->getSessionAccount();
        
        if($account != null) {
            if(isset($cryptocurrency_id)) {
                $module_model = $this->loadModuleModel('crypto', 'CryptoModel');

                $reminder_data = $module_model->getReminderData($cryptocurrency_id);
                if($reminder_data->account_id == $account->id) {
                    $delete_reminder = $module_model->deleteReminder($cryptocurrency_id);
                    if(isset($delete_reminder) && $delete_reminder != null) {
                        $_SESSION['alert'] = $delete_reminder;
                        header('location: ' . URL . 'modules');
                    }

                    header('location: ' . URL . 'modules');
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