<?php
require '../vendor/autoload.php';

$checkout_session_id = isset($_GET['amazonCheckoutSessionId']) ? $_GET['amazonCheckoutSessionId'] : null;
if (!$checkout_session_id) {
  dd('Checkout session id not found');
}

dd($checkout_session_id);
