<?php

class AccountModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Edit Account
  public function editAccount($account_id, $phone_number, $profile) {
    if(!empty($phone_number)) {
      $account_id = strip_tags($account_id);
      $phone_number = strip_tags($phone_number);

      $sql = 'UPDATE luxx_accounts SET phone_number = :phone_number WHERE id = :account_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id, ':phone_number' => $phone_number));

      if(isset($profile) && $profile['size'] != 0) {
        $accounts_dir = 'public/application/accounts/';
        $account_file = $accounts_dir . $account_id . '.png';
        if($profile['size'] < 500000) {
          if(move_uploaded_file($profile['tmp_name'], $account_file)) {
            return 'Your account has been edited.';
          } else {
            return 'Your account has not been edited.';
          }
        } else {
          return 'The profile image file is too large.';
        }
      } else {
        return 'Your account has been edited.';
      }
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Update Password
  public function updatePassword($account_id, $account_password, $current_password, $new_password, $confirm_new_password) {
    if(!empty($current_password) && !empty($new_password) && !empty($confirm_new_password)) {
      $account_id = strip_tags($account_id);
      $current_password = strip_tags($current_password);
      $new_password = strip_tags($new_password);
      $confirm_new_password = strip_tags($confirm_new_password);

      if(password_verify($current_password, $account_password)) {
        if($new_password == $confirm_new_password) {
          $new_password = password_hash(strip_tags($new_password), PASSWORD_DEFAULT);

          $sql = 'UPDATE luxx_accounts SET password = :password WHERE id = :account_id';
          $query = $this->db->prepare($sql);
          $query->execute(array(':account_id' => $account_id, ':password' => $new_password));
          return 'Your account password has been updated.';
        } else {
          return 'The new password and confirmation password do not match.';
        }
      } else {
        return 'Your current password and account password do not match.';
      }
    } else {
      return 'Please fill all the input fields.';
    }
  }

}

?>