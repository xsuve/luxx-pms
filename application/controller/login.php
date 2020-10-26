<?php

class LogIn extends Controller {

  public function index() {
    $account = $this->getSessionAccount();

    if($account != null) {
      header('location: ' . URL . 'dashboard');
    } else {
      require 'application/views/_templates/header.php';
      require 'application/views/_templates/alerts.php';
      require 'application/views/login/index.php';
      require 'application/views/_templates/footer.php';
    }
  }

  // Forgot
  public function forgot() {
    $account = $this->getSessionAccount();

    if($account != null) {
      header('location: ' . URL . 'dashboard');
    } else {
      require 'application/views/_templates/header.php';
      require 'application/views/_templates/alerts.php';
      require 'application/views/login/forgot.php';
      require 'application/views/_templates/footer.php';
    }
  }

  // Reset
  public function reset($email = null, $token = null) {
    if(isset($email) && $email != null && isset($token) && $token != null) {
      $account = $this->getSessionAccount();

      if($account != null) {
        header('location: ' . URL . 'dashboard');
      } else {
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/alerts.php';
        require 'application/views/login/reset.php';
        require 'application/views/_templates/footer.php';
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Log In Account
  public function logInAccount() {
  	if(isset($_POST['log_in_account'])) {
  		$log_in_model = $this->loadModel('LogInModel');
  		$log_in_account = $log_in_model->loginAccount($_POST['email'], $_POST['password']);
      if(isset($log_in_account) && $log_in_account != null) {
        $_SESSION['alert'] = $log_in_account;
        header('location: ' . URL . 'login');
      } else {
        header('location: ' . URL . 'login');
      }
  	}
  }

  // Forgot Password
  public function forgotPassword() {
    if(isset($_POST['forgot_password'])) {
      $log_in_model = $this->loadModel('LogInModel');
      $forgot_password = $log_in_model->forgotPassword($_POST['email']);
      if(isset($forgot_password) && $forgot_password != null) {
        $_SESSION['alert'] = $forgot_password;
        header('location: ' . URL . 'login');
      } else {
        header('location: ' . URL . 'login');
      }
    }
  }

  // Reset Password
  public function resetPassword() {
    if(isset($_POST['reset_password'])) {
      $log_in_model = $this->loadModel('LogInModel');
      $reset_password = $log_in_model->resetPassword($_POST['email'], $_POST['token'], $_POST['new_password'], $_POST['confirm_new_password']);
      if(isset($reset_password) && $reset_password != null) {
        $_SESSION['alert'] = $reset_password;
        header('location: ' . URL . 'login');
      } else {
        header('location: ' . URL . 'login');
      }
    }
  }

  // Activate Account
  public function activateAccount($email, $activate_token) {
    if(isset($email) && isset($activate_token)) {
      $log_in_model = $this->loadModel('LogInModel');
      $activate_account = $log_in_model->activateAccount($email, $activate_token);

      if(isset($activate_account) && $activate_account != null) {
        $_SESSION['alert'] = $activate_account;
        header('location: ' . URL . 'login');
      }
    }
  }

}

?>