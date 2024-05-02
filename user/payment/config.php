<?php
require('stripe-php-master/init.php');

$publishableKey="";//use your publish key here

$secretKey="";//use your secret key here

\Stripe\Stripe::setApiKey($secretKey);
?>