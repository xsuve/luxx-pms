<?php

class DashboardModel {
    
  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Account Total Income
  public function getAccountTotalIncome($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT SUM(income) AS total_income FROM luxx_projects WHERE account_id = :account_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id));

    return $query->fetch()->total_income;
  }

  // Get Widgets
  public function getAccountModuleWidgets($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT * FROM luxx_modules WHERE account_id = :account_id AND display_widget = TRUE';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id));

    return $query->fetchAll();
  }

  // Account Contacts
  public function getAccountContacts($account_id, $limit = null) {
    $account_id = strip_tags($account_id);

    if($limit != null) {
      $limit = strip_tags($limit);
      $sql = 'SELECT * FROM luxx_contacts WHERE account_id = :account_id ORDER BY id DESC LIMIT ' . $limit;
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    } else {
      $sql = 'SELECT * FROM luxx_contacts WHERE account_id = :account_id ORDER BY id DESC';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    }

    return $query->fetchAll();
  }

  // Account Projects
  public function getAccountProjects($account_id, $limit = null) {
    $account_id = strip_tags($account_id);

    if($limit != null) {
      $sql = 'SELECT * FROM luxx_projects WHERE account_id = :account_id ORDER BY id DESC LIMIT ' . $limit;
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    } else {
      $sql = 'SELECT * FROM luxx_projects WHERE account_id = :account_id ORDER BY id DESC';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    }

    return $query->fetchAll();
  }


  // Account Invoices
  public function getAccountInvoices($account_id, $limit = null) {
    $account_id = strip_tags($account_id);

    if($limit != null) {
      $sql = 'SELECT * FROM luxx_invoices WHERE account_id = :account_id ORDER BY id DESC LIMIT ' . $limit;
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    } else {
      $sql = 'SELECT * FROM luxx_invoices WHERE account_id = :account_id ORDER BY id DESC';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    }

    return $query->fetchAll();
  }

  // Get Invoice Contact Data
  public function getInvoiceContactData($contact_id) {
    $contact_id = strip_tags($contact_id);

    $sql = 'SELECT * FROM luxx_contacts WHERE id = :contact_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':contact_id' => $contact_id));

    return $query->fetch();
  }
  
  // Total Projects Income
  public function getTotalProjectsIncome($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT SUM(income) AS total_income FROM luxx_projects WHERE account_id = :account_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id));

    return $query->fetch()->total_income;
  }

  // Account Total Tasks
  public function getAccountTotalTasks($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT COUNT(T.id) AS total_tasks FROM luxx_projects_tasks T, luxx_projects P WHERE T.project_id = P.id AND P.account_id = :account_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id));

    return $query->fetch()->total_tasks;
  }

  // Active Projects Tasks
  public function getActiveProjectsTasks($project_id) {
    $project_id = strip_tags($project_id);

    $sql = 'SELECT COUNT(id) AS total_active_tasks FROM luxx_projects_tasks WHERE project_id = :project_id AND completed = :completed';
    $query = $this->db->prepare($sql);
    $query->execute(array(':project_id' => $project_id, ':completed' => false));

    return $query->fetch()->total_active_tasks;
  }

  // Completed Projects Tasks
  public function getCompletedProjectsTasks($project_id) {
    $project_id = strip_tags($project_id);

    $sql = 'SELECT COUNT(id) AS total_completed_tasks FROM luxx_projects_tasks WHERE project_id = :project_id AND completed = :completed';
    $query = $this->db->prepare($sql);
    $query->execute(array(':project_id' => $project_id, ':completed' => true));

    return $query->fetch()->total_completed_tasks;
  }

}

?>