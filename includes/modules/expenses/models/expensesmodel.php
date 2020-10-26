<?php

class ExpensesModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Get Account Expenses
  public function getAccountExpenses($account_id, $limit = null) {
    $account_id = strip_tags($account_id);

    if($limit != null) {
      $sql = 'SELECT * FROM luxx_expenses WHERE account_id = :account_id ORDER BY expense_date DESC LIMIT ' . $limit;
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    } else {
      $sql = 'SELECT * FROM luxx_expenses WHERE account_id = :account_id ORDER BY expense_date DESC';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    }

    return $query->fetchAll();
  }

  // Get Account Expenses
  public function getAccountExpensesDate($account_id, $date) {
    $account_id = strip_tags($account_id);
    $date = strip_tags($date);

    $sql = 'SELECT * FROM luxx_expenses WHERE account_id = :account_id AND expense_date = :expense_date';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id, ':expense_date' => $date));

    return $query->fetchAll();
  }

  // Get Account Top Expenses
  public function getAccountTopExpenses($account_id, $limit = null) {
    $account_id = strip_tags($account_id);

    if($limit != null) {
      $sql = 'SELECT * FROM luxx_expenses WHERE account_id = :account_id ORDER BY price DESC LIMIT ' . $limit;
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    } else {
      $sql = 'SELECT * FROM luxx_expenses WHERE account_id = :account_id ORDER BY price DESC';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    }

    return $query->fetchAll();
  }

  // Get Expense Data
  public function getExpenseData($expense_id) {
    $expense_id = strip_tags($expense_id);

    $sql = 'SELECT * FROM luxx_expenses WHERE id = :expense_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':expense_id' => $expense_id));

    return $query->fetch();
  }

  // Expenses Value
  public function getExpensesTotal($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT SUM(price) AS expenses_total FROM luxx_expenses WHERE account_id = :account_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id));

    return $query->fetch()->expenses_total;
  }

  // Add Expense
  public function addExpense($account_id, $expense_title, $expense_price, $expense_date, $expense_category) {
    if(!empty($account_id) && !empty($expense_title) && !empty($expense_price) && !empty($expense_date)) {
      $account_id = strip_tags($account_id);
      $expense_title = strip_tags($expense_title);
      $expense_price = strip_tags($expense_price);
      $expense_date = strip_tags($expense_date);
      $expense_category = strip_tags($expense_category);

      $sql = 'INSERT INTO luxx_expenses (account_id, title, price, expense_date, category) VALUES (:account_id, :expense_title, :expense_price, :expense_date, :expense_category)';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id, ':expense_title' => $expense_title, ':expense_price' => $expense_price, ':expense_date' => $expense_date, ':expense_category' => $expense_category));

      return 'The expense has been added.';
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