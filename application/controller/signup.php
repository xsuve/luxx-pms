<?php

class SignUp extends Controller {

  public function index() {
    $account = $this->getSessionAccount();

    if($account != null) {
      header('location: ' . URL . 'dashboard');
    } else {
      require 'application/views/_templates/header.php';
      require 'application/views/_templates/alerts.php';
      require 'application/views/signup/index.php';
      require 'application/views/_templates/footer.php';
    }
  }

  //
  public function plan($plan_title) {
    $modules_model = $this->loadModel('ModulesModel');
    if($modules_model->moduleSaas()) {
      $account = $this->getSessionAccount();
      $plan_title = strip_tags($plan_title);

      if(isset($plan_title) && $plan_title != null) {
        if($account != null) {
          header('location: ' . URL . 'dashboard');
        } else {
          require 'application/views/_templates/header.php';
          require 'application/views/_templates/alerts.php';
          require 'application/views/signup/index.php';
          require 'application/views/_templates/footer.php';
        }
      } else {
        header('location: ' . URL . 'signup');
      }
    } else {
      header('location: ' . URL . 'signup');
    }
  }

  // Sign Up Account
  public function signUpAccount() {
  	if(isset($_POST['sign_up_account'])) {
  		$sign_up_model = $this->loadModel('SignUpModel');
  		$sign_up_account = $sign_up_model->signupAccount($_POST['name'], $_POST['email'], $_POST['phone_number'], $_POST['password'], (isset($_POST['plan_title']) ? $_POST['plan_title'] : null));

      if(isset($sign_up_account) && $sign_up_account != null) {
        $_SESSION['alert'] = $sign_up_account;
        header('location: ' . URL . 'signup');
      } else {
        header('location: ' . URL . 'signup');
      }
  	}
  }
    
}

?>