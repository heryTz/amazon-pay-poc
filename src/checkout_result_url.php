<?php
require './base.php';

$checkout_session_id = isset($_GET['amazonCheckoutSessionId']) ? $_GET['amazonCheckoutSessionId'] : null;
if (!$checkout_session_id) {
  dd('Checkout session id not found');
}

$payload = array(
  'chargeAmount' => array(
    'amount' => '1',
    'currencyCode' => 'EUR'
  )
);

try {

  $client = get_client();
  $result = $client->completeCheckoutSession($checkout_session_id, $payload);

  if ($result['status'] === 202) {
    // Charge Permission is in AuthorizationInitiated state
    $response = json_decode($result['response'], true);
    dd(202, $response);
  } else if ($result['status'] === 200) {
    $response = json_decode($result['response'], true);
    dd(200, $response);
  } else {
    dd('error', $result);
  }
} catch (Exception $e) {

}

