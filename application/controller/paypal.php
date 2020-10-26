<?php

class Paypal extends Controller {

  public function index() {
    header('location: ' . URL . 'dashboard');
  }

  // Make Payment
  public function makePayment() {
    $account = $this->getSessionAccount();
    if($account != null) {
      if(isset($_POST['plan_id']) && isset($_POST['from_url'])) {
        $plan_id = strip_tags($_POST['plan_id']);
        $from_url = strip_tags($_POST['from_url']);

        $module_model = $this->loadModuleModel('saas', 'SaasModel');
        $account_plan = $module_model->getAccountPlan($account->id);
        if($account_plan->plan_id != $plan_id) {
          $paypal_model = $this->loadModel('PaypalModel');
          $make_payment = $paypal_model->makePayment($account->id, $plan_id, $from_url);

          if(isset($make_payment) && $make_payment != null) {
            header('location: ' . $make_payment);
          } else {
            $_SESSION['alert'] = 'There were some errors in making the payment.';
            header('location: ' . URL . $from_url);
          }
        } else {
          $_SESSION['alert'] = 'You have already purchased this plan.';
          header('location: ' . URL . $from_url);
        }
      } else {
        header('location: ' . URL . 'dashboard');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Payment Success
  public function paymentSuccess() {
    $account = $this->getSessionAccount();

    if($account != null) {
      $payment_id = strip_tags($_GET['paymentId']);
      $payment_token = strip_tags($_GET['token']);
      $payer_id = strip_tags($_GET['PayerID']);

      $paypal_model = $this->loadModel('PaypalModel');
      $payment_data = $paypal_model->getPaymentData($payment_id);

      $payment_plan_id = $payment_data->transactions[0]->custom;
      $payment_plan_name = $payment_data->transactions[0]->item_list->items[0]->name;

      // Add Transaction
      $paypal_model = $this->loadModel('PaypalModel');
      $paypal_model->addTransaction($account->id, $payment_id, $payment_token, $payer_id, $payment_plan_name);

      // Upgrade Plan
      $module_model = $this->loadModuleModel('saas', 'SaasModel');
      $upgrade_plan = $module_model->upgradePlan($account->id, $payment_plan_id);

      if(isset($upgrade_plan) && $upgrade_plan != null) {
        $_SESSION['payment_title'] = 'The payment has been successfully processed.';
        $_SESSION['payment_description'] = 'Thanks for your purchase. Below are the details of your transaction.<br>You will be able to check your transactions on the account page.';

        require 'application/views/_templates/header.php';
        require 'includes/modules/saas/views/_templates/header.php';
        require 'includes/modules/saas/views/_templates/popbox-payment.php';
        require 'application/views/_templates/footer.php';
      } else {
        $_SESSION['alert'] = 'There were some errors in upgrading the plan.';
        header('location: ' . URL . 'dashboard');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Payment Cancel
  public function paymentCancel() {
    $account = $this->getSessionAccount();

    if($account != null) {
      if(isset($_GET['from_url'])) {
        $from_url = strip_tags($_GET['from_url']);

        $_SESSION['alert'] = 'The payment has been cancelled.';
        header('location: ' . URL . $from_url);
      } else {
        header('location: ' . URL . 'dashboard');
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

}

?>