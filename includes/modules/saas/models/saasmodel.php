<?php

class SaasModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Get Plans
  public function getPlans($admin_id, $public = true) {
    $admin_id = strip_tags($admin_id);

    if($public == false) {
      $sql = 'SELECT * FROM luxx_saas_plans WHERE admin_id = :admin_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':admin_id' => $admin_id));
    } else {
      $sql = 'SELECT * FROM luxx_saas_plans WHERE admin_id = :admin_id AND admin_only = :admin_only';
      $query = $this->db->prepare($sql);
      $query->execute(array(':admin_id' => $admin_id, ':admin_only' => 0));
    }

    return $query->fetchAll();
  }

  // Get Plan Data
  public function getPlanData($plan_id) {
    $plan_id = strip_tags($plan_id);

    $sql = 'SELECT * FROM luxx_saas_plans WHERE id = :plan_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':plan_id' => $plan_id));

    return $query->fetch();
  }

  // Get Account Plan
  public function getAccountPlan($account_id) {
    $sql = 'SELECT * FROM luxx_saas_accounts_plans A, luxx_saas_plans P WHERE A.plan_id = P.id AND A.account_id = :account_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id));

    return $query->fetch();
  }

  // Has Account Plan Active
  public function hasAccountPlanActive($account_id) {
    $sql = 'SELECT * FROM luxx_saas_accounts_plans A, luxx_saas_plans P WHERE A.plan_id = P.id AND A.account_id = :account_id AND DATE(A.next_payment) >= DATE(NOW())';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id));
    $result = $query->fetch();

    if($result != null) {
      return true;
    } else {
      return false;
    }
  }

  // Add Plan
  public function addPlan($admin_id, $admin_only, $plan_title, $monthly_price, $max_contacts, $max_projects, $max_invoices, $max_categories, $max_project_tasks, $max_project_workers, $max_project_attachments, $max_invoice_items, $feature_kanban_board, $feature_email_invoice, $feature_download_pdf) {
    if(!empty($admin_id) && !empty($plan_title) && isset($monthly_price) && isset($max_contacts) && isset($max_projects) && isset($max_invoices) && isset($max_categories) && isset($max_project_tasks) && isset($max_project_workers) && isset($max_project_attachments) && isset($max_invoice_items)) {
      $admin_id = strip_tags($admin_id);
      $plan_title = strip_tags($plan_title);
      $monthly_price = strip_tags($monthly_price);
      $max_contacts = strip_tags($max_contacts);
      $max_projects = strip_tags($max_projects);
      $max_invoices = strip_tags($max_invoices);
      $max_categories = strip_tags($max_categories);
      $max_project_tasks = strip_tags($max_project_tasks);
      $max_project_workers = strip_tags($max_project_workers);
      $max_project_attachments = strip_tags($max_project_attachments);
      $max_invoice_items = strip_tags($max_invoice_items);
      $feature_kanban_board = (strip_tags($feature_kanban_board) == true ? 1 : 0);
      $feature_email_invoice = (strip_tags($feature_email_invoice) == true ? 1 : 0);
      $feature_download_pdf = (strip_tags($feature_download_pdf) == true ? 1 : 0);
      $admin_only = (strip_tags($admin_only) == true ? 1 : 0);

      $sql = 'INSERT INTO luxx_saas_plans (admin_id, admin_only, title, monthly_price, max_contacts, max_projects, max_invoices, max_categories, max_project_tasks, max_project_workers, max_project_attachments, max_invoice_items, feature_kanban_board, feature_email_invoice, feature_download_pdf) VALUES (:admin_id, :plan_admin_only, :plan_title, :plan_monthly_price, :plan_max_contacts, :plan_max_projects, :plan_max_invoices, :plan_max_categories, :plan_max_project_tasks, :plan_max_project_workers, :plan_max_project_attachments, :plan_max_invoice_items, :plan_feature_kanban_board, :plan_feature_email_invoice, :plan_feature_download_pdf)';
      $query = $this->db->prepare($sql);
      $query->execute(array(':admin_id' => $admin_id, ':plan_admin_only' => $admin_only, ':plan_title' => $plan_title, ':plan_monthly_price' => $monthly_price, ':plan_max_contacts' => $max_contacts, ':plan_max_projects' => $max_projects, ':plan_max_invoices' => $max_invoices, ':plan_max_categories' => $max_categories, ':plan_max_project_tasks' => $max_project_tasks, ':plan_max_project_workers' => $max_project_workers, ':plan_max_project_attachments' => $max_project_attachments, ':plan_max_invoice_items' => $max_invoice_items, ':plan_feature_kanban_board' => $feature_kanban_board, ':plan_feature_email_invoice' => $feature_email_invoice, ':plan_feature_download_pdf' => $feature_download_pdf));

      return 'The plan has been added.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Get SaaS Include
  public function getSaasInclude($account_id, $plan_include) {
    $account_id = strip_tags($account_id);
    $plan_include = strip_tags($plan_include);

    $sql_account_plan = 'SELECT * FROM luxx_saas_accounts_plans WHERE account_id = :account_id';
    $query_account_plan = $this->db->prepare($sql_account_plan);
    $query_account_plan->execute(array(':account_id' => $account_id));
    $account_plan = $query_account_plan->fetch()->plan_id;

    $sql_plan = 'SELECT * FROM luxx_saas_plans WHERE id = :plan_id';
    $query_plan = $this->db->prepare($sql_plan);
    $query_plan->execute(array(':plan_id' => $account_plan));
    $plan_data = $query_plan->fetch();

    return $plan_data->$plan_include;
  }

  // Upgrade Plan
  public function upgradePlan($account_id, $plan_id) {
    if(!empty($account_id) && !empty($plan_id)) {
      $account_id = strip_tags($account_id);
      $plan_id = strip_tags($plan_id);

      $sql_current_plan = 'SELECT * FROM luxx_saas_accounts_plans WHERE account_id = :account_id';
      $query_current_plan = $this->db->prepare($sql_current_plan);
      $query_current_plan->execute(array(':account_id' => $account_id));
      $current_plan = $query_current_plan->fetch();

      $date = date_create();
      $last_payment = date_format($date, 'Y-m-d');
      $add_date = date_add($date, date_interval_create_from_date_string('30 days'));
      $next_payment = date_format($add_date, 'Y-m-d');

      $sql_upgrade = 'UPDATE luxx_saas_accounts_plans SET plan_id = :plan_id, last_payment = :last_payment, next_payment = :next_payment WHERE account_id = :account_id';
      $query_upgrade = $this->db->prepare($sql_upgrade);
      $query_upgrade->execute(array(':plan_id' => $plan_id, ':last_payment' => $last_payment, ':next_payment' => $next_payment, ':account_id' => $account_id));

      return 'The plan has been upgraded.';
    } else {
      return 'Some of the fields are empty.';
    }
  }

}

?>
