<?php
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$GLOBALS['private_key'] = __DIR__ . '/../key/private.pem';
$GLOBALS['public_key'] = $_ENV['PUBLIC_KEY'];
$GLOBALS['store_id'] = $_ENV['STORE_ID'];
$GLOBALS['merchant_id'] = $_ENV['MERCHANT_ID'];
$GLOBALS['checkout_review_url'] = $_ENV['APP_URL'] .'/checkout_review_url.php';
$GLOBALS['checkout_result_url'] = $_ENV['APP_URL'] .'/checkout_result_url.php';

function get_client()
{
  $amazonpay_config = array(
    'public_key_id' => $GLOBALS['public_key'],
    'private_key'   => $GLOBALS['private_key'],
    'region'        => 'EU',
    'sandbox'       => true,
    'algorithm' => 'AMZN-PAY-RSASSA-PSS-V2'
  );

  return new Amazon\Pay\API\Client($amazonpay_config);
}