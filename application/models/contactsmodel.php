<?php

class ContactsModel {
    
  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Account Contacts
  public function getAccountContacts($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT * FROM luxx_contacts WHERE account_id = :account_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id));

    return $query->fetchAll();
  }

  // Account Pinned Contacts
  public function getAccountPinnedContacts($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT * FROM luxx_contacts WHERE account_id = :account_id AND pinned = :pinned';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id, ':pinned' => 1));

    return $query->fetchAll();
  }

  // Get Contact Data
  public function getContactData($contact_id) {
    $contact_id = strip_tags($contact_id);

    $sql = 'SELECT * FROM luxx_contacts WHERE id = :contact_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':contact_id' => $contact_id));

    return $query->fetch();
  }

  // Get Contact Projects
  public function getContactProjects($contact_id) {
    $contact_id = strip_tags($contact_id);

    $sql = 'SELECT * FROM luxx_projects_workers WHERE contact_id = :contact_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':contact_id' => $contact_id));

    return $query->fetchAll();
  }

  // Account Projects
  public function getAccountProjects($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT * FROM luxx_projects WHERE account_id = :account_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id));

    return $query->fetchAll();
  }

  // Get Contact Worker Project
  public function getContactWorkerProjects($contact_id) {
    $contact_id = strip_tags($contact_id);

    $sql = 'SELECT * FROM luxx_projects P, luxx_projects_workers W WHERE W.project_id = P.id AND W.contact_id = :contact_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':contact_id' => $contact_id));

    return $query->fetchAll();
  }

  // Get Contact
  public function getContactWorkerTasks($contact_id, $completed = null) {
    $contact_id = strip_tags($contact_id);

    if($completed != null && $completed == true) {
      $completed = strip_tags($completed);
      $sql = 'SELECT * FROM luxx_projects_workers W, luxx_projects_tasks T WHERE T.worker_id = W.id AND W.contact_id = :contact_id AND completed = :completed';
      $query = $this->db->prepare($sql);
      $query->execute(array(':contact_id' => $contact_id, ':completed' => 1));
    } else {
      $sql = 'SELECT * FROM luxx_projects_workers W, luxx_projects_tasks T WHERE T.worker_id = W.id AND W.contact_id = :contact_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':contact_id' => $contact_id));
    }

    return $query->fetchAll();
  }

  // Add Contact
  public function addContact($account_id, $contact_category_id, $contact_name, $contact_email, $contact_phone, $contact_address, $company_details, $contact_image) {
    if(!empty($account_id) && !empty($contact_name) && !empty($contact_email) && !empty($contact_phone) && !empty($contact_address)) {
      $account_id = strip_tags($account_id);
      $contact_category_id = strip_tags($contact_category_id);
      $contact_name = strip_tags($contact_name);
      $contact_email = strip_tags($contact_email);
      $contact_phone = strip_tags($contact_phone);
      $contact_address = strip_tags($contact_address);
      $company_details = ((isset($company_details) && $company_details != '') ? strip_tags($company_details) : '');
      $contact_image = ((isset($contact_image) && $contact_image['size'] != 0) ? $contact_image : '');

      $sql = 'INSERT INTO luxx_contacts (account_id, category_id, name, email, phone_number, address, company_details, pinned) VALUES (:account_id, :contact_category_id, :contact_name, :contact_email, :contact_phone, :contact_address, :company_details, :pinned)';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id, ':contact_category_id' => $contact_category_id, ':contact_name' => $contact_name, ':contact_email' => $contact_email, ':contact_phone' => $contact_phone, ':contact_address' => $contact_address, ':company_details' => $company_details, ':pinned' => 0));

      if($contact_image != '') {
        $last_id = $this->db->lastInsertId();
        if($last_id != 0) {
          $contacts_dir = 'public/application/contacts/';
          $contact_file = $contacts_dir . $last_id . '.png';
          if(!file_exists($contact_file)) {
            if($contact_image['size'] < 500000) {
              if(move_uploaded_file($contact_image['tmp_name'], $contact_file)) {
                return 'Your contact has been added.';
              } else {
                return 'Your contact has not been added.';
              }
            } else {
              return 'The contact image file is too large.';
            }
          } else {
            return 'Contact image with this ID already exists.';
          }
        } else {
          return 'Your contact has not been added - image error.';
        }
      } else {
        return 'Your contact has been added.';
      }
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Add To Project
  public function addToProject($account_id, $contact_id, $project_id, $work_hours, $price_per_hour) {
    if(!empty($account_id) && !empty($contact_id) && !empty($project_id)) {
      $account_id = strip_tags($account_id);
      $contact_id = strip_tags($contact_id);
      $project_id = strip_tags($project_id);
      $work_hours = strip_tags($work_hours);
      $price_per_hour = strip_tags($price_per_hour);

      $sql_check = 'SELECT COUNT(id) AS worker_exists FROM luxx_projects_workers WHERE contact_id = :contact_id AND project_id = :project_id';
      $query_check = $this->db->prepare($sql_check);
      $query_check->execute(array(':contact_id' => $contact_id, ':project_id' => $project_id));
      $worker_exists = $query_check->fetch()->worker_exists;

      if($worker_exists == 0) {
        $sql = 'INSERT INTO luxx_projects_workers (contact_id, project_id, work_hours, price_per_hour) VALUES (:contact_id, :project_id, :work_hours, :price_per_hour)';
        $query = $this->db->prepare($sql);
        $query->execute(array(':contact_id' => $contact_id, ':project_id' => $project_id, ':work_hours' => $work_hours, ':price_per_hour' => $price_per_hour));

        return 'The contact has been added to the project.';
      } else {
        return 'This contact has already been added to the project.';
      }
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Add Invoice
  public function addInvoice($account_id, $contact_id, $contact_name, $contact_email, $contact_address, $contact_phone, $due_date, $vat) {
    if(!empty($account_id) && !empty($contact_id) && !empty($contact_name) && !empty($contact_email) && !empty($contact_address) && !empty($contact_phone) && !empty($due_date)) {
      $account_id = strip_tags($account_id);
      $contact_id = strip_tags($contact_id);
      $contact_name = strip_tags($contact_name);
      $contact_email = strip_tags($contact_email);
      $contact_address = strip_tags($contact_address);
      $contact_phone = strip_tags($contact_phone);
      $due_date = strip_tags($due_date);
      $vat = strip_tags($vat);
      $status = 'unpaid';

      $sql = 'INSERT INTO luxx_invoices (account_id, contact_id, contact_name, contact_email, contact_address, contact_phone, due_date, status, vat) VALUES (:account_id, :contact_id, :contact_name, :contact_email, :contact_address, :contact_phone, :due_date, :status, :vat)';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id, ':contact_id' => $contact_id, ':contact_name' => $contact_name, ':contact_email' => $contact_email, ':contact_address' => $contact_address, ':contact_phone' => $contact_phone, ':due_date' => $due_date, ':status' => $status, ':vat' => $vat));

      return 'The invoice has been created.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Edit Contact
  public function editContact($contact_id, $contact_category_id, $contact_name, $contact_email, $contact_phone, $contact_address, $company_details, $contact_image) {
    if(!empty($contact_id) && !empty($contact_name) && !empty($contact_email) && !empty($contact_phone) && !empty($contact_address)) {
      $contact_id = strip_tags($contact_id);
      $contact_category_id = strip_tags($contact_category_id);
      $contact_name = strip_tags($contact_name);
      $contact_email = strip_tags($contact_email);
      $contact_phone = strip_tags($contact_phone);
      $contact_address = strip_tags($contact_address);
      $company_details = (!empty($company_details) ? $company_details : null);
      $contact_image = ((isset($contact_image) && $contact_image['size'] != 0) ? $contact_image : '');

      if($company_details != null) {
        $sql = 'UPDATE luxx_contacts SET category_id = :contact_category_id, name = :contact_name, email = :contact_email, phone_number = :contact_phone, address = :contact_address company_details = :company_details WHERE id = :contact_id';
        $query = $this->db->prepare($sql);
        $query->execute(array(':contact_id' => $contact_id, ':contact_category_id' => $contact_category_id, ':contact_name' => $contact_name, ':contact_email' => $contact_email, ':contact_phone' => $contact_phone, ':contact_address' => $contact_address, ':company_details' => $company_details));
      } else {
        $sql = 'UPDATE luxx_contacts SET category_id = :contact_category_id, name = :contact_name, email = :contact_email, phone_number = :contact_phone, address = :contact_address WHERE id = :contact_id';
        $query = $this->db->prepare($sql);
        $query->execute(array(':contact_id' => $contact_id, ':contact_category_id' => $contact_category_id, ':contact_name' => $contact_name, ':contact_email' => $contact_email, ':contact_phone' => $contact_phone, ':contact_address' => $contact_address));
      }

      if($contact_image != '') {
        $contacts_dir = 'public/application/contacts/';
        $contact_file = $contacts_dir . $contact_id . '.png';
        if($contact_image['size'] < 500000) {
          if(move_uploaded_file($contact_image['tmp_name'], $contact_file)) {
            return 'Your contact has been updated.';
          } else {
            return 'Your contact has not been updated.';
          }
        } else {
          return 'The contact image file is too large.';
        }
      } else {
        return 'Your contact has been updated.';
      }
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Pin Contact
  public function pinContact($contact_id) {
    $contact_id = strip_tags($contact_id);

    $sql = 'UPDATE luxx_contacts SET pinned = :pinned WHERE id = :contact_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':pinned' => 1, ':contact_id' => $contact_id));

    return 'The contact has been pinned.';
  }

  // Unpin Contact
  public function unpinContact($contact_id) {
    $contact_id = strip_tags($contact_id);

    $sql = 'UPDATE luxx_contacts SET pinned = :pinned WHERE id = :contact_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':pinned' => 0, ':contact_id' => $contact_id));

    return 'The contact has been unpinned.';
  }

  // Delete Contact
  public function deleteContact($account_id, $contact_id) {
    if(!empty($account_id) && !empty($contact_id)) {
      $account_id = strip_tags($account_id);
      $contact_id = strip_tags($contact_id);

      $sql = 'DELETE FROM luxx_contacts WHERE id = :contact_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':contact_id' => $contact_id));

      $this->_deleteContactImage('public/application/contacts/' . $contact_id . '.png');

      $sql_delete_workers = 'DELETE FROM luxx_projects_workers WHERE contact_id = :contact_id';
      $query_delete_workers = $this->db->prepare($sql_delete_workers);
      $query_delete_workers->execute(array(':contact_id' => $contact_id));

      $sql_delete_invoices = 'DELETE FROM luxx_invoices WHERE contact_id = :contact_id';
      $query_delete_invoices = $this->db->prepare($sql_delete_invoices);
      $query_delete_invoices->execute(array(':contact_id' => $contact_id));

      return 'The contact has been deleted.';
    } else {
      return 'No contact id provided.';
    }
  }

  private function _deleteContactImage($file) {
    $_delete_contact_image = unlink($file);

    if($_delete_contact_image == true) {
      return true;
    } else {
      return false;
    }
  }

}

?>