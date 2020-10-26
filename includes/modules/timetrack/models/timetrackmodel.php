<?php

class TimetrackModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Get Account Tracked Times
  public function getAccountTrackedTimes($account_id, $limit = null) {
    $account_id = strip_tags($account_id);

    if($limit != null) {
      $sql = 'SELECT * FROM luxx_timetrack WHERE account_id = :account_id LIMIT ' . $limit;
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    } else {
      $sql = 'SELECT * FROM luxx_timetrack WHERE account_id = :account_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    }

    return $query->fetchAll();
  }

  // Start New Timer
  public function startNewTimer($account_id, $tracked_time_title, $project_id, $start_from) {
    if(!empty($account_id) && !empty($tracked_time_title)) {
      $account_id = strip_tags($account_id);
      $tracked_time_title = strip_tags($tracked_time_title);
      $project_id = strip_tags($project_id);
      $start_from = strip_tags($start_from);
      $date = date_create();
      $tracked_time_date = date_format($date, 'Y-m-d');
      $tracked_time = $start_from;

      if(isset($_SESSION['timetrack']) && !empty($_SESSION['timetrack'])) {
        $new_timer = array(
          'account_id' => $account_id,
          'tracked_time_date' => $tracked_time_date,
          'title' => $tracked_time_title,
          'tracked_time' => $tracked_time
        );
        array_push($_SESSION['timetrack'], $new_timer);
      } else {
        $_SESSION['timetrack'] = array(
          '0' => array(
            'account_id' => $account_id,
            'tracked_time_date' => $tracked_time_date,
            'title' => $tracked_time_title,
            'tracked_time' => $tracked_time
          )
        );
      }

      // $sql = 'INSERT INTO luxx_timetrack (account_id, project_id, tracked_time_date, title, tracked_time) VALUES (:account_id, :project_id, :tracked_time_date, :tracked_time_title, :tracked_time)';
      // $query = $this->db->prepare($sql);
      // $query->execute(array(':account_id' => $account_id, ':project_id' => $project_id, ':tracked_time_date' => $tracked_time_date, ':tracked_time_title' => $tracked_time_title, ':tracked_time' => $tracked_time));

      return 'A new time track timer has been started.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Add Timer Time
  public function addTimerTime($id) {
    if(!empty($id)) {
      $id = strip_tags($id);

      if(isset($_SESSION['timetrack']) && !empty($_SESSION['timetrack'])) {
        $current_time = $_SESSION['timetrack'][$id]['tracked_time'];
        $_SESSION['timetrack'][$id]['tracked_time'] = $current_time + 1;

        return 'Success';
      }
    } else {
      return 'No timer id provided.';
    }
  }

  public function formatTimerHours($time, $format = '%2d:%02d') {
    if($time < 1) {
      return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
  }

}

?>
