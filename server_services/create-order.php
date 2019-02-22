<?php

// Import file
require_once("functions.php");
include 'ChromePhp.php';

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if ($contentType === "application/json") {

  //Receive the RAW post data.
  $content = trim(file_get_contents("php://input"));

  $decoded = json_decode($content, true);

  //If json_decode failed, the JSON is invalid.
  if(is_array($decoded)) {

	$transactions = $decoded["transactions"];

	// ChromePhp::log('***'.json_encode($transactions));

	// $transactions = '{"amount":{"currency_code": "MXN","value": "400.00"}}';

	// get access token using get_access_token() function in functions.php
	$access_token = get_access_token();

	// get payment response by executing create_payment() function declared in functions.php
	$order = create_order( $access_token, json_encode($transactions) );

	$order_id = $order['id'];

	header('Content-Type: application/json');
	echo '{"orderID":"'.$order_id.'"} ';

  } else {
    echo '{"message":"decoded failed"} ';
  }
}

?>