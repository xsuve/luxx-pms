<?php

class FeedbackModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Get Feedbacks
  public function getFeedbacks() {
    $sql = 'SELECT * FROM luxx_feedback';
    $query = $this->db->prepare($sql);
    $query->execute();

    return $query->fetchAll();
  }

  // Add Feedback
  public function addFeedback($account_id, $feedback_date, $feedback_category, $feedback_section, $feedback_description) {
    if(!empty($account_id) && !empty($feedback_date) && !empty($feedback_category) && !empty($feedback_section) && !empty($feedback_description)) {
      $account_id = strip_tags($account_id);
      $feedback_date = strip_tags($feedback_date);
      $feedback_category = strip_tags($feedback_category);
      $feedback_section = strip_tags($feedback_section);
      $feedback_description = strip_tags($feedback_description);

      $sql = 'INSERT INTO luxx_feedback (account_id, feedback_date, category, section, description, status) VALUES (:account_id, :feedback_date, :feedback_category, :feedback_section, :feedback_description, :status)';
      $query = $this->db->prepare($sql); 
      $query->execute(array(':account_id' => $account_id, ':feedback_date' => $feedback_date, ':feedback_category' => $feedback_category, ':feedback_section' => $feedback_section, ':feedback_description' => $feedback_description, ':status' => 'To-do'));

      return 'The feedback has been added.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Edit Expense
  public function editExpense($expense_id, $expense_title, $expense_price, $expense_date, $expense_category) {
    if(!empty($expense_id) && !empty($expense_title) && !empty($expense_price) && !empty($expense_date) && !empty($expense_category)) {
      $expense_id = strip_tags($expense_id);
      $expense_title = strip_tags($expense_title);
      $expense_price = strip_tags($expense_price);
      $expense_date = strip_tags($expense_date);
      $expense_category = strip_tags($expense_category);

      $sql = 'UPDATE luxx_expenses SET title = :expense_title, price = :expense_price, expense_date = :expense_date, category = :expense_category WHERE id = :expense_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':expense_id' => $expense_id, ':expense_title' => $expense_title, ':expense_price' => $expense_price, ':expense_date' => $expense_date, ':expense_category' => $expense_category));

      return 'The expense has been edited.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Delete Expense
  public function deleteExpense($expense_id) {
    if(!empty($expense_id)) {
      $expense_id = strip_tags($expense_id);

      $sql = 'DELETE FROM luxx_expenses WHERE id = :expense_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':expense_id' => $expense_id));

      return 'The expense has been deleted.';
    } else {
      return 'No expense id provided.';
    }
  }

}

?>