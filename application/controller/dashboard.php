<?php

class Dashboard extends Controller {

  public function index() {
    $account = $this->getSessionAccount();

    if($account != null) {
      $dashboard_model = $this->loadModel('DashboardModel');
      $projects_model = $this->loadModel('ProjectsModel');
      $contacts_model = $this->loadModel('ContactsModel');
      $invoices_model = $this->loadModel('InvoicesModel');
      $modules_model = $this->loadModel('ModulesModel');
      $categories_model = $this->loadModel('CategoriesModel');
      $notifications_model = $this->loadModel('NotificationsModel');

      // Saas
      if($modules_model->moduleInstalled('saas')) {
        $module_model = $this->loadModuleModel('saas', 'SaasModel');
        $account_plan = $module_model->getAccountPlan($account->id);

        $today = date('Y-m-d H:i:s');
        if($module_model->hasAccountPlanActive($account->id)) {
          //$notifications_model->addNotification($account->id, 'cloud', 'Your current plan has reached the due date.', $today, 'account');
        }
      }

      // Stats
      $total_tasks = $dashboard_model->getAccountTotalTasks($account->id);
      $total_income = $dashboard_model->getAccountTotalIncome($account->id);

      // General
      $contacts = $dashboard_model->getAccountContacts($account->id, 6);
      $projects = $dashboard_model->getAccountProjects($account->id, 4);
      $invoices = $dashboard_model->getAccountInvoices($account->id, 4);
      $income = $dashboard_model->getTotalProjectsIncome($account->id);

      $total_contacts = $dashboard_model->getAccountContacts($account->id);
      $total_projects = $dashboard_model->getAccountProjects($account->id);
      $total_invoices = $dashboard_model->getAccountInvoices($account->id);

      $module_widgets = $dashboard_model->getAccountModuleWidgets($account->id);

      $active_tasks = 0;
      $completed_tasks = 0;

      foreach($projects as $project) {
        $active_tasks += $dashboard_model->getActiveProjectsTasks($project->id);
        $completed_tasks += $dashboard_model->getCompletedProjectsTasks($project->id);
      }

      require 'application/views/_templates/header.php';
      require 'application/views/_templates/topbar.php';
      require 'application/views/_templates/sidebar.php';
      require 'application/views/dashboard/index.php';
      require 'application/views/_templates/footer.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

}

?>
