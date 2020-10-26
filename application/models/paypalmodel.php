<?php

require 'public/libs/paypal-php-sdk/autoload.php';

class PaypalModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Get Payment Data
  public function getPaymentData($payment_id) {
    if(!empty($payment_id)) {
      $apiContext = new \PayPal\Rest\ApiContext(new \PayPal\Auth\OAuthTokenCredential(PAYPAL_CLIENT_ID, PAYPAL_CLIENT_SECRET));

      $payment_id = strip_tags($payment_id);

      $payment = new \PayPal\Api\Payment();
      $payment_data = $payment->get($payment_id, $apiContext);
      return $payment_data;
    }
  }

  // Make Payment
  public function makePayment($account_id, $plan_id, $from_url) {
    if(!empty($account_id) && !empty($plan_id)) {
      $account_id = strip_tags($account_id);
      $plan_id = strip_tags($plan_id);
      $from_url = strip_tags($from_url);

      $sql = 'SELECT * FROM luxx_saas_plans WHERE id = :plan_id';
      $query = $this->db->prepare($sql);
      $query->execute(array(':plan_id' => $plan_id));
      $plan_data = $query->fetch();

      $apiContext = new \PayPal\Rest\ApiContext(new \PayPal\Auth\OAuthTokenCredential(PAYPAL_CLIENT_ID, PAYPAL_CLIENT_SECRET));

      $payer = new \PayPal\Api\Payer();
      $payer->setPaymentMethod('paypal');

      $item = new \PayPal\Api\Item();
      $item->setName('Luxx | ' . $plan_data->title . ' Plan')
        ->setCurrency('USD')
        ->setQuantity(1)
        ->setSku('LUXX' . $plan_data->id)
        ->setPrice($plan_data->monthly_price);

      $itemList = new \PayPal\Api\ItemList();
      $itemList->setItems(array($item));

      $amount = new \PayPal\Api\Amount();
      $amount->setCurrency('USD')
        ->setTotal($plan_data->monthly_price);

      $transaction = new \PayPal\Api\Transaction();
      $transaction->setAmount($amount)
        ->setItemList($itemList)
        ->setDescription('Purchase a plan on Luxx')
        ->setCustom($plan_data->id);

      $redirectUrls = new \PayPal\Api\RedirectUrls();
      $redirectUrls->setReturnUrl(URL . 'paypal/paymentsuccess')
        ->setCancelUrl(URL . 'paypal/paymentcancel?from_url=' . $from_url);

      $payment = new \PayPal\Api\Payment();
      $payment->setIntent('sale')
        ->setPayer($payer)
        ->setTransactions(array($transaction))
        ->setRedirectUrls($redirectUrls);

      $payment->create($apiContext);

      $approvalUrl = $payment->getApprovalLink();
      if($approvalUrl) {
        return $approvalUrl;
      }
    }
  }

  // Add Transaction
  public function addTransaction($account_id, $payment_id, $payment_token, $payer_id, $payment_title) {
    if(!empty($account_id) && !empty($payment_id) && !empty($payment_token) && !empty($payer_id) && !empty($payment_title)) {
      $account_id = strip_tags($account_id);
      $payment_id = strip_tags($payment_id);
      $payment_token = strip_tags($payment_token);
      $payer_id = strip_tags($payer_id);
      $payment_title = strip_tags($payment_title);

      $date = date_create();
      $payment_date = date_format($date, 'Y-m-d');

      $sql_add_tx = 'INSERT INTO luxx_saas_transactions (account_id, payment_id, payment_token, payer_id, title, payment_date) VALUES (:account_id, :payment_id, :payment_token, :payer_id, :payment_title, :payment_date)';
      $query_add_tx = $this->db->prepare($sql_add_tx);
      $query_add_tx->execute(array(':account_id' => $account_id, ':payment_id' => $payment_id, ':payment_token' => $payment_token, ':payer_id' => $payer_id, ':payment_title' => $payment_title, ':payment_date' => $payment_date));

      return 'The payment has been added.';
    } else {
      return 'Some of the fields are empty.';
    }
  }

}

?>