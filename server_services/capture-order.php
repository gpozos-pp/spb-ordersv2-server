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

	$orderID = $decoded["orderID"];

	$accessToken = get_access_token();
	$response = capture_order($accessToken, $orderID);

	header('Content-Type: application/json');
	echo $response;

  } else {
    echo '{"message":"decoded failed"} ';
  }
}

?>