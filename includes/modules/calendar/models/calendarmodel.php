<?php

class CalendarModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Get Account Events
  public function getAccountEvents($account_id, $limit = null) {
    $account_id = strip_tags($account_id);

    if($limit != null) {
      $sql = 'SELECT * FROM luxx_calendar WHERE account_id = :account_id ORDER BY start_date DESC LIMIT ' . $limit;
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    } else {
      $sql = 'SELECT * FROM luxx_calendar WHERE account_id = :account_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    }

    return $query->fetchAll();
  }

  // Get Event Data
  public function getEventData($event_id) {
    $event_id = strip_tags($event_id);

    $sql = 'SELECT * FROM luxx_calendar WHERE id = :event_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':event_id' => $event_id));

    return $query->fetch();
  }

  // Add Event
  public function addEvent($account_id, $event_title, $event_all_day, $event_start_date, $event_end_date, $event_color) {
    if(!empty($account_id) && !empty($event_title) && !empty($event_start_date) && !empty($event_end_date)) {
      $account_id = strip_tags($account_id);
      $event_title = strip_tags($event_title);
      $event_all_day = (strip_tags($event_all_day) == true ? 1 : 0);
      $event_start_date = strip_tags($event_start_date);
      $event_end_date = strip_tags($event_end_date);
      $event_color = strip_tags($event_color);

      $sql = 'INSERT INTO luxx_calendar (account_id, title, all_day, start_date, end_date, color) VALUES (:account_id, :event_title, :event_all_day, :event_start_date, :event_end_date, :event_color)';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id, ':event_title' => $event_title, ':event_all_day' => $event_all_day, ':event_start_date' => $event_start_date, ':event_end_date' => $event_end_date, ':event_color' => $event_color));

      return 'The event has been added.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Edit Event
  public function editEvent($event_id, $event_title, $event_all_day, $event_start_date, $event_end_date, $event_color) {
    if(!empty($event_id) && !empty($event_title) && !empty($event_start_date) && !empty($event_end_date)) {
      $event_id = strip_tags($event_id);
      $event_title = strip_tags($event_title);
      $event_all_day = (strip_tags($event_all_day) == true ? 1 : 0);
      $event_start_date = strip_tags($event_start_date);
      $event_end_date = strip_tags($event_end_date);
      $event_color = strip_tags($event_color);

      $sql = 'UPDATE luxx_calendar SET title = :event_title, all_day = :event_all_day, start_date = :event_start_date, end_date = :event_end_date, color = :event_color WHERE id = :event_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':event_id' => $event_id, ':event_title' => $event_title, ':event_all_day' => $event_all_day, ':event_start_date' => $event_start_date, ':event_end_date' => $event_end_date, ':event_color' => $event_color));

      return 'The event has been edited.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Update Event
  public function updateEvent($event_id, $event_start_date, $event_end_date) {
    if(!empty($event_id) && !empty($event_start_date) && !empty($event_end_date)) {
      $event_id = strip_tags($event_id);
      $event_start_date = date_format(date_create(strip_tags($event_start_date)), 'Y-m-d H:i:s');
      $event_end_date = date_format(date_create(strip_tags($event_end_date)), 'Y-m-d H:i:s');

      $sql = 'UPDATE luxx_calendar SET start_date = :event_start_date, end_date = :event_end_date WHERE id = :event_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':event_id' => $event_id, ':event_start_date' => $event_start_date, ':event_end_date' => $event_end_date));

      return 'The event has been edited.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Delete Event
  public function deleteEvent($event_id) {
    if(!empty($event_id)) {
      $event_id = strip_tags($event_id);

      $sql = 'DELETE FROM luxx_calendar WHERE id = :event_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':event_id' => $event_id));

      return 'The event has been deleted.';
    } else {
      return 'No event id provided.';
    }
  }

}

?>