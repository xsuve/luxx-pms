<?php

require 'public/libs/phpmailer/Exception.php';
require 'public/libs/phpmailer/PHPMailer.php';
require 'public/libs/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class InvoicesModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Account Invoices
  public function getAccountInvoices($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT * FROM luxx_invoices WHERE account_id = :account_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id));

    return $query->fetchAll();
  }

  // Get Invoice
  public function getInvoiceData($invoice_id) {
    $invoice_id = strip_tags($invoice_id);

    $sql = 'SELECT * FROM luxx_invoices WHERE id = :invoice_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':invoice_id' => $invoice_id));

    return $query->fetch();
  }

  // Get Invoice Contact Data
  public function getInvoiceContactData($contact_id) {
    $contact_id = strip_tags($contact_id);

    $sql = 'SELECT * FROM luxx_contacts WHERE id = :contact_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':contact_id' => $contact_id));

    return $query->fetch();
  }

  // Get Invoice Item Data
  public function getInvoiceItemData($item_id) {
    $item_id = strip_tags($item_id);

    $sql = 'SELECT * FROM luxx_invoices_items WHERE id = :item_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':item_id' => $item_id));

    return $query->fetch();
  }

  // Get Invoice Category Value
  public function getInvoiceCategoryValue($category_id) {
    $category_id = strip_tags($category_id);
    $total = 0;

    $sql = 'SELECT * FROM luxx_invoices WHERE category_id = :category_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':category_id' => $category_id));
    $invoices = $query->fetchAll();

    foreach($invoices as $invoice) {
      $total += $this->getInvoiceItemsValue($invoice->id);
    }

    return $total;

  }

  // Invoice Due Date
  public function formatInvoiceDueDate($invoice_due_date, $format) {
    $invoice_due_date = strip_tags($invoice_due_date);

    if($invoice_due_date != 0) {
      $deadline_date = date_create($invoice_due_date);
      return $deadline_date->format($format);
    } else {
      return '--';
    }
  }

  // Add Invoice
  public function addInvoice($account_id, $invoice_contact_id, $invoice_project_id, $invoice_category_id, $contact_email, $contact_name, $contact_address, $contact_phone, $due_date, $vat, $invoice_logo) {
    if(!empty($account_id) && !empty($contact_name) && !empty($contact_email) && !empty($contact_address) && !empty($contact_phone) && !empty($due_date) && !empty($vat)) {
      $account_id = strip_tags($account_id);
      $contact_id = ((isset($invoice_contact_id) && $invoice_contact_id != '') ? $invoice_contact_id : 0);
      $project_id = ((isset($invoice_project_id) && $invoice_project_id != '') ? $invoice_project_id : 0);
      $invoice_category_id = strip_tags($invoice_category_id);
      $contact_name = strip_tags($contact_name);
      $contact_email = strip_tags($contact_email);
      $contact_address = strip_tags($contact_address);
      $contact_phone = strip_tags($contact_phone);
      $due_date = strip_tags($due_date);
      $vat = strip_tags($vat);
      $invoice_logo = ((isset($invoice_logo) && $invoice_logo['size'] != 0) ? $invoice_logo : '');

      $sql = 'INSERT INTO luxx_invoices (account_id, category_id, contact_id, contact_name, contact_email, contact_address, contact_phone, due_date, vat, paid) VALUES (:account_id, :invoice_category_id, :contact_id, :contact_name, :contact_email, :contact_address, :contact_phone, :due_date, :vat, :paid)';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id, ':invoice_category_id' => $invoice_category_id, ':contact_id' => $contact_id, ':contact_name' => $contact_name, ':contact_email' => $contact_email, ':contact_address' => $contact_address, ':contact_phone' => $contact_phone, ':due_date' => $due_date, ':vat' => $vat, ':paid' => 0));

      $last_id = $this->db->lastInsertId();

      if($project_id != 0) {
        if($last_id != 0) {
          $sql_project_tasks = 'SELECT * FROM luxx_projects_tasks WHERE project_id = :project_id';
          $query_project_tasks = $this->db->prepare($sql_project_tasks);
          $query_project_tasks->execute(array(':project_id' => $project_id));
          $project_tasks = $query_project_tasks->fetchAll();
          foreach($project_tasks as $project_task) {
            $sql_items = 'INSERT INTO luxx_invoices_items (invoice_id, title, quantity, price) VALUES (:invoice_id, :item_title, :item_quantity, :item_price)';
            $query_items = $this->db->prepare($sql_items);
            $query_items->execute(array(':invoice_id' => $last_id, ':item_title' => $project_task->title, ':item_quantity' => 1, ':item_price' => 0));
          }
        } else {
          return 'Project tasks could not be added to the invoice - the invoice has an invalid ID.';
        }
      }

      if($invoice_logo != '') {
        if($last_id != 0) {
          $invoice_dirs = 'public/application/invoices/';
          $invoice_file = $invoice_dirs . $last_id . '.png';
          if(!file_exists($invoice_file)) {
            if($invoice_logo['size'] < 500000) {
              if(move_uploaded_file($invoice_logo['tmp_name'], $invoice_file)) {
                return 'Your invoice has been added.';
              } else {
                return 'Your invoice has not been added.';
              }
            } else {
              return 'The invoice logo image file is too large.';
            }
          } else {
            return 'Invoice image logo with this ID already exists.';
          }
        } else {
          return 'Your invoice has not been added - image error.';
        }
      } else {
        return 'Your invoice has been added.';
      }
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Add Item
  public function addItem($account_id, $invoice_id, $item_title, $item_quantity, $item_price) {
    if(!empty($account_id) && !empty($invoice_id) && !empty($item_title) && !empty($item_quantity) && !empty($item_price)) {
      $account_id = strip_tags($account_id);
      $invoice_id = strip_tags($invoice_id);
      $item_title = strip_tags($item_title);
      $item_quantity = strip_tags($item_quantity);
      $item_price = strip_tags($item_price);

      $sql = 'INSERT INTO luxx_invoices_items (invoice_id, title, quantity, price) VALUES (:invoice_id, :item_title, :item_quantity, :item_price)';
      $query = $this->db->prepare($sql);
      $query->execute(array(':invoice_id' => $invoice_id, ':item_title' => $item_title, ':item_quantity' => $item_quantity, ':item_price' => $item_price));

      return 'The item has been added to the invoice.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Edit Item
  public function editItem($item_id, $item_title, $item_quantity, $item_price) {
    if(!empty($item_id) && !empty($item_title) && !empty($item_quantity) && !empty($item_price)) {
      $item_id = strip_tags($item_id);
      $item_title = strip_tags($item_title);
      $item_quantity = strip_tags($item_quantity);
      $item_price = strip_tags($item_price);

      $sql = 'UPDATE luxx_invoices_items SET title = :item_title, quantity = :item_quantity, price = :item_price WHERE id = :item_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':item_id' => $item_id, ':item_title' => $item_title, ':item_quantity' => $item_quantity, ':item_price' => $item_price));

      return 'The item has been edited.';
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Delete Item
  public function deleteItem($account_id, $item_id) {
    if(!empty($account_id) && !empty($item_id)) {
      $account_id = strip_tags($account_id);
      $item_id = strip_tags($item_id);

      $sql = 'DELETE FROM luxx_invoices_items WHERE id = :item_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':item_id' => $item_id));

      return 'The item has been removed from the invoice.';
    } else {
      return 'No item id provided.';
    }
  }

  // Invoice Items Value
  public function getInvoiceItemsValue($invoice_id) {
    $invoice_id = strip_tags($invoice_id);

    $sql = 'SELECT SUM(price * quantity) AS invoice_items_value FROM luxx_invoices_items WHERE invoice_id = :invoice_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':invoice_id' => $invoice_id));

    return $query->fetch()->invoice_items_value;
  }

  // Total Invoices Items Value
  public function getTotalInvoicesItemsValue($account_id, $status = null) {
    if($status != null) {
      $sql = 'SELECT SUM(ITEMS.price * ITEMS.quantity) AS total_invoices_items_value FROM luxx_invoices_items ITEMS, luxx_invoices INVOICES WHERE ITEMS.invoice_id = INVOICES.id AND INVOICES.account_id = :account_id AND INVOICES.status = :status';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id, ':status' => $status));

      return $query->fetch()->total_invoices_items_value;
    } else {
      $sql = 'SELECT SUM(ITEMS.price * ITEMS.quantity) AS total_invoices_items_value FROM luxx_invoices_items ITEMS, luxx_invoices INVOICES WHERE ITEMS.invoice_id = INVOICES.id AND INVOICES.account_id = :account_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':account_id' => $account_id));

      return $query->fetch()->total_invoices_items_value;
    }
  }

  // Invoice Items
  public function getInvoiceItems($invoice_id) {
    $invoice_id = strip_tags($invoice_id);

    $sql = 'SELECT * FROM luxx_invoices_items WHERE invoice_id = :invoice_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':invoice_id' => $invoice_id));

    return $query->fetchAll();
  }

  // Email Invoice
  public function emailInvoice($invoice_id, $subject, $email, $message) {
    if(!empty($invoice_id) && !empty($subject) && !empty($email) && !empty($message)) {
      ini_set('pcre.jit', 0);
      $invoice_id = strip_tags($invoice_id);
      $subject = strip_tags($subject);
      $email = strip_tags($email);
      $message = nl2br(strip_tags($message));

      $invoice_data = $this->getInvoiceData($invoice_id);
      require_once('application/controller/invoices.php');
      $invoice_controller = new Invoices;
      $emailPDF = $invoice_controller->stringInvoice($invoice_id);

      $mail = new PHPMailer;
      $mail->From = INVOICE_EMAIL;
      $mail->FromName = INVOICE_NAME;
      $mail->addAddress($email);
      $mail->addReplyTo(INVOICE_EMAIL, INVOICE_NAME);
      $mail->isHTML(true);
      $mail->addStringAttachment($emailPDF, 'Invoice_No.' . $invoice_data->id . '_' . str_replace(' ', '-', $invoice_data->contact_name) . '.pdf');

      $final_message = '
        <!DOCTYPE html>
        <html>
          <head>
            <title>Luxx - Invoice</title>
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
                Hello <span>' . $invoice_data->contact_name . '</span>,
                <br>
                you got a new invoice.
              </div>
              <div class="box">
                <div class="box-img">
                  <img src="' . URL . 'public/img/invoice.svg">
                </div>
                <div class="box-text">' . $message . '</div>
              </div>
              <div class="general-box-text">
                Copyright &copy; ' . date("Y") . '
                <br>
                Please ignore this e-mail if you got it by mistake.
                <br>
                For more informations, please contact us on: <a href="mailto:' . ADMIN_EMAIL . 'support">' . ADMIN_EMAIL . '</a>.
              </div>
              <div class="box-line"></div>
            </div>
          </body>
        </html>
      ';

      $mail->Subject = $subject;
      $mail->Body = $final_message;
      $mail->AltBody = $message;

      if($mail->send()) {
        return 'The invoice has been sent to the e-mail address.';
      } else {
        return 'Something went wrong.';
      }
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Edit Invoice
  public function editInvoice($invoice_id, $contact_id, $category_id, $contact_name, $contact_email, $contact_address, $contact_phone, $due_date, $vat, $paid, $invoice_logo) {
    if(!empty($invoice_id) && (!empty($contact_id) || $contact_id == 0) && !empty($contact_name) && !empty($contact_email) && !empty($contact_address) && !empty($contact_phone) && !empty($due_date) && !empty($vat)) {
      $invoice_id = strip_tags($invoice_id);
      $contact_id = strip_tags($contact_id);
      $category_id = strip_tags($category_id);
      $contact_name = strip_tags($contact_name);
      $contact_email = strip_tags($contact_email);
      $contact_address = strip_tags($contact_address);
      $contact_phone = strip_tags($contact_phone);
      $due_date = strip_tags($due_date);
      $vat = strip_tags($vat);
      $paid = ($paid == 1 ? strip_tags($paid) : 0);
      $invoice_logo = ((isset($invoice_logo) && $invoice_logo['size'] != 0) ? $invoice_logo : '');

      $sql = 'UPDATE luxx_invoices SET contact_id = :contact_id, category_id = :category_id, contact_name = :contact_name, contact_email = :contact_email, contact_address = :contact_address, contact_phone = :contact_phone, due_date = :due_date, vat = :vat, paid = :paid WHERE id = :invoice_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':contact_id' => $contact_id, ':category_id' => $category_id, ':contact_name' => $contact_name, ':contact_email' => $contact_email, ':contact_address' => $contact_address, ':contact_phone' => $contact_phone, ':due_date' => $due_date, ':vat' => $vat, ':paid' => $paid, ':invoice_id' => $invoice_id));

      if($invoice_logo != '') {
        $invoice_dirs = 'public/application/invoices/';
        $invoice_file = $invoice_dirs . $invoice_id . '.png';
        if($invoice_logo['size'] < 500000) {
          if(move_uploaded_file($invoice_logo['tmp_name'], $invoice_file)) {
            return 'Your invoice has been updated.';
          } else {
            return 'Your invoice has not been updated.';
          }
        } else {
          return 'The invoice logo image file is too large.';
        }
      } else {
        return 'Your invoice has been updated.';
      }
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Pay Invoice
  public function payInvoice($account_id, $invoice_id) {
    if(!empty($account_id) && !empty($invoice_id)) {
      $account_id = strip_tags($account_id);
      $invoice_id = strip_tags($invoice_id);

      //
    } else {
      return 'No invoice id provided.';
    }
  }

  // Download Invoice
  public function downloadInvoice($invoice_id) {
    $invoice_id = strip_tags($invoice_id);

    $sql = 'SELECT * FROM luxx_invoices WHERE id = :invoice_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':invoice_id' => $invoice_id));

    return $query->fetch();
  }

  // Delete Invoice
  public function deleteInvoice($invoice_id) {
    if(!empty($invoice_id)) {
      $invoice_id = strip_tags($invoice_id);
      
      $sql = 'DELETE FROM luxx_invoices WHERE id = :invoice_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':invoice_id' => $invoice_id));

      $this->_deleteInvoiceImage('public/application/invoices/' . $invoice_id . '.png');

      $sql_delete_items = 'DELETE FROM luxx_invoices_items WHERE invoice_id = :invoice_id';
      $query_delete_items = $this->db->prepare($sql_delete_items);
      $query_delete_items->execute(array(':invoice_id' => $invoice_id));

      return 'The invoice has been deleted.';
    } else {
      return 'No invoice id provided.';
    }
  }

  private function _deleteInvoiceImage($file) {
    $_delete_invoice_image = unlink($file);

    if($_delete_invoice_image == true) {
      return true;
    } else {
      return false;
    }
  }

}

?>