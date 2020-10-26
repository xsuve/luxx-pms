<?php

class Contacts extends Controller {

  public function index() {
    $account = $this->getSessionAccount();

    if($account != null) {
      $contacts_model = $this->loadModel('ContactsModel');
      $contacts = $contacts_model->getAccountContacts($account->id);
      $pinned_contacts = $contacts_model->getAccountPinnedContacts($account->id);

      $categories_model = $this->loadModel('CategoriesModel');

      require 'application/views/_templates/header.php';
      require 'application/views/_templates/topbar.php';
      require 'application/views/_templates/sidebar.php';
      require 'application/views/_templates/alerts.php';
      require 'application/views/contacts/index.php';
      require 'application/views/_templates/footer.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // View
  public function view($id = null) {
    if(isset($id) && $id != null) {
      $account = $this->getSessionAccount();

      if($account != null) {
        $contacts_model = $this->loadModel('ContactsModel');
        $contact = $contacts_model->getContactData($id);

        if($contact != false) {
          $contact_projects = $contacts_model->getContactWorkerProjects($id);

          $categories_model = $this->loadModel('CategoriesModel');
          $contact_category = $categories_model->getCategoryData($contact->category_id);

          $projects_model = $this->loadModel('ProjectsModel');
          $projects = $projects_model->getAccountProjects($account->id);

          require 'application/views/_templates/header.php';
          require 'application/views/_templates/topbar.php';
          require 'application/views/_templates/sidebar.php';
          require 'application/views/_templates/alerts.php';
          require 'application/views/contacts/view.php';
          require 'application/views/_templates/footer.php';
        } else {
          $_SESSION['alert'] = 'That contact does not exist.';
          header('location: ' . URL . 'contacts');
        }
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'contacts');
    }
  }

  // Add
  public function add() {
    $account = $this->getSessionAccount();
    $admin = $this->getAdminAccount();

    if($account != null) {
      require 'application/views/_templates/header.php';

      $modules_model = $this->loadModel('ModulesModel');
      if($modules_model->moduleInstalled('saas')) {
        $module_model = $this->loadModuleModel('saas', 'SaasModel');
        $plans = $module_model->getPlans($admin->id, true);
        $account_plan = $module_model->getAccountPlan($account->id);

        $contacts_model = $this->loadModel('ContactsModel');
        $contacts = $contacts_model->getAccountContacts($account->id);

        if(count($contacts) >= $module_model->getSaasInclude($account->id, 'max_contacts')) {
          $_SESSION['saas_title'] = 'You have exceeded the number of maximum contacts.';
          $_SESSION['saas_close_link'] = 'contacts';
          $_SESSION['saas_from_link'] = 'contacts';

          require 'includes/modules/saas/views/_templates/header.php';
          require 'includes/modules/saas/views/_templates/popbox.php';
        } else {
          $categories_model = $this->loadModel('CategoriesModel');
          $contact_categories = $categories_model->getAccountCategories($account->id, 'contact');

          require 'application/views/_templates/topbar.php';
          require 'application/views/_templates/sidebar.php';
          require 'application/views/_templates/alerts.php';
          require 'application/views/contacts/add.php';
        }
      } else {
        $categories_model = $this->loadModel('CategoriesModel');
        $contact_categories = $categories_model->getAccountCategories($account->id, 'contact');

        require 'application/views/_templates/topbar.php';
        require 'application/views/_templates/sidebar.php';
        require 'application/views/_templates/alerts.php';
        require 'application/views/contacts/add.php';
      }

      require 'application/views/_templates/footer.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Edit
  public function edit($id = null) {
    if(isset($id) && $id != null) {
      $account = $this->getSessionAccount();

      if($account != null) {
        $contacts_model = $this->loadModel('ContactsModel');
        $contact = $contacts_model->getContactData($id);

        if($contact != false) {
          $categories_model = $this->loadModel('CategoriesModel');
          $contact_categories = $categories_model->getAccountCategories($account->id, 'contact');

          require 'application/views/_templates/header.php';
          require 'application/views/_templates/topbar.php';
          require 'application/views/_templates/sidebar.php';
          require 'application/views/_templates/alerts.php';
          require 'application/views/contacts/edit.php';
          require 'application/views/_templates/footer.php';
        } else {
          $_SESSION['alert'] = 'That contact does not exist.';
          header('location: ' . URL . 'contacts');
        }
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'contacts');
    }
  }

  // Add Contact
  public function addContact() {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_add_contact'])) {
        $contacts_model = $this->loadModel('ContactsModel');
        $add_contact = $contacts_model->addContact($account->id, $_POST['contact_category_id'], $_POST['contact_name'], $_POST['contact_email'], $_POST['contact_phone'], $_POST['contact_address'], $_POST['company_details'], $_FILES['contact_image']);
        if(isset($add_contact) && $add_contact != null) {
          $_SESSION['alert'] = $add_contact;
          header('location: ' . URL . 'contacts/add');
        }

        header('location: ' . URL . 'contacts/add');
      } else {
        header('location: ' . URL . 'contacts');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Add To Project
  public function addToProject() {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_add_to_project'])) {
        $contacts_model = $this->loadModel('ContactsModel');
        $add_to_project = $contacts_model->addToProject($account->id, $_POST['contact_id'], $_POST['project_id'], $_POST['work_hours'], $_POST['price_per_hour']);
        if(isset($add_to_project) && $add_to_project != null) {
          $_SESSION['alert'] = $add_to_project;
          header('location: ' . URL . 'contacts/view/' . $_POST['contact_id']);
        }

        header('location: ' . URL . 'contacts/view/' . $_POST['contact_id']);
      } else {
        header('location: ' . URL . 'projects');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Edit Contact
  public function editContact($contact_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_edit_contact'])) {
        $contacts_model = $this->loadModel('ContactsModel');
        $edit_contact = $contacts_model->editContact($contact_id, $_POST['contact_category_id'], $_POST['contact_name'], $_POST['contact_email'], $_POST['contact_phone'], $_POST['contact_address'], $_POST['company_details'], $_FILES['contact_image']);
        if(isset($edit_contact) && $edit_contact != null) {
          $_SESSION['alert'] = $edit_contact;
          header('location: ' . URL . 'contacts/edit/' . $contact_id);
        }

        header('location: ' . URL . 'contacts/edit/' . $contact_id);
      } else {
        header('location: ' . URL . 'contacts');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Pin Contact
  public function pinContact($contact_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($contact_id) && $contact_id != null) {
        $contacts_model = $this->loadModel('ContactsModel');
        $contact_data = $contacts_model->getContactData($contact_id);

        if($contact_data != false) {
          if($contact_data->account_id == $account->id) {
            $pin_contact = $contacts_model->pinContact($contact_id);
            if(isset($pin_contact) && $pin_contact != null) {
              $_SESSION['alert'] = $pin_contact;
              header('location: ' . URL . 'contacts/view/' . $contact_id);
            }

            header('location: ' . URL . 'contacts/view/' . $contact_id);
          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'contacts');
          }
        } else {
          $_SESSION['alert'] = 'That contact does not exist.';
          header('location: ' . URL . 'contacts');
        }
      } else {
        header('location: ' . URL . 'contacts');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Unpin Contact
  public function unpinContact($contact_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($contact_id) && $contact_id != null) {
        $contacts_model = $this->loadModel('ContactsModel');
        $contact_data = $contacts_model->getContactData($contact_id);

        if($contact_data != false) {
          if($contact_data->account_id == $account->id) {
            $unpin_contact = $contacts_model->unpinContact($contact_id);
            if(isset($unpin_contact) && $unpin_contact != null) {
              $_SESSION['alert'] = $unpin_contact;
              header('location: ' . URL . 'contacts/view/' . $contact_id);
            }

            header('location: ' . URL . 'contacts/view/' . $contact_id);
          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'contacts');
          }
        } else {
          $_SESSION['alert'] = 'That contact does not exist.';
          header('location: ' . URL . 'contacts');
        }
      } else {
        header('location: ' . URL . 'contacts');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Delete Contact
  public function deleteContact($contact_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($contact_id) && $contact_id != null) {
        $contacts_model = $this->loadModel('ContactsModel');
        $contact_data = $contacts_model->getContactData($contact_id);

        if($contact_data != false) {
          if($contact_data->account_id == $account->id) {
            $delete_contact = $contacts_model->deleteContact($account->id, $contact_id);
            if(isset($delete_contact) && $delete_contact != null) {
              $_SESSION['alert'] = $delete_contact;
              header('location: ' . URL . 'contacts');
            }

            header('location: ' . URL . 'contacts');
          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'contacts');
          }
        } else {
          $_SESSION['alert'] = 'That contact does not exist.';
          header('location: ' . URL . 'contacts');
        }
      } else {
        header('location: ' . URL . 'contacts');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

}

?>
