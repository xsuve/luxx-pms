<?php

class LogOut extends Controller {

  public function index() {
  	$log_out_model = $this->loadModel('LogOutModel');
    $log_out_model->logoutAccount();

  	header('location: ' . URL);
  }
    
}

?>