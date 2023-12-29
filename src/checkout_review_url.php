<?php
require './base.php';

$checkout_session_id = isset($_GET['amazonCheckoutSessionId']) ? $_GET['amazonCheckoutSessionId'] : null;
if (!$checkout_session_id) {
  dd('Checkout session id not found');
}

$payload = array(
  'webCheckoutDetails' => array(
    'checkoutResultReturnUrl' => $GLOBALS['checkout_result_url']
  ),
  'paymentDetails' => array(
    'paymentIntent' => 'AuthorizeWithCapture',
    'canHandlePendingAuthorization' => false,
    'softDescriptor' => 'Descriptor',
    'chargeAmount' => array(
      'amount' => '1',
      'currencyCode' => 'EUR'
    )
  ),
  'merchantMetadata' => array(
    'merchantReferenceId' => 'Merchant reference ID',
    'merchantStoreName' => 'Merchant store name',
    'noteToBuyer' => 'Note to buyer',
    'customInformation' => 'Custom information'
  )
);

$client = get_client();
$result = $client->updateCheckoutSession($checkout_session_id, $payload);

if ($result['status'] === 200) {
  $response = json_decode($result['response'], true);
  $amazonPayRedirectUrl = $response['webCheckoutDetails']['amazonPayRedirectUrl'];
  header('Location: ' . $amazonPayRedirectUrl);
  die();
}

dd($result);