<?php

class CategoriesModel {
    
  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Account Contacts
  public function getAccountCategories($account_id, $type = null) {
    $account_id = strip_tags($account_id);

    if($type != null) {
      $type = strip_tags($type);
      $sql = 'SELECT * FROM luxx_categories WHERE account_id = :account_id AND type = :type';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id, ':type' => $type));
    } else {
      $sql = 'SELECT * FROM luxx_categories WHERE account_id = :account_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));
    }

    return $query->fetchAll();
  }

  // Get Category Data
  public function getCategoryData($category_id) {
    $category_id = strip_tags($category_id);

    $sql = 'SELECT * FROM luxx_categories WHERE id = :category_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':category_id' => $category_id));

    return $query->fetch();
  }

  // Add Category
  public function addCategory($account_id, $category_title, $category_type, $category_color) {
    if(!empty($account_id) && !empty($category_title) && !empty($category_type) && !empty($category_color)) {
      $account_id = strip_tags($account_id);
      $category_title = strip_tags($category_title);
      $category_type = strip_tags($category_type);
      $category_color = strip_tags($category_color);

      $sql = 'INSERT INTO luxx_categories (account_id, title, type, color) VALUES (:account_id, :category_title, :category_type, :category_color)';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id, ':category_title' => $category_title, ':category_type' => $category_type, ':category_color' => $category_color));

      return 'Your category has been added.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Edit Category
  public function editCategory($category_id, $category_title, $category_type, $category_color) {
    if(!empty($category_id) && !empty($category_title) && !empty($category_type) && !empty($category_color)) {
      $category_id = strip_tags($category_id);
      $category_title = strip_tags($category_title);
      $category_type = strip_tags($category_type);
      $category_color = strip_tags($category_color);

      $sql = 'UPDATE luxx_categories SET type = :category_type, title = :category_title, color = :category_color WHERE id = :category_id';
        $query = $this->db->prepare($sql);
        $query->execute(array(':category_id' => $category_id, ':category_type' => $category_type, ':category_title' => $category_title, ':category_color' => $category_color));

      return 'The category has been updated.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Delete Category
  public function deleteCategory($category_id) {
    if(!empty($category_id)) {
      $category_id = strip_tags($category_id);

      $sql = 'DELETE FROM luxx_categories WHERE id = :category_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':category_id' => $category_id));

      return 'The category has been deleted.';
    } else {
      return 'No category id provided.';
    }
  }

}

?>