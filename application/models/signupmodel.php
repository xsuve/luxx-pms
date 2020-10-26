<?php

require 'public/libs/phpmailer/Exception.php';
require 'public/libs/phpmailer/PHPMailer.php';
require 'public/libs/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SignUpModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Create Account
  public function signupAccount($name, $email, $phone_number, $password, $plan_title) {
    if(!empty($name) && !empty($email) && !empty($password)) {
      $name = strip_tags($name);
      $email = strip_tags($email);
      $phone_number = strip_tags($phone_number);
      $password = password_hash(strip_tags($password), PASSWORD_DEFAULT);

      $date = date_create();
      $register_date = date_format($date, 'Y-m-d');
      $activate_token = md5(uniqid(strtotime(date_format($date, 'Y-m-d H:i:s')), true));

      $sql_check = 'SELECT COUNT(id) AS accounts_with_email FROM luxx_accounts WHERE email = :email';
      $query_check = $this->db->prepare($sql_check);
      $query_check->execute(array(':email' => $email));
      $accounts_with_email = $query_check->fetch()->accounts_with_email;
      if($accounts_with_email == 0) {
        $sql = 'INSERT INTO luxx_accounts (is_admin, name, email, phone_number, password, register_date, activated, activate_token) VALUES (:is_admin, :name, :email, :phone_number, :password, :register_date, :activated, :activate_token)';
        $query = $this->db->prepare($sql);
        $query->execute(array(':is_admin' => 0, ':name' => $name, ':email' => $email, ':phone_number' => $phone_number, ':password' => $password, ':register_date' => $register_date, ':activated' => 0, ':activate_token' => $activate_token));

        if(isset($plan_title) && $plan_title != null) {
          $sql_plan = 'SELECT COUNT(id) AS saas_plan FROM luxx_saas_plans WHERE title = :plan_title';
          $query_plan = $this->db->prepare($sql);
          $query_plan->execute(array(':plan_title' => $plan_title));
          $saas_plan = $query_plan->fetch()->saas_plan;

          if($saas_plan != 0) {
            $sql = 'INSERT INTO luxx_saas_account_plans (account_id, plan_id) VALUES ()';
            $query = $this->db->prepare($sql);
            $query->execute(array(':is_admin' => 0, ':name' => $name, ':email' => $email, ':phone_number' => $phone_number, ':password' => $password, ':register_date' => $register_date, ':activated' => 0, ':activate_token' => $activate_token));
          }
        }

        $mail = new PHPMailer;

        // $mail->IsSMTP();
        // $mail->Host = 'mail.example.com';
        // $mail->SMTPAuth = true;
        // $mail->Username = 'username';
        // $mail->Password = 'password';

        $mail->From = 'activate@luxx.com';
        $mail->FromName = 'Luxx Activate Account';
        $mail->addAddress($email);
        $mail->addReplyTo('activate@luxx.com', 'Luxx Activate Account');
        $mail->isHTML(true);

        $message = '
          <!DOCTYPE html>
          <html>
            <head>
              <title>Luxx - Activate Account</title>
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
                  Hello <span>' . $name . '</span>,
                  <br>
                  please confirm your Luxx account.
                </div>
                <div class="box">
                  <div class="box-img">
                    <img src="' . URL . 'public/img/email.svg">
                  </div>
                  <div class="box-text">
                    Thank you for signing up on Luxx. Your account has been successfully registered in the platform.
                  </div>
                  <div class="box-line"></div>
                  <div class="box-text">
                    To be able to log into your newly created account, you need to confirm your e-mail address by clicking the button below.
                  </div>
                  <div class="box-btn">
                    <a href="' . URL . 'login/activateaccount/' . $email . '/' . $activate_token . '"><button>Activate account</button></a>
                  </div>
                </div>
                <div class="general-box-text">
                  Copyright &copy; ' . date("Y") . '
                  <br>
                  Please ignore this e-mail if you did not sign up on the Luxx platform.
                  <br>
                  For more informations, please contact us on: <a href="mailto:' . ADMIN_EMAIL . 'support">' . ADMIN_EMAIL . '</a>.
                </div>
              </div>
            </body>
          </html>
        ';

        $mail->Subject = 'Luxx | Account Activation';
        $mail->Body = $message;
        $mail->AltBody = 'Activation Link: ' . URL . 'login/activateaccount/' . $email . '/' . $activate_token;

        if($mail->send()) {
          return 'Follow the link from the e-mail address to confirm your account.';
        } else {
          return 'Something went wrong.';
        }
      } else {
        return 'This e-mail has already been registered.';
      }
    } else {
      return 'Please fill all the input fields.';
    }
  }

}

?>