<?php

class NotificationsModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Account Notifications
  public function getAccountNotifications($account_id, $limit = null) {
    $account_id = strip_tags($account_id);

    if($limit != null) {
      $limit = strip_tags($limit);
      $sql = 'SELECT * FROM luxx_notifications WHERE account_id = :account_id ORDER BY notification_date DESC LIMIT ' . $limit;
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    } else {
      $sql = 'SELECT * FROM luxx_notifications WHERE account_id = :account_id ORDER BY notification_date DESC';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    }

    return $query->fetchAll();
  }

  // Has Notifications
  public function hasNotifications($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT COUNT(id) AS total_notifications FROM luxx_notifications WHERE account_id = :account_id AND viewed = :viewed';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id, ':viewed' => 0));

    if($query->fetch()->total_notifications > 0) {
      return true;
    } else {
      return false;
    }
  }

  // Add Notifications
  public function addNotification($account_id, $icon, $title, $notification_date, $location) {
    $account_id = strip_tags($account_id);
    $icon = strip_tags($icon);
    $title = strip_tags($title);
    $notification_date = strip_tags($notification_date);
    $location = strip_tags($location);

    $sql = 'INSERT INTO luxx_notifications (account_id, icon, title, notification_date, location, viewed) VALUES (:account_id, :notification_icon, :notification_title, :notification_date, :notification_location, :viewed)';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id, ':notification_icon' => $icon, ':notification_title' => $title, ':notification_date' => $notification_date, ':notification_location' => $location, ':viewed' => 0));
  }

  // Mark Viewed Notification
  public function markViewedNotification($notification_id) {
    $notification_id = strip_tags($notification_id);

    $sql = 'UPDATE luxx_notifications SET viewed = :viewed WHERE id = :notification_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':viewed' => 1, ':notification_id' => $notification_id));
  }

  // Format Notification Date
  public function formatNotificationDate($date) {
    $date = strip_tags($date);
    $full = false;

    $now = new DateTime;
    $ago = new DateTime($date);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
      'y' => 'year',
      'm' => 'month',
      'w' => 'week',
      'd' => 'day',
      'h' => 'hour',
      'i' => 'minute',
      's' => 'second',
    );
    foreach ($string as $k => &$v) {
      if ($diff->$k) {
        $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
      } else {
        unset($string[$k]);
      }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
  }

}

?>
