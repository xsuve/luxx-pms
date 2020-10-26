<?php

class Notifications extends Controller {

  public function index() {
    header('location: ' . URL . 'dashboard');
  }

  // Mark Viewed Notification
  public function markViewedNotification($notification_id) {
  	$notifications_model = $this->loadModel('NotificationsModel');
    $notifications_model->markViewedNotification($notification_id);
  }
    
}

?>