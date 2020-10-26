<?php

class Home extends Controller {

  public function index() {
  	$account = $this->getSessionAccount();
  	
  	if($account == null) {
      require 'application/views/_templates/header.php';
      require 'includes/themes/' . THEME . '/_templates/header.php';
      require 'includes/themes/' . THEME . '/index.php';
      require 'application/views/_templates/footer.php';
    } else {
    	header('location: ' . URL . 'dashboard');
    }
  }

}

?>