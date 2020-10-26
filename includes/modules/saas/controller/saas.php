<?php

class Saas extends Controller {

  // Box
  public function index() {
    $account = $this->getSessionAccount();

    if($account != null) {
      require 'includes/modules/saas/views/_templates/header.php';
      require 'includes/modules/saas/views/_templates/box.php';
    } else {
        header('location: ' . URL . 'login');
    }
  }

  // View
  public function view() {
    $account = $this->getSessionAccount();
    $admin = $this->getAdminAccount();

    if($account != null) {
      if($account->id == $admin->id) {
        $modules_model = $this->loadModel('ModulesModel');
        $modules = $modules_model->getInstalledModules($account->id);
        $widget_status = $modules_model->getWidgetDisplayStatus('saas');
        $pinned_status = $modules_model->getPinnedStatus('saas');

        $module_model = $this->loadModuleModel('saas', 'SaasModel');
        $plans = $module_model->getPlans($admin->id, false);
        
        require 'includes/modules/saas/views/_templates/header.php';
        require 'includes/modules/saas/views/index.php';
      } else {
        $_SESSION['alert'] = 'You need to be the admin of the platform to view this module.';
        $this->redirect(URL . 'modules');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Widget
  public function widget() {
    //
  }

  // Add Plan
  public function addPlan() {
    $account = $this->getSessionAccount();
    $admin = $this->getAdminAccount();

    if($account != null) {
      if(isset($_POST['submit_add_plan'])) {
        $module_model = $this->loadModuleModel('saas', 'SaasModel');
        $add_plan = $module_model->addPlan($admin->id, (isset($_POST['admin_only']) ? $_POST['admin_only'] : 0), $_POST['plan_title'], $_POST['monthly_price'], $_POST['max_contacts'], $_POST['max_projects'], $_POST['max_invoices'], $_POST['max_categories'], $_POST['max_project_tasks'], $_POST['max_project_workers'], $_POST['max_project_attachments'], $_POST['max_invoice_items'], (isset($_POST['feature_kanban_board']) ? $_POST['feature_kanban_board'] : 0), (isset($_POST['feature_email_invoice']) ? $_POST['feature_email_invoice'] : 0), (isset($_POST['feature_download_pdf']) ? $_POST['feature_download_pdf'] : 0));
        if(isset($add_plan) && $add_plan != null) {
          $_SESSION['alert'] = $add_plan;
          header('location: ' . URL . 'modules/view/saas');
        }

        header('location: ' . URL . 'modules/view/saas');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }
    
}

?>