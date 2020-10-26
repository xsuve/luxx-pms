<?php

class Projects extends Controller {

  public function index() {
    $account = $this->getSessionAccount();

    if($account != NULL) {
      $projects_model = $this->loadModel('ProjectsModel');
      $projects = $projects_model->getAccountProjects($account->id);
      $pinned_projects = $projects_model->getAccountPinnedProjects($account->id);
      $ttotal_completed_tasks = $projects_model->getAccountCompletedTasks($account->id);

      $categories_model = $this->loadModel('CategoriesModel');

      require 'application/views/_templates/header.php';
      require 'application/views/_templates/topbar.php';
      require 'application/views/_templates/sidebar.php';
      require 'application/views/_templates/alerts.php';
      require 'application/views/projects/index.php';
      require 'application/views/_templates/footer.php';
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // View
  public function view($id = null) {
    if(isset($id) && $id != null) {
      $account = $this->getSessionAccount();
      $admin = $this->getAdminAccount();

      if($account != NULL) {
        $projects_model = $this->loadModel('ProjectsModel');
        $project = $projects_model->getProjectData($id);

        if($project != false) {
          $project_workers = $projects_model->getProjectWorkers($id);
          $project_tasks = $projects_model->getProjectTasks($id);

          $categories_model = $this->loadModel('CategoriesModel');
          $project_category = $categories_model->getCategoryData($project->category_id);
          $task_categories = $categories_model->getAccountCategories($account->id, 'task');

          $completed_tasks = $projects_model->getProjectCompletedTasks($id);
          $total_tasks = $projects_model->getProjectTotalTasks($id);

          // Attachments
          $attachments = $projects_model->getProjectAttachments($id);

          $modules_model = $this->loadModel('ModulesModel');
          if($modules_model->moduleInstalled('saas')) {
            $saas_exceeded_tasks = false;
            $saas_exceeded_attachments = false;
            $module_model = $this->loadModuleModel('saas', 'SaasModel');
            $plans = $module_model->getPlans($admin->id, true);
            $account_plan = $module_model->getAccountPlan($account->id);
            if(count($project_tasks) >= $module_model->getSaasInclude($account->id, 'max_project_tasks')) {
              $saas_exceeded_tasks = true;
            }

            if(count($attachments) >= $module_model->getSaasInclude($account->id, 'max_project_attachments')) {
              $saas_exceeded_attachments = true;
            }
          }

          require 'application/views/_templates/header.php';
          require 'application/views/_templates/topbar.php';
          require 'application/views/_templates/sidebar.php';
          require 'application/views/_templates/alerts.php';
          require 'application/views/projects/view.php';
          require 'application/views/_templates/footer.php';
        } else {
          $_SESSION['alert'] = 'That project does not exist.';
          header('location: ' . URL . 'projects');
        }
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'projects');
    }
  }

  // View
  public function kanban($id = null) {
    if(isset($id) && $id != null) {
      $account = $this->getSessionAccount();
      $admin = $this->getAdminAccount();

      if($account != NULL) {
        require 'application/views/_templates/header.php';

        $projects_model = $this->loadModel('ProjectsModel');
        $project = $projects_model->getProjectData($id);
        if($project != false) {

          $modules_model = $this->loadModel('ModulesModel');
          if($modules_model->moduleInstalled('saas')) {
            $module_model = $this->loadModuleModel('saas', 'SaasModel');
            $plans = $module_model->getPlans($admin->id, true);
            $account_plan = $module_model->getAccountPlan($account->id);

            if($module_model->getSaasInclude($account->id, 'feature_kanban_board') != true) {
              $_SESSION['saas_title'] = 'Your plan does not have this feature included.';
              $_SESSION['saas_close_link'] = 'projects/view/' . $project->id;
              $_SESSION['saas_from_link'] = 'projects/view/' . $project->id;

              require 'includes/modules/saas/views/_templates/header.php';
              require 'includes/modules/saas/views/_templates/popbox.php';
            } else {
              $project_workers = $projects_model->getProjectWorkers($id);
              $project_tasks = $projects_model->getProjectTasks($id);

              $categories_model = $this->loadModel('CategoriesModel');
              $project_category = $categories_model->getCategoryData($project->category_id);
              $task_categories = $categories_model->getAccountCategories($account->id, 'task');

              // Attachments
              $attachments = $projects_model->getProjectAttachments($id);

              require 'application/views/_templates/topbar.php';
              require 'application/views/_templates/sidebar.php';
              require 'application/views/_templates/alerts.php';
              require 'application/views/projects/kanban.php';
            }
          }
        } else {
          $_SESSION['alert'] = 'That project does not exist.';
          header('location: ' . URL . 'projects');
        }

        require 'application/views/_templates/footer.php';
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'projects');
    }
  }

  // Update Task Category
  public function updateTaskCategory($task_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($task_id) && $task_id != null) {
        $projects_model = $this->loadModel('ProjectsModel');
        $task_data = $projects_model->getProjectTaskData($task_id);
        $project_data = $projects_model->getProjectData($task_data->project_id);

        if($project_data != false) {
          if($project_data->account_id == $account->id) {
            $update_task_category = $projects_model->updateTaskCategory($task_id, $_POST['category_id']);
            if(isset($update_task_category) && $update_task_category != null) {
              $_SESSION['alert'] = $update_task_category;
              header('location: ' . URL . 'projects');
            }

            header('location: ' . URL . 'projects');
          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'projects');
          }
        } else {
          $_SESSION['alert'] = 'That task does not exist.';
          header('location: ' . URL . 'projects');
        }
      } else {
        header('location: ' . URL . 'projects');
      }
    } else {
      header('location: ' . URL . 'login');
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

        $projects_model = $this->loadModel('ProjectsModel');
        $projects = $projects_model->getAccountProjects($account->id);

        if(count($projects) >= $module_model->getSaasInclude($account->id, 'max_projects')) {
          $_SESSION['saas_title'] = 'You have exceeded the number of maximum projects.';
          $_SESSION['saas_close_link'] = 'projects';
          $_SESSION['saas_from_link'] = 'projects';

          require 'includes/modules/saas/views/_templates/header.php';
          require 'includes/modules/saas/views/_templates/popbox.php';
        } else {
          $categories_model = $this->loadModel('CategoriesModel');
          $project_categories = $categories_model->getAccountCategories($account->id, 'project');

          require 'application/views/_templates/topbar.php';
          require 'application/views/_templates/sidebar.php';
          require 'application/views/_templates/alerts.php';
          require 'application/views/projects/add.php';
        }
      } else {
        $categories_model = $this->loadModel('CategoriesModel');
        $project_categories = $categories_model->getAccountCategories($account->id, 'project');

        require 'application/views/_templates/topbar.php';
        require 'application/views/_templates/sidebar.php';
        require 'application/views/_templates/alerts.php';
        require 'application/views/projects/add.php';
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
        $projects_model = $this->loadModel('ProjectsModel');
        $project = $projects_model->getProjectData($id);

        if($project != false) {
          $categories_model = $this->loadModel('CategoriesModel');
          $project_categories = $categories_model->getAccountCategories($account->id, 'project');

          require 'application/views/_templates/header.php';
          require 'application/views/_templates/topbar.php';
          require 'application/views/_templates/sidebar.php';
          require 'application/views/_templates/alerts.php';
          require 'application/views/projects/edit.php';
          require 'application/views/_templates/footer.php';
        } else {
          $_SESSION['alert'] = 'That project does not exist.';
          header('location: ' . URL . 'projects');
        }
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'projects');
    }
  }

  // Add Project
  public function addProject() {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_add_project'])) {
        $projects_model = $this->loadModel('ProjectsModel');
        $add_project = $projects_model->addProject($account->id, $_POST['project_category_id'], $_POST['project_title'], $_POST['project_deadline'], $_POST['project_income']);
        if(isset($add_project) && $add_project != null) {
          $_SESSION['alert'] = $add_project;
          header('location: ' . URL . 'projects/add');
        }

        header('location: ' . URL . 'projects/add');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Get Project Data
  public function getProjectData($project_id) {
    $projects_model = $this->loadModel('ProjectsModel');
    $project_data = $projects_model->getProjectData($project_id);

    return json_encode($project_data);
  }

  // Edit Project
  public function editProject($project_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_edit_project'])) {
        if(isset($project_id) && $project_id != null) {
          $projects_model = $this->loadModel('ProjectsModel');
          $project_data = $projects_model->getProjectData($project_id);

          if($project_data != false) {
            if($project_data->account_id == $account->id) {
              $edit_project = $projects_model->editProject($project_id, $_POST['project_category_id'], $_POST['project_title'], $_POST['project_deadline'], $_POST['project_income']);
              if(isset($edit_project) && $edit_project != null) {
                $_SESSION['alert'] = $edit_project;
                header('location: ' . URL . 'projects/edit/' . $project_id);
              }

              header('location: ' . URL . 'projects/edit/' . $project_id);
            } else {
              $_SESSION['alert'] = 'You do not have permission to do this.';
              header('location: ' . URL . 'projects');
            }
          } else {
            $_SESSION['alert'] = 'That project does not exist.';
            header('location: ' . URL . 'projects');
          }
        } else {
          header('location: ' . URL . 'projects');
        }
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Pin Project
  public function pinProject($project_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($project_id) && $project_id != null) {
        $projects_model = $this->loadModel('ProjectsModel');
        $project_data = $projects_model->getProjectData($project_id);

        if($project_data != false) {
          if($project_data->account_id == $account->id) {
            $pin_project = $projects_model->pinProject($project_id);
            if(isset($pin_project) && $pin_project != null) {
              $_SESSION['alert'] = $pin_project;
              header('location: ' . URL . 'projects/view/' . $project_id);
            }

            header('location: ' . URL . 'projects/view/' . $project_id);
          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'projects');
          }
        } else {
          $_SESSION['alert'] = 'That project does not exist.';
          header('location: ' . URL . 'projects');
        }
      } else {
        header('location: ' . URL . 'projects');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Unpin Project
  public function unpinProject($project_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($project_id) && $project_id != null) {
        $projects_model = $this->loadModel('ProjectsModel');
        $project_data = $projects_model->getProjectData($project_id);

        if($project_data != false) {
          if($project_data->account_id == $account->id) {
            $unpin_project = $projects_model->unpinProject($project_id);
            if(isset($unpin_project) && $unpin_project != null) {
              $_SESSION['alert'] = $unpin_project;
              header('location: ' . URL . 'projects/view/' . $project_id);
            }

            header('location: ' . URL . 'projects/view/' . $project_id);
          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'projects');
          }
        } else {
          $_SESSION['alert'] = 'That project does not exist.';
          header('location: ' . URL . 'projects');
        }
      } else {
        header('location: ' . URL . 'projects');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Add Attachment
  public function addAttachment() {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_add_attachment'])) {
        $projects_model = $this->loadModel('ProjectsModel');
        $add_attachment = $projects_model->addAttachment($_POST['project_id'], $_FILES['attachment']);
        if(isset($add_attachment) && $add_attachment != null) {
          $_SESSION['alert'] = $add_attachment;
          header('location: ' . URL . 'projects/view/' . $_POST['project_id']);
        }

        header('location: ' . URL . 'projects/view/' . $_POST['project_id']);
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Remove Attachment
  public function removeAttachment($project_id, $attachment) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($project_id) && isset($attachment)) {
        $projects_model = $this->loadModel('ProjectsModel');
        $project_data = $projects_model->getProjectData($project_id);

        if($project_data != false) {
          if($project_data->account_id == $account->id) {
            $remove_attachment = $projects_model->removeAttachment($project_id, $attachment);
            if(isset($remove_attachment) && $remove_attachment != null) {
              $_SESSION['alert'] = $remove_attachment;
              header('location: ' . URL . 'projects/view/' . $project_id);
            }

            header('location: ' . URL . 'projects/view/' . $project_id);
          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'projects');
          }
        } else {
          $_SESSION['alert'] = 'That project does not exist.';
          header('location: ' . URL . 'projects');
        }
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Task
  public function task($id = null) {
    if(isset($id) && $id != null) {
      $account = $this->getSessionAccount();

      if($account != NULL) {
        $projects_model = $this->loadModel('ProjectsModel');
        $task = $projects_model->getProjectTaskData($id);

        if($task != false) {
          $project_workers = $projects_model->getProjectWorkers($task->project_id);

          $categories_model = $this->loadModel('CategoriesModel');
          $task_categories = $categories_model->getAccountCategories($account->id, 'task');

          require 'application/views/_templates/header.php';
          require 'application/views/_templates/topbar.php';
          require 'application/views/_templates/sidebar.php';
          require 'application/views/_templates/alerts.php';
          require 'application/views/projects/task.php';
          require 'application/views/_templates/footer.php';
        } else {
          $_SESSION['alert'] = 'That project task does not exist.';
          header('location: ' . URL . 'projects');
        }
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'projects');
    }
  }

  // Add Task
  public function addTask() {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_add_task'])) {
        $projects_model = $this->loadModel('ProjectsModel');

        $add_task = $projects_model->addTask($account->id, $_POST['project_id'], $_POST['task_category_id'], $_POST['task_worker_id'], $_POST['task_title']);
        if(isset($add_task) && $add_task != null) {
          $_SESSION['alert'] = $add_task;
          header('location: ' . URL . 'projects/view/' . $_POST['project_id']);
        }

        header('location: ' . URL . 'projects/view/' . $_POST['project_id']);
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Kanban Add Task
  public function kanbanAddTask() {
    $account = $this->getSessionAccount();

    if($account != null) {
      $projects_model = $this->loadModel('ProjectsModel');

      $kanban_add_task = $projects_model->kanbanAddTask($account->id, $_POST['project_id'], $_POST['task_category_id'], $_POST['task_worker_id'], $_POST['task_title']);
      echo $kanban_add_task;
    } else {
      echo 0;
    }
  }

  // Edit Task
  public function editTask($task_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($task_id) && $task_id != null) {
        if(isset($_POST['submit_edit_task'])) {
          $projects_model = $this->loadModel('ProjectsModel');
          $task = $projects_model->getProjectTaskData($task_id);

          if($task != false) {
            $edit_task = $projects_model->editTask($task_id, $_POST['task_title'], $_POST['task_worker_id'], $_POST['task_category_id']);
            if(isset($edit_task) && $edit_task != null) {
              $_SESSION['alert'] = $edit_task;
              header('location: ' . URL . 'projects/task/' . $task_id);
            }

            header('location: ' . URL . 'projects/task/' . $task_id);
          } else {
            $_SESSION['alert'] = 'That project task does not exist.';
            header('location: ' . URL . 'projects');
          }
        }
      } else {
        header('location: ' . URL . 'projects');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Complete Task
  public function completeTask($task_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($task_id) && $task_id != null) {
        $projects_model = $this->loadModel('ProjectsModel');
        $project_task_data = $projects_model->getProjectTaskData($task_id);

        if($project_task_data != false) {
          $project_data = $projects_model->getProjectData($project_task_data->project_id);
          if($project_data->account_id == $account->id) {
            $complete_task = $projects_model->completeTask($account->id, $task_id);
            if(isset($complete_task) && $complete_task != null) {
              $_SESSION['alert'] = $complete_task;
              header('location: ' . URL . 'projects/view/' . $project_data->id);
            }

            header('location: ' . URL . 'projects/view/' . $project_data->id);
          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'projects');
          }
        } else {
          $_SESSION['alert'] = 'That project task does not exist.';
          header('location: ' . URL . 'projects');
        }
      } else {
        header('location: ' . URL . 'projects');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Activate Task
  public function activateTask($task_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($task_id) && $task_id != null) {
        $projects_model = $this->loadModel('ProjectsModel');
        $project_task_data = $projects_model->getProjectTaskData($task_id);

        if($project_task_data != false) {
          $project_data = $projects_model->getProjectData($project_task_data->project_id);
          if($project_data->account_id == $account->id) {
            $activate_task = $projects_model->activateTask($account->id, $task_id);
            if(isset($activate_task) && $activate_task != null) {
              $_SESSION['alert'] = $activate_task;
              header('location: ' . URL . 'projects/view/' . $project_data->id);
            }

            header('location: ' . URL . 'projects/view/' . $project_data->id);
          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'projects');
          }
        } else {
          $_SESSION['alert'] = 'That project task does not exist.';
          header('location: ' . URL . 'projects');
        }
      } else {
        header('location: ' . URL . 'projects');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Delete Task
  public function deleteTask($task_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($task_id) && $task_id != null) {
        $projects_model = $this->loadModel('ProjectsModel');
        $project_task_data = $projects_model->getProjectTaskData($task_id);

        if($project_task_data != false) {
          $project_data = $projects_model->getProjectData($project_task_data->project_id);
          if($project_data->account_id == $account->id) {
            $delete_task = $projects_model->deleteTask($account->id, $task_id);
            if(isset($delete_task) && $delete_task != null) {
              $_SESSION['alert'] = $delete_task;
              header('location: ' . URL . 'projects/view/' . $project_data->id);
            }

            header('location: ' . URL . 'projects/view/' . $project_data->id);
          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'projects');
          }
        } else {
          $_SESSION['alert'] = 'That project task does not exist.';
          header('location: ' . URL . 'projects');
        }
      } else {
        header('location: ' . URL . 'projects');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Delete Task
  public function kanbanDeleteTask($task_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($task_id) && $task_id != null) {
        $projects_model = $this->loadModel('ProjectsModel');
        $project_task_data = $projects_model->getProjectTaskData($task_id);

        if($project_task_data != false) {
          $project_data = $projects_model->getProjectData($project_task_data->project_id);
          if($project_data->account_id == $account->id) {
            $delete_task = $projects_model->deleteTask($account->id, $task_id);
            if(isset($delete_task) && $delete_task != null) {
              $_SESSION['alert'] = $delete_task;
              header('location: ' . URL . 'projects/kanban/' . $project_data->id);
            }

            header('location: ' . URL . 'projects/kanban/' . $project_data->id);
          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'projects');
          }
        } else {
          $_SESSION['alert'] = 'That project task does not exist.';
          header('location: ' . URL . 'projects');
        }
      } else {
        header('location: ' . URL . 'projects');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Worker
  public function worker($id = null) {
    if(isset($id) && $id != null) {
      $account = $this->getSessionAccount();

      if($account != NULL) {
        $projects_model = $this->loadModel('ProjectsModel');
        $worker = $projects_model->getProjectWorkerData($id);

        if($worker != false) {
          require 'application/views/_templates/header.php';
          require 'application/views/_templates/topbar.php';
          require 'application/views/_templates/sidebar.php';
          require 'application/views/_templates/alerts.php';
          require 'application/views/projects/worker.php';
          require 'application/views/_templates/footer.php';
        } else {
          $_SESSION['alert'] = 'That project worker does not exist.';
          header('location: ' . URL . 'projects');
        }
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL . 'projects');
    }
  }

  // Edit Worker
  public function editWorker($worker_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_POST['submit_edit_worker'])) {
        $projects_model = $this->loadModel('ProjectsModel');
        $worker = $projects_model->getProjectWorkerData($worker_id);

        if($worker != false) {
          $edit_worker = $projects_model->editWorker($worker_id, $_POST['work_hours'], $_POST['price_per_hour']);
          if(isset($edit_worker) && $edit_worker != null) {
            $_SESSION['alert'] = $edit_worker;
            header('location: ' . URL . 'projects/view/' . $worker->project_id);
          }

          header('location: ' . URL . 'projects/view/' . $worker->project_id);
        } else {
          $_SESSION['alert'] = 'That project worker does not exist.';
          header('location: ' . URL . 'projects');
        }
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Delete Worker
  public function deleteWorker($worker_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($worker_id) && $worker_id != null) {
        $projects_model = $this->loadModel('ProjectsModel');
        $project_worker_data = $projects_model->getProjectWorkerData($worker_id);

        if($project_worker_data != false) {
          $project_data = $projects_model->getProjectData($project_worker_data->project_id);
          if($project_data->account_id == $account->id) {
            $delete_worker = $projects_model->deleteWorker($account->id, $worker_id);
            if(isset($delete_worker) && $delete_worker != null) {
              $_SESSION['alert'] = $delete_worker;
              header('location: ' . URL . 'projects/view/' . $project_data->id);
            }

            header('location: ' . URL . 'projects/view/' . $project_data->id);
          } else {
            $_SESSION['alert'] = 'That project worker does not exist.';
            header('location: ' . URL . 'projects');
          }
        } else {
          $_SESSION['alert'] = 'You do not have permission to do this.';
          header('location: ' . URL . 'projects');
        }
      } else {
        header('location: ' . URL . 'projects');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Delete Project
  public function deleteProject($project_id) {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($project_id) && $project_id != null) {
        $projects_model = $this->loadModel('ProjectsModel');
        $project_data = $projects_model->getProjectData($project_id);

        if($project_data != false) {
          if($project_data->account_id == $account->id) {
            $delete_project = $projects_model->deleteProject($account->id, $project_id);
            if(isset($delete_project) && $delete_project != null) {
              $_SESSION['alert'] = $delete_project;
              header('location: ' . URL . 'projects');
            }

            header('location: ' . URL . 'projects');
          } else {
            $_SESSION['alert'] = 'You do not have permission to do this.';
            header('location: ' . URL . 'projects');
          }
        } else {
          $_SESSION['alert'] = 'That project does not exist.';
          header('location: ' . URL . 'projects');
        }
      } else {
        header('location: ' . URL . 'projects');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

}

?>
