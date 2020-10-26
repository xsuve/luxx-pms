<?php

class Account extends Controller {

  public function index() {
    $account = $this->getSessionAccount();

    if($account != null) {
      $projects_model = $this->loadModel('ProjectsModel');
      $modules_model = $this->loadModel('ModulesModel');

      if($modules_model->moduleInstalled('saas')) {
        $module_model = $this->loadModuleModel('saas', 'SaasModel');
        $account_plan = $module_model->getAccountPlan($account->id);

        $dashboard_model = $this->loadModel('DashboardModel');
        $categories_model = $this->loadModel('CategoriesModel');

        $total_contacts = $dashboard_model->getAccountContacts($account->id);
        $total_projects = $dashboard_model->getAccountProjects($account->id);
        $total_invoices = $dashboard_model->getAccountInvoices($account->id);
        $total_categories = $categories_model->getAccountCategories($account->id);

        $max_contacts = $module_model->getSaasInclude($account->id, 'max_contacts');
        $max_projects = $module_model->getSaasInclude($account->id, 'max_projects');
        $max_invoices = $module_model->getSaasInclude($account->id, 'max_invoices');
        $max_categories = $module_model->getSaasInclude($account->id, 'max_categories');
      }

      require 'application/views/_templates/header.php';
      require 'application/views/_templates/topbar.php';
      require 'application/views/_templates/sidebar.php';
      require 'application/views/_templates/alerts.php';
      require 'application/views/account/index.php';
      require 'application/views/_templates/footer.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Edit
  public function edit() {
    $account = $this->getSessionAccount();

    if($account != null) {
      require 'application/views/_templates/header.php';
      require 'application/views/_templates/topbar.php';
      require 'application/views/_templates/sidebar.php';
      require 'application/views/_templates/alerts.php';
      require 'application/views/account/edit.php';
      require 'application/views/_templates/footer.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Edit Account
  public function editAccount() {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_edit_account'])) {
        $account_model = $this->loadModel('AccountModel');
        $edit_account = $account_model->editAccount($account->id, $_POST['account_phone_number'], $_FILES['account_profile']);

        if(isset($edit_account) && $edit_account != null) {
          $_SESSION['alert'] = $edit_account;
          header('location: ' . URL . 'account/edit');
        }

        header('location: ' . URL . 'account/edit');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Update Password
  public function updatePassword() {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_update_password'])) {
        $account_model = $this->loadModel('AccountModel');
        $update_password = $account_model->updatePassword($account->id, $account->password, $_POST['current_password'], $_POST['new_password'], $_POST['confirm_new_password']);

        if(isset($update_password) && $update_password != null) {
          $_SESSION['alert'] = $update_password;
          header('location: ' . URL . 'account/edit');
        }

        header('location: ' . URL . 'account/edit');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

}

?>
