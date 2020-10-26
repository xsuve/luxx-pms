<?php

class Controller {
    
  public $db = null;

  function __construct() {
    date_default_timezone_set(TIMEZONE);

    if(!isset($_SESSION['account'])) {
      session_start();
    }
    $this->openDatabaseConnection();
  }

  // Database Connection
  private function openDatabaseConnection() {
    $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
    $this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
  }

  // Session Account
  public function getSessionAccount() {
    if(isset($_SESSION['account']) && $_SESSION['account'] != '') {
      $sql = 'SELECT * FROM luxx_accounts WHERE email = :email';
      $query = $this->db->prepare($sql);
      $query->execute(array(':email' => $_SESSION['account']));

      return $query->fetch();
    }
  }

  // Admin Account
  public function getAdminAccount() {
    $sql = 'SELECT * FROM luxx_accounts WHERE is_admin = :is_admin';
    $query = $this->db->prepare($sql);
    $query->execute(array(':is_admin' => 1));

    return $query->fetch();
  }

  // Base Url
  public function getBaseUrl() {
    $query = $_SERVER['REQUEST_URI'];

    return $query;
  }

  // Load Model
  public function loadModel($model_name) {
    require_once('application/models/' . strtolower($model_name) . '.php');
    return new $model_name($this->db);
  }

  // Load Module Model
  public function loadModuleModel($module, $model_name) {
    require_once('includes/modules/' . $module . '/models/' . strtolower($model_name) . '.php');
    return new $model_name($this->db);
  }

  // Redirect
  public function redirect($url) {
    if(!headers_sent()) {    
      header('location: ' . $url);
      exit;
    } else {  
      echo '<script type="text/javascript">window.location.href="' . $url . '";</script>';
      echo '<noscript><meta http-equiv="refresh" content="0;url=' . $url . '" /></noscript>';
      exit;
    }
  }

  // Print Helper
  public function hprint($data) {
    print "<pre>";
    print_r($data);
    print "</pre>";
  }

}

?>