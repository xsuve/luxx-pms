<?php

class WalletModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Get Account Priority Card
  public function getAccountPriorityCard($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT * FROM luxx_wallet WHERE account_id = :account_id AND priority = :priority';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id, ':priority' => 1));

    return $query->fetch();
  }

  // Get Account Cards
  public function getAccountCards($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT * FROM luxx_wallet WHERE account_id = :account_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id));

    return $query->fetchAll();
  }

  // Format Card Last Used Date
  public function formatCardLastUsedDate($date) {
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