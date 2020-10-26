<?php

class ModulesModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Get Installed Modules
  public function getInstalledModules($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT * FROM luxx_modules WHERE account_id = :account_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id));
    $account_modules = $query->fetchAll();

    $installed_modules = glob('././includes/modules/*', GLOB_ONLYDIR);

    $modules = [];
    foreach($installed_modules as $installed_module) {
      foreach($account_modules as $account_module) {
        if(basename($installed_module) == $account_module->title) {
          $modules[] = '././includes/modules/' . $account_module->title;
        }
      }
    }

    return $modules;
  }

  // Module Installed
  public function moduleInstalled($module) {
    $module = strip_tags($module);

    $installed_modules = glob('././includes/modules/*', GLOB_ONLYDIR);

    $moduleInstalled = false;

    foreach($installed_modules as $installed_module) {
      if(basename($installed_module) == $module) {
        $moduleInstalled = true;
      }
    }

    return $moduleInstalled;
  }

  // Module Installed Account
  public function moduleInstalledAccount($module, $account_id) {
    $module = strip_tags($module);
    $account_id = strip_tags($account_id);

    $installed_modules = glob('././includes/modules/*', GLOB_ONLYDIR);

    $sql = 'SELECT * FROM luxx_modules WHERE account_id = :account_id AND title = :module_title';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id, ':module_title' => $module));
    $account_modules = $query->fetchAll();

    $moduleInstalledAccount = false;

    foreach($installed_modules as $installed_module) {
      if(count($account_modules) > 0) {
        if(basename($installed_module) == $module) {
          $moduleInstalledAccount = true;
        }
      }
    }

    return $moduleInstalledAccount;
  }

  // Get Pinned Installed Modules
  public function getPinnedInstalledModules($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT * FROM luxx_modules WHERE account_id = :account_id AND pinned = :pinned';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id, ':pinned' => 1));
    $account_modules = $query->fetchAll();

    $installed_modules = glob('././includes/modules/*', GLOB_ONLYDIR);

    $modules = [];
    foreach($installed_modules as $installed_module) {
      foreach($account_modules as $account_module) {
        if(basename($installed_module) == $account_module->title) {
          $modules[] = '././includes/modules/' . $account_module->title;
        }
      }
    }

    return $modules;
  }

  // Load Module
  public function loadModule($module) {
    require_once('././includes/modules/' . $module . '/controller/' . $module . '.php');
    $module = ucfirst($module);
    $module_controller = new $module;

    return $module_controller->index();
  }

  // Load Module View
  public function loadModuleView($module) {
    require_once('././includes/modules/' . $module . '/controller/' . $module . '.php');
    $module = ucfirst($module);
    $module_controller = new $module;

    return $module_controller->view();
  }

  // Load Module Edit
  public function loadModuleEdit($module, $id) {
    require_once('././includes/modules/' . $module . '/controller/' . $module . '.php');
    $module = ucfirst($module);
    $module_controller = new $module;

    return $module_controller->edit($id);
  }

  // Load Module Widget
  public function loadModuleWidget($module) {
    require_once('././includes/modules/' . $module . '/controller/' . $module . '.php');
    $module = ucfirst($module);
    $module_controller = new $module;

    return $module_controller->widget();
  }

  // Get Widget Display Status
  public function getWidgetDisplayStatus($module) {
    $sql = 'SELECT display_widget FROM luxx_modules WHERE title = :title';
    $query = $this->db->prepare($sql);
    $query->execute(array(':title' => $module));

    return $query->fetch();
  }

  // Get Pinned Status
  public function getPinnedStatus($module) {
    $sql = 'SELECT pinned FROM luxx_modules WHERE title = :title';
    $query = $this->db->prepare($sql);
    $query->execute(array(':title' => $module));

    return $query->fetch();
  }

  // Display Widget
  public function displayWidget($account_id, $module) {
    $account_id = strip_tags($account_id);

    $sql = 'UPDATE luxx_modules SET display_widget = :display_widget WHERE account_id = :account_id AND title = :title';
    $query = $this->db->prepare($sql);
    $query->execute(array(':display_widget' => 1, ':account_id' => $account_id, ':title' => $module));

    return 'The module widget has been turned on.';
  }

  // Hide Widget
  public function hideWidget($account_id, $module) {
    $account_id = strip_tags($account_id);

    $sql = 'UPDATE luxx_modules SET display_widget = :display_widget WHERE account_id = :account_id AND title = :title';
    $query = $this->db->prepare($sql);
    $query->execute(array(':display_widget' => 0, ':account_id' => $account_id, ':title' => $module));

    return 'The module widget has been turned off.';
  }

  // Pin Module
  public function pinModule($account_id, $module) {
    $account_id = strip_tags($account_id);

    $sql = 'UPDATE luxx_modules SET pinned = :pinned WHERE account_id = :account_id AND title = :title';
    $query = $this->db->prepare($sql);
    $query->execute(array(':pinned' => 1, ':account_id' => $account_id, ':title' => $module));

    return 'The module has been pinned.';
  }

  // Unpin Module
  public function unpinModule($account_id, $module) {
    $account_id = strip_tags($account_id);

    $sql = 'UPDATE luxx_modules SET pinned = :pinned WHERE account_id = :account_id AND title = :title';
    $query = $this->db->prepare($sql);
    $query->execute(array(':pinned' => 0, ':account_id' => $account_id, ':title' => $module));

    return 'The module has been unpinned.';
  }

  // Execute Module Action
  public function executeModuleAction($module, $action, $value) {
    require_once('././includes/modules/' . $module . '/controller/' . $module . '.php');
    $module = ucfirst($module);
    $module_controller = new $module;
    $module_execute = $module_controller->$action($value);

    return $module_execute;
  }

  // Install Module
  public function installModule($account_id, $module_file) {
    $account_id = strip_tags($account_id);

    $fileType = strtolower(pathinfo(basename($module_file['name']), PATHINFO_EXTENSION));
    if($fileType == 'zip') {
      if(move_uploaded_file($module_file['tmp_name'], '././includes/modules/' . $module_file['name'])) {
        $zip = new ZipArchive;
        $res = $zip->open('././includes/modules/' . $module_file['name']);
        if($res === true) {
          $folderName = trim($zip->getNameIndex(0), '/');
          $zip->extractTo('././includes/modules/');
          $zip->close();
          unlink('././includes/modules/' . $module_file['name']);

          $installFile = include '././includes/modules/' . $folderName . '/install.php';

          if($installFile) {
            foreach($module_database_tables as $module_database_table) {
              $module_table_query = $this->db->prepare($module_database_table);
              $module_table_query->execute();
            }

            foreach($module_database_table_ids as $module_database_table_id) {
              $module_table_id_query = $this->db->prepare($module_database_table_id);
              $module_table_id_query->execute();
            }

            foreach($module_database_table_autoincrements as $module_database_table_autoincrement) {
              $module_table_autoincrement_query = $this->db->prepare($module_database_table_autoincrement);
              $module_table_autoincrement_query->execute();
            }

            $sql = 'INSERT INTO luxx_modules (account_id, title, pinned, display_widget) VALUES (:account_id, :title, :pinned, :display_widget)';
            $query = $this->db->prepare($sql);
            $query->execute(array(':account_id' => $account_id, ':title' => $module_folder_name, ':pinned' => 0, ':display_widget' => 0));

            rename('././includes/modules/' . $folderName, '././includes/modules/' . $module_folder_name);

            return 'The module has been installed.';
          } else {
            return 'Could not open the module installation file.';
          }
        } else {
          return 'Could not open the .zip module archive.';
        }
      }
    } else {
      return 'Please choose a .zip module archive.';
    }
  }

  // Delete Module
  public function deleteModule($account_id, $module) {
    if(!empty($module)) {
      $installFile = include '././includes/modules/' . $module . '/install.php';

      if($installFile) {
        $sql = 'DELETE FROM luxx_modules WHERE title = :title';
        $query = $this->db->prepare($sql);
        $query->execute(array(':title' => $module));

        if(isset($module_database_deletes)) {
          foreach($module_database_deletes as $module_database_delete) {
            $module_delete_query = $this->db->prepare($module_database_delete);
            $module_delete_query->execute();
          }
        }

        $sql_delete = 'DROP TABLE luxx_' . $module;
        $query_delete = $this->db->prepare($sql_delete);
        $query_delete->execute();

        $delete_module = $this->_deleteModule('././includes/modules/' . $module);

        return 'The module has been deleted.';
      } else {
        return 'The module installation file is missing.';
      }
    } else {
      return 'No module has been provided.';
    }
  }

  // Delete Module
  private function _deleteModule($dir) {
    if(is_dir($dir)) {
      $objects = scandir($dir);
      foreach($objects as $object) {
        if($object != '.' && $object != '..') {
          if(filetype($dir . '/' . $object) == 'dir') {
            $this->_deleteModule($dir . '/' . $object);
          } else {
            unlink($dir . '/' . $object);
          }
        }
      }
      reset($objects);
      $_delete_module = rmdir($dir);

      if($_delete_module == true) {
        return true;
      } else {
        return false;
      }
    }
  }

}

?>
