<?php

class Categories extends Controller {

  public function index() {
    $account = $this->getSessionAccount();
    $admin = $this->getAdminAccount();

    if($account != null) {
      $categories_model = $this->loadModel('CategoriesModel');
      $categories = $categories_model->getAccountCategories($account->id);

      $modules_model = $this->loadModel('ModulesModel');
      if($modules_model->moduleSaas()) {
        $saas_exceeded = false;
        $module_model = $this->loadModuleModel('saas', 'SaasModel');
        $plans = $module_model->getPlans($admin->id, true);
        $account_plan = $module_model->getAccountPlan($account->id);
        if(count($categories) >= $module_model->getSaasInclude($account->id, 'max_categories')) {
          $saas_exceeded = true;
        }
      }

      require 'application/views/_templates/header.php';
      require 'application/views/_templates/topbar.php';
      require 'application/views/_templates/sidebar.php';
      require 'application/views/_templates/alerts.php';
      require 'application/views/categories/index.php';
      require 'application/views/_templates/footer.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Edit
  public function edit($id = null) {
    if(isset($id) && $id != null) {
      $account = $this->getSessionAccount();

      if(isset($id)) {
        if($account != null) {
          $categories_model = $this->loadModel('CategoriesModel');
          $category = $categories_model->getCategoryData($id);

          if($category != false) {
            require 'application/views/_templates/header.php';
            require 'application/views/_templates/topbar.php';
            require 'application/views/_templates/sidebar.php';
            require 'application/views/_templates/alerts.php';
            require 'application/views/categories/edit.php';
            require 'application/views/_templates/footer.php';
          } else {
            $_SESSION['alert'] = 'That category does not exist.';
            header('location: ' . URL . 'categories');
          }
        } else {
          header('location: ' . URL . 'login');
        }
      } else {
        header('location: ' . URL . 'categories');
      }
    } else {
      header('location: ' . URL . 'categories');
    }
  }

  // Add Category
  public function addCategory() {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_add_category'])) {
        $categories_model = $this->loadModel('CategoriesModel');
        $add_category = $categories_model->addCategory($account->id, $_POST['category_title'], $_POST['category_type'], $_POST['category_color']);
        if(isset($add_category) && $add_category != null) {
          $_SESSION['alert'] = $add_category;
          header('location: ' . URL . 'categories');
        }

        header('location: ' . URL . 'categories');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Edit Category
  public function editCategory($category_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($category_id) && $category_id != null) {
        if(isset($_POST['submit_edit_category'])) {
          $categories_model = $this->loadModel('CategoriesModel');
          $edit_category = $categories_model->editCategory($category_id, $_POST['category_title'], $_POST['category_type'], $_POST['category_color']);
          if(isset($edit_category) && $edit_category != null) {
            $_SESSION['alert'] = $edit_category;
            header('location: ' . URL . 'categories/edit/' . $category_id);
          }

          header('location: ' . URL . 'categories/edit/' . $category_id);
        } else {
          header('location: ' . URL . 'categories');
        }
      } else {
        header('location: ' . URL . 'categories');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Delete Category
  public function deleteCategory($category_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($category_id) && $category_id != null) {
        $categories_model = $this->loadModel('CategoriesModel');
        $category_data = $categories_model->getCategoryData($category_id);
        
        if($category_data != false) {
          if($category_data->account_id == $account->id) {
            $delete_category = $categories_model->deleteCategory($category_id);
            if(isset($delete_category) && $delete_category != null) {
              $_SESSION['alert'] = $delete_category;
              header('location: ' . URL . 'categories');
            }

            header('location: ' . URL . 'categories');
          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'categories');
          }
        } else {
          $_SESSION['alert'] = 'That category does not exist.';
          header('location: ' . URL . 'categories');
        }
      } else {
        header('location: ' . URL . 'categories');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

}

?>