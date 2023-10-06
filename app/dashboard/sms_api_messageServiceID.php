<?php

use Twilio\Rest\Client;

// require_once "Twilio/autoload.php";
include __DIR__ . "/vendor/twilio/sdk/src/Twilio/Rest/Client.php";
// require __DIR__ . '/twilio-php-master/src/Twilio/autoload.php';
//require_once "vendor/autoload.php"; 

// send sms here to user
$sid    = "AC7db75c1bce407e1c7afc5bfab44aa896";
$token  = "1fff6a50197cae086e7df53b7732a622";
$twilio = new Client($sid, $token);

$message = $twilio->messages
	->create(
		$phone, // to 
		array(
			"messagingServiceSid" => "MGe6639f2970ce53dbae3bfb2c030b9c33",
			"body" => "Natwest Bank Online! Your account has be Debited with $money_sent"
		)
	);
?>
