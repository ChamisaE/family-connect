<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
use FamConn\FamilyConnect\User;

/**
 * api for handling sign-in
 *
 * @author sromero130
 **/
//prepare and empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {

	//start session
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	//grab mySQL statement
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cohort22/familyconnect.ini");

	//determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//If method is post handle the sign in logic
	if($method === "POST") {

			//make sure the XSRF Token is valid
			verifyXsrf();

			//process the request content and decode the json object into a php object
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);

			//check to make sure the password and email field is not empty.s
			if(empty($requestObject->userEmail) === true) {
				throw(new \InvalidArgumentException("Wrong email address.", 401));
			} else {
						$userEmail = filter_var($requestObject->userEmail, FILTER_SANITIZE_EMAIL);
			}

			if(empty($requestObject->userPassword) === true) {
				throw(new \InvalidArgumentException("Must enter a password.", 401));
			} else {
						$userPassword = $requestObject->userPassword;
			}
	}

}