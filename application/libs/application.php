<?php

class Application {
  private $url_controller = null;
  private $url_action = null;
  private $url_parameter_1 = null;
  private $url_parameter_2 = null;
  private $url_parameter_3 = null;
  private $url_parameter_4 = null;
  private $url_parameter_5 = null;

  public function __construct() {
    $this->splitUrl();

    if(file_exists('./application/controller/' . $this->url_controller . '.php')) {
      require './application/controller/' . $this->url_controller . '.php';
      $this->url_controller = new $this->url_controller();

      if(method_exists($this->url_controller, $this->url_action)) {
        if(isset($this->url_parameter_5)) {
          $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2, $this->url_parameter_3, $this->url_parameter_4, $this->url_parameter_5);
        } elseif(isset($this->url_parameter_4)) {
          $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2, $this->url_parameter_3, $this->url_parameter_4);
        } elseif(isset($this->url_parameter_3)) {
          $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2, $this->url_parameter_3);
        } elseif(isset($this->url_parameter_2)) {
          $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2);
        } elseif(isset($this->url_parameter_1)) {
          $this->url_controller->{$this->url_action}($this->url_parameter_1);
        } else {
          $this->url_controller->{$this->url_action}();
        }
      } else {
        $this->url_controller->index();
      }
    } else {
      require './application/controller/home.php';
      $home = new Home();
      $home->index();
    }
  }

  private function splitUrl() {
    if(isset($_GET['url'])) {
      $url = rtrim($_GET['url'], '/');
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url);

      $this->url_controller = (isset($url[0]) ? $url[0] : null);
      $this->url_action = (isset($url[1]) ? $url[1] : null);
      $this->url_parameter_1 = (isset($url[2]) ? $url[2] : null);
      $this->url_parameter_2 = (isset($url[3]) ? $url[3] : null);
      $this->url_parameter_3 = (isset($url[4]) ? $url[4] : null);
      $this->url_parameter_4 = (isset($url[5]) ? $url[5] : null);
      $this->url_parameter_5 = (isset($url[6]) ? $url[6] : null);
    }
  }
  
}

?>