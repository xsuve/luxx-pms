<?php

class ProjectsModel {
    
  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Account Projects
  public function getAccountProjects($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT * FROM luxx_projects WHERE account_id = :account_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id));

    return $query->fetchAll();
  }

  // Account Pinned Projects
  public function getAccountPinnedProjects($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT * FROM luxx_projects WHERE account_id = :account_id AND pinned = :pinned';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id, ':pinned' => 1));

    return $query->fetchAll();
  }

  // Get Project Data
  public function getProjectData($project_id) {
    $project_id = strip_tags($project_id);

    $sql = 'SELECT * FROM luxx_projects WHERE id = :project_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':project_id' => $project_id));

    return $query->fetch();
  }

  // Get Project Task Data
  public function getProjectTaskData($task_id) {
    $task_id = strip_tags($task_id);

    $sql = 'SELECT * FROM luxx_projects_tasks WHERE id = :task_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':task_id' => $task_id));

    return $query->fetch();
  }

  // Get Project Worker Data
  public function getProjectWorkerData($worker_id) {
    $worker_id = strip_tags($worker_id);

    $sql = 'SELECT * FROM luxx_projects_workers WHERE id = :worker_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':worker_id' => $worker_id));

    return $query->fetch();
  }

  // Project Workers
  public function getProjectWorkers($project_id) {
    $project_id = strip_tags($project_id);

    $sql = 'SELECT * FROM luxx_projects_workers WHERE project_id = :project_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':project_id' => $project_id));

    return $query->fetchAll();
  }

  // Worker Contact
  public function getWorkerContact($contact_id) {
    $contact_id = strip_tags($contact_id);

    $sql = 'SELECT * FROM luxx_contacts WHERE id = :contact_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':contact_id' => $contact_id));

    return $query->fetch();
  }

  // Worker Account
  public function getWorkerAccount($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT * FROM luxx_accounts WHERE id = :account_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id));

    return $query->fetch();
  }

  // Get Account Completed Tasks
  public function getAccountCompletedTasks($account_id, $date = null) {
    $account_id = strip_tags($account_id);

    if($date != null) {
      $date = strip_tags($date);

      $sql = 'SELECT * FROM luxx_projects_tasks T, luxx_projects P WHERE completed = :completed AND date_completed = :date_completed AND T.project_id = P.id AND P.account_id = :account_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id, ':completed' => 1, ':date_completed' => $date));
    } else {
      $sql = 'SELECT * FROM luxx_projects_tasks T, luxx_projects P WHERE completed = :completed AND T.project_id = P.id AND P.account_id = :account_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id, ':completed' => 1));
    }

    return $query->fetchAll();
  }

  // Project Tasks
  public function getProjectTasks($project_id) {
    $project_id = strip_tags($project_id);

    $sql = 'SELECT * FROM luxx_projects_tasks WHERE project_id = :project_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':project_id' => $project_id));

    return $query->fetchAll();
  }

  // Project Active Tasks
  public function getProjectActiveTasks($project_id) {
    $project_id = strip_tags($project_id);

    $sql = 'SELECT * FROM luxx_projects_tasks WHERE project_id = :project_id AND completed = :completed';
    $query = $this->db->prepare($sql);
    $query->execute(array(':project_id' => $project_id, ':completed' => 0));

    return $query->fetchAll();
  }

  // Project Completed Tasks
  public function getProjectCompletedTasks($project_id) {
    $project_id = strip_tags($project_id);

    $sql = 'SELECT * FROM luxx_projects_tasks WHERE project_id = :project_id AND completed = :completed';
    $query = $this->db->prepare($sql);
    $query->execute(array(':project_id' => $project_id, ':completed' => 1));

    return $query->fetchAll();
  }

  // Project Total Tasks
  public function getProjectTotalTasks($project_id) {
    $project_id = strip_tags($project_id);

    $sql = 'SELECT COUNT(id) AS project_total_tasks FROM luxx_projects_tasks WHERE project_id = :project_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':project_id' => $project_id));

    return $query->fetch()->project_total_tasks;
  }

  // Project Deadline
  public function formatProjectDeadline($project_deadline, $format) {
    $project_deadline = strip_tags($project_deadline);

    if($project_deadline != 0) {
      $deadline_date = date_create($project_deadline);
      return $deadline_date->format($format);
    } else {
      return '--';
    }
  }

  // Update Task Category
  public function updateTaskCategory($task_id, $category_id) {
    $task_id = strip_tags($task_id);
    $category_id = strip_tags($category_id);

    $sql = 'UPDATE luxx_projects_tasks SET category_id = :category_id WHERE id = :task_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':category_id' => $category_id, ':task_id' => $task_id));

    return $query->fetch();
  }

  // Project Progress
  public function formatProjectProgress($project_completed_tasks, $project_total_tasks) {
    $project_completed_tasks = strip_tags($project_completed_tasks);
    $project_total_tasks = strip_tags($project_total_tasks);

    if($project_total_tasks > 0) {
      if($project_completed_tasks > 0) {
        $progress = round(($project_completed_tasks / $project_total_tasks) * 100);

        return $progress;
      } else {
        return 0;
      }
    } else {
      return 0;
    }
  }

  // Add Project
  public function addProject($account_id, $project_category_id, $project_title, $project_deadline, $project_income) {
    if(!empty($account_id) && !empty($project_title) && !empty($project_deadline) && !empty($project_income)) {
      $account_id = strip_tags($account_id);
      $project_category_id = strip_tags($project_category_id);
      $project_title = strip_tags($project_title);
      $project_deadline = strip_tags($project_deadline);
      $project_income = strip_tags($project_income);

      $sql = 'INSERT INTO luxx_projects (account_id, category_id, title, deadline, income, pinned) VALUES (:account_id, :project_category_id, :project_title, :project_deadline, :project_income, :pinned)';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id, ':project_category_id' => $project_category_id, ':project_title' => $project_title, ':project_deadline' => $project_deadline, ':project_income' => $project_income, ':pinned' => 0));

      return 'The project has been added.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Edit Project
  public function editProject($project_id, $project_category_id, $project_title, $project_deadline, $project_income) {
    if(!empty($project_id) && !empty($project_title) && !empty($project_deadline) && !empty($project_income)) {
      $project_id = strip_tags($project_id);
      $project_category_id = strip_tags($project_category_id);
      $project_title = strip_tags($project_title);
      $project_deadline = strip_tags($project_deadline);
      $project_income = strip_tags($project_income);

      $sql = 'UPDATE luxx_projects SET category_id = :project_category_id, title = :project_title, deadline = :project_deadline, income = :project_income WHERE id = :project_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':project_id' => $project_id, ':project_category_id' => $project_category_id, ':project_title' => $project_title, ':project_deadline' => $project_deadline, ':project_income' => $project_income));

      return 'The project has been edited.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Pin Project
  public function pinProject($project_id) {
    $project_id = strip_tags($project_id);

    $sql = 'UPDATE luxx_projects SET pinned = :pinned WHERE id = :project_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':pinned' => 1, ':project_id' => $project_id));

    return 'The project has been pinned.';
  }

  // Unpin Project
  public function unpinProject($project_id) {
    $project_id = strip_tags($project_id);

    $sql = 'UPDATE luxx_projects SET pinned = :pinned WHERE id = :project_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':pinned' => 0, ':project_id' => $project_id));

    return 'The project has been unpinned.';
  }

  // Get Project Attachments
  public function getProjectAttachments($project_id) {
      $attachments = glob('././public/application/projects/' . $project_id . '/*');

      return $attachments;
  }

  // Add Attachment
  public function addAttachment($project_id, $attachment) {
    if(!empty($project_id) && !empty($attachment)) {
      $project_id = strip_tags($project_id);

      $project_dir = 'public/application/projects/' . $project_id;
      if(file_exists($project_dir)) {
        $attachment_file = $project_dir . '/' . $attachment['name'];
        if(!file_exists($attachment_file)) {
          if($attachment['size'] < ATTACHMENT_MAX_SIZE) {
            if(move_uploaded_file($attachment['tmp_name'], $attachment_file)) {
              return 'Your attachment has been uploaded.';
            } else {
              return 'Your attachment has not been uploaded.';
            }
          } else {
            return 'The attachment size is over ' . ATTACHMENT_MAX_SIZE . ' bytes.';
          }
        } else {
          return 'The attachment already exists.';
        }
      } else {
        mkdir($project_dir, 0777, true);
        $this->addAttachment($project_id, $attachment);
      }
    } else {
      return 'Please choose a file to upload.';
    }
  }

  // Remove Attachment
  public function removeAttachment($project_id, $attachment) {
    if(!empty($project_id) && !empty($attachment)) {
      $project_id = strip_tags($project_id);
      $attachment = strip_tags($attachment);

      $attachment_file = 'public/application/projects/' . $project_id . '/' . $attachment;

      if(file_exists($attachment_file)) {
        unlink($attachment_file);
        
        return 'The attachment has been removed.';
      } else {
        return 'That attachment does not exist.';
      }
    } else {
      return 'No project id or attachment provided.';
    }
  }

  // Add Task
  public function addTask($account_id, $project_id, $task_category_id, $task_worker_id, $task_title) {
    if(!empty($account_id) && !empty($project_id) && !empty($task_title)) {
      $account_id = strip_tags($account_id);
      $project_id = strip_tags($project_id);
      $task_category_id = strip_tags($task_category_id);
      $task_worker_id = ((isset($task_worker_id) && $task_worker_id != '') ? strip_tags($task_worker_id) : 0);
      $task_title = strip_tags($task_title);

      $sql = 'INSERT INTO luxx_projects_tasks (project_id, worker_id, category_id, title, completed, date_completed) VALUES (:project_id, :worker_id, :task_category_id, :task_title, :completed, :date_completed)';
      $query = $this->db->prepare($sql);
      $query->execute(array(':project_id' => $project_id, ':worker_id' => $task_worker_id, ':task_category_id' => $task_category_id, ':task_title' => $task_title, ':completed' => 0, ':date_completed' => date_format(date_create('1970-01-01'), 'Y-m-d')));

      return 'The task has been added to the project.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Kanban Add Task
  public function kanbanAddTask($account_id, $project_id, $task_category_id, $task_worker_id, $task_title) {
    if(!empty($account_id) && !empty($project_id) && !empty($task_title)) {
      $account_id = strip_tags($account_id);
      $project_id = strip_tags($project_id);
      $task_category_id = strip_tags($task_category_id);
      $task_worker_id = ((isset($task_worker_id) && $task_worker_id != '') ? strip_tags($task_worker_id) : 0);
      $task_title = strip_tags($task_title);

      $sql = 'INSERT INTO luxx_projects_tasks (project_id, worker_id, category_id, title, completed, date_completed) VALUES (:project_id, :worker_id, :task_category_id, :task_title, :completed, :date_completed)';
      $query = $this->db->prepare($sql);
      $query->execute(array(':project_id' => $project_id, ':worker_id' => $task_worker_id, ':task_category_id' => $task_category_id, ':task_title' => $task_title, ':completed' => 0, ':date_completed' => date_format(date_create('1970-01-01'), 'Y-m-d')));

      $last_id = $this->db->lastInsertId();
      if($last_id != 0) {
        return $last_id;
      } else {
        return 0;
      }
    } else {
      return 0;
    }
  }

  // Edit Task
  public function editTask($task_id, $task_title, $task_worker_id, $task_category_id) {
    if(!empty($task_id) && !empty($task_title)) {
      $task_id = strip_tags($task_id);
      $task_title = strip_tags($task_title);
      $task_worker_id = ((isset($task_worker_id) && $task_worker_id != '') ? strip_tags($task_worker_id) : 0);
      $task_category_id = strip_tags($task_category_id);

      $sql = 'UPDATE luxx_projects_tasks SET title = :task_title, worker_id = :worker_id, category_id = :task_category_id WHERE id = :task_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':task_id' => $task_id, ':task_title' => $task_title, ':worker_id' => $task_worker_id, ':task_category_id' => $task_category_id));

      return 'The task has been edited.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Complete Task
  public function completeTask($account_id, $task_id) {
    if(!empty($account_id) && !empty($task_id)) {
      $account_id = strip_tags($account_id);
      $task_id = strip_tags($task_id);

      $sql = 'UPDATE luxx_projects_tasks SET completed = :completed, date_completed = :date_completed WHERE id = :task_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':completed' => 1, ':date_completed' => date_format(date_create(), 'Y-m-d'), ':task_id' => $task_id));

      return 'The task has been completed.';
    } else {
      return 'No task id provided.';
    }
  }

  // Activate Task
  public function activateTask($account_id, $task_id) {
    if(!empty($account_id) && !empty($task_id)) {
      $account_id = strip_tags($account_id);
      $task_id = strip_tags($task_id);

      $sql = 'UPDATE luxx_projects_tasks SET completed = :completed, date_completed = :date_completed WHERE id = :task_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':completed' => 0, ':date_completed' => date_format(date_create('1970-01-01'), 'Y-m-d'), ':task_id' => $task_id));

      return 'The task has been activated.';
    } else {
      return 'No task id provided.';
    }
  }

  // Delete Task
  public function deleteTask($account_id, $task_id) {
    if(!empty($account_id) && !empty($task_id)) {
      $account_id = strip_tags($account_id);
      $task_id = strip_tags($task_id);

      $sql = 'DELETE FROM luxx_projects_tasks WHERE id = :task_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':task_id' => $task_id));

      return 'The task has been removed from the project.';
    } else {
      return 'No task id provided.';
    }
  }

  // Edit Worker
  public function editWorker($worker_id, $work_hours, $price_per_hour) {
    if(!empty($worker_id) && !empty($work_hours) && !empty($price_per_hour)) {
      $worker_id = strip_tags($worker_id);
      $work_hours = strip_tags($work_hours);
      $price_per_hour = strip_tags($price_per_hour);

      $sql = 'UPDATE luxx_projects_workers SET work_hours = :work_hours, price_per_hour = :price_per_hour WHERE id = :worker_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':worker_id' => $worker_id, ':work_hours' => $work_hours, ':price_per_hour' => $price_per_hour));

      return 'The worker has been edited.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Delete Worker
  public function deleteWorker($account_id, $worker_id) {
    if(!empty($account_id) && !empty($worker_id)) {
      $account_id = strip_tags($account_id);
      $worker_id = strip_tags($worker_id);

      $sql = 'DELETE FROM luxx_projects_workers WHERE id = :worker_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':worker_id' => $worker_id));

      $sql_task_workers = 'UPDATE luxx_projects_tasks SET worker_id = :new_worker_id WHERE worker_id = :worker_id';
      $query_task_workers = $this->db->prepare($sql_task_workers);
      $query_task_workers->execute(array(':worker_id' => $worker_id, ':new_worker_id' => 0));

      return 'The worker has been removed from the project.';
    } else {
      return 'No worker id provided.';
    }
  }

  // Delete Project
  public function deleteProject($account_id, $project_id) {
    if(!empty($account_id) && !empty($project_id)) {
      $account_id = strip_tags($account_id);
      $project_id = strip_tags($project_id);

      $sql = 'DELETE FROM luxx_projects WHERE id = :project_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':project_id' => $project_id));

      $this->_deleteProjectAttachments('public/application/projects/' . $project_id);

      $sql_delete_tasks = 'DELETE FROM luxx_projects_tasks WHERE project_id = :project_id';
      $query_delete_tasks = $this->db->prepare($sql_delete_tasks);
      $query_delete_tasks->execute(array(':project_id' => $project_id));

      $sql_delete_workers = 'DELETE FROM luxx_projects_workers WHERE project_id = :project_id';
      $query_delete_workers = $this->db->prepare($sql_delete_workers);
      $query_delete_workers->execute(array(':project_id' => $project_id));

      return 'The project has been deleted.';
    } else {
      return 'No project id provided.';
    }
  }

  private function _deleteProjectAttachments($dir) {
    if(is_dir($dir)) {
      $objects = scandir($dir);
      foreach($objects as $object) {
        if($object != '.' && $object != '..') {
          if(filetype($dir . '/' . $object) == 'dir') {
            $this->_deleteProjectAttachments($dir . '/' . $object);
          } else {
            unlink($dir . '/' . $object);
          }
        }
      }
      reset($objects);
      $_delete_project_attachments = rmdir($dir);

      if($_delete_project_attachments == true) {
        return true;
      } else {
        return false;
      }
    }
  }

}

?>