<?php

require 'public/libs/phpmailer/Exception.php';
require 'public/libs/phpmailer/PHPMailer.php';
require 'public/libs/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class LogInModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Login Account
  public function loginAccount($email, $password) {
    if(!empty($email) && !empty($password)) {
      $email = strip_tags($email);
      $password = strip_tags($password);

      $sql_check = 'SELECT * FROM luxx_accounts WHERE email = :email';
      $query_check = $this->db->prepare($sql_check);
      $query_check->execute(array(':email' => $email));
      $account = $query_check->fetch();
      if($account) {
        if(password_verify($password, $account->password)) {
          if($account->activated == true) {
            $_SESSION['account'] = $account->email;
          } else {
            return 'This account has not been activated.';
          }
        } else {
          return 'The e-mail or the password was incorrect.';
        }
      } else {
        return 'This account does not exist.';
      }
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Activate Account
  public function activateAccount($email, $activate_token) {
    if(!empty($email) && !empty($activate_token)) {
      $email = strip_tags($email);
      $activate_token = strip_tags($activate_token);

      $sql_check = 'SELECT * FROM luxx_accounts WHERE email = :email';
      $query_check = $this->db->prepare($sql_check);
      $query_check->execute(array(':email' => $email));
      $account = $query_check->fetch();
      if($account) {
        if($activate_token === $account->activate_token) {
          if($account->activated == 0) {
            $sql = 'UPDATE luxx_accounts SET activated = :activated WHERE email = :email';
            $query = $this->db->prepare($sql);
            $query->execute(array(':activated' => 1, ':email' => $email));

            return 'Your account has been activated.';
          } else {
            return 'This account has already been activated.';
          }
        } else {
          return 'Invalid activation token.';
        }
      } else {
        return 'This account does not exist.';
      }
    } else {
      return 'No email or activation token provided.';
    }
  }

  // Forgot Password
  public function forgotPassword($email) {
    if(!empty($email)) {
      $email = strip_tags($email);

      $sql_check = 'SELECT * FROM luxx_accounts WHERE email = :email';
      $query_check = $this->db->prepare($sql_check);
      $query_check->execute(array(':email' => $email));
      $account = $query_check->fetch();
      if($account) {
        if($account->activated != 0) {
          $date = date_create();
          $register_date = date_format($date, 'Y-m-d');
          $token = md5(uniqid(strtotime(date_format($date, 'Y-m-d H:i:s')), true));

          $sql_token = 'UPDATE luxx_accounts SET activate_token = :activate_token WHERE email = :email';
          $query_token = $this->db->prepare($sql_token);
          $query_token->execute(array(':activate_token' => $token, ':email' => $email));

          $mail = new PHPMailer;

          // $mail->IsSMTP();
          // $mail->Host = 'mail.example.com';
          // $mail->SMTPAuth = true;
          // $mail->Username = 'username';
          // $mail->Password = 'password';

          $mail->From = 'reset@luxx.com';
          $mail->FromName = 'Luxx Reset Password';
          $mail->addAddress($email);
          $mail->addReplyTo('reset@luxx.com', 'Luxx Reset Password');
          $mail->isHTML(true);

          $message = '
            <!DOCTYPE html>
            <html>
              <head>
                <title>Luxx - Reset Password</title>
                <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,800" rel="stylesheet">
                <style type="text/css">
                  body {
                    height: 100%;
                    font-family: "Muli", sans-serif;
                    padding: 40px;
                    margin: 0px;
                    background-color: #eaeff2;
                  }
                  a {
                    text-decoration: none;
                  }
                  button {
                    background-color: #54a0f7;
                    border-radius: 2px;
                    font-size: 13px;
                    line-height: 21px;
                    font-weight: 500;
                    letter-spacing: 0.2px;
                    padding: 9px 30px;
                    cursor: pointer;
                    border: 0px;
                    color: #fff;
                  }

                  .general-box {
                    width: 100%;
                    margin: 0px auto;
                    text-align: center;
                  }
                  .general-box-img {
                    width: 48px;
                    height: 48px;
                    margin: 0px auto 20px auto;
                  }
                  .general-box-img img, .box-img img {
                    max-width: 100%;
                  }
                  .general-box-title {
                    font-weight: 300;
                    color: #333;
                    font-size: 26px;
                    line-height: 36px;
                  }
                  .general-box-title span {
                    font-weight: 800;
                  }
                  .general-box-text {
                    font-weight: 400;
                    color: #444;
                    letter-spacing: 0.2px;
                    font-size: 13px;
                    line-height: 23px;
                    padding: 0px 50px;
                    margin: 30px 0px 0px 0px;
                  }
                  .general-box-text a {
                    color: #54a0f7;
                  }

                  .box {
                    background-color: #fff;
                    padding: 40px;
                    border-radius: 2px;
                    margin: 30px 0px 0px 0px;
                  }
                  .box-img {
                    width: 72px;
                    height: 72px;
                    margin: 0px auto 20px auto;
                  }
                  .box-text {
                    font-weight: 400;
                    color: #333;
                    letter-spacing: 0.2px;
                    font-size: 14px;
                    line-height: 24px;
                    padding: 0px 50px;
                  }
                  .box-line {
                    height: 1px;
                    background-color: #dfdfdf;
                    width: 50%;
                    margin: 20px auto;
                  }
                  .box-btn {
                    margin: 30px 0px 0px 0px;
                  }
                </style>
              </head>
              <body>
                <div class="general-box">
                  <div class="general-box-img">
                    <img src="' . URL . 'public/img/luxx-logo.svg">
                  </div>
                  <div class="general-box-title">
                    Hello user,
                    <br>
                    reset your account password.
                  </div>
                  <div class="box">
                    <div class="box-img">
                      <img src="' . URL . 'public/img/password.svg">
                    </div>
                    <div class="box-text">
                      We are here to help you reset your password and get your account back.
                    </div>
                    <div class="box-line"></div>
                    <div class="box-text">
                      To be able to reset your password, follow the instructions from the link by clicking the button below.
                    </div>
                    <div class="box-btn">
                      <a href="' . URL . 'login/reset/' . $email . '/' . $token . '"><button>Reset password</button></a>
                    </div>
                  </div>
                  <div class="general-box-text">
                    Copyright &copy; ' . date("Y") . '
                    <br>
                    Please ignore this e-mail if you do not have an account on the Luxx platform.
                    <br>
                    For more informations, please contact us on: <a href="mailto:' . ADMIN_EMAIL . '">' . ADMIN_EMAIL . '</a>
                  </div>
                </div>
              </body>
            </html>
          ';

          $mail->Subject = 'Luxx | Reset Password';
          $mail->Body = $message;
          $mail->AltBody = 'Reset Password Link: ' . URL . 'login/resetpassword/' . $email . '/' . $token;

          if($mail->send()) {
            return 'Follow the link from the e-mail address to reset your password.';
          } else {
            return 'Something went wrong.';
          }

        } else {
          return 'This account has not been activated yet.';
        }
      } else {
        return 'This account does not exist.';
      }
    } else {
      return 'No email provided.';
    }
  }

  // Reset Password
  public function resetPassword($email, $token, $new_password, $confirm_new_password) {
    if(!empty($email) && !empty($token) && !empty($new_password) && !empty($confirm_new_password)) {
      $email = strip_tags($email);
      $token = strip_tags($token);
      $new_password = strip_tags($new_password);
      $confirm_new_password = strip_tags($confirm_new_password);

      $sql_check = 'SELECT * FROM luxx_accounts WHERE email = :email';
      $query_check = $this->db->prepare($sql_check);
      $query_check->execute(array(':email' => $email));
      $account = $query_check->fetch();
      if($account) {
        if($new_password == $confirm_new_password) {
          if($account->activate_token == $token) {
            if(!password_verify($confirm_new_password, $account->password)) {
              $reset_password = password_hash($confirm_new_password, PASSWORD_DEFAULT);
              $sql = 'UPDATE luxx_accounts SET password = :password WHERE email = :email';
              $query = $this->db->prepare($sql);
              $query->execute(array(':password' => $reset_password, ':email' => $email));

              return 'The password has been updated. You can now log into your account.';
            } else {
              return 'You can not use the same password for your new password. Please start the process again.';
            }
          } else {
            return 'The reset password token is invalid.';
          }
        } else {
          return 'Passwords do not match.';
        }
      } else {
        return 'This account does not exist.';
      }
    } else {
      return 'No email or new password provided.';
    }
  }
    
}

?>