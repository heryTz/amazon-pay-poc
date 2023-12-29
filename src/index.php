<?php

require '../vendor/autoload.php';

$GLOBALS['private_key'] = 'path_to_private_key.pem';
$GLOBALS['public_key'] = 'xxx';
$GLOBALS['store_id'] = 'xxx';
$GLOBALS['merchant_id'] = 'xx'

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

function create_checkout_session_payload()
{
  $payload = json_encode([
    'webCheckoutDetails' => [
      'checkoutReviewReturnUrl' => 'https://a.com/merchant-review-page'
    ],
    'storeId' => $GLOBALS['store_id'],
  ]);

  $client = get_client();
  $signature = $client->generateButtonSignature($payload);

  return [
    'payload_json' => $payload,
    'signature' => $signature
  ];
}

$ap_info = create_checkout_session_payload();

?>

<h1>Amazon Pay POC</h1>
<div id="AmazonPayButton"></div>

<script src="https://static-eu.payments-amazon.com/checkout.js"></script>
<script type="text/javascript" charset="utf-8">
  const amazonPayButton = amazon.Pay.renderButton('#AmazonPayButton', {
    // set checkout environment
    merchantId: '<?= $GLOBALS['merchant_id'] ?>',
    publicKeyId: '<?= $GLOBALS['public_key'] ?>',
    ledgerCurrency: 'EUR',
    // customize the buyer experience
    checkoutLanguage: 'en_GB',
    productType: 'PayAndShip',
    placement: 'Cart',
    buttonColor: 'Gold',
    estimatedOrderAmount: { "amount": "109.99", "currencyCode": "EUR" },
    // configure Create Checkout Session request
    createCheckoutSessionConfig: {
      payloadJSON: '<?= $ap_info['payload_json'] ?>',
      signature: '<?= $ap_info['signature'] ?>',
      algorithm: 'AMZN-PAY-RSASSA-PSS-V2'
    }
  });
</script>