<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
use FamConn\FamilyConnect\User;
/**
 * api for handling sign-up
 * @author Anthony Garcia
 **/
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySQL statement
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort22/familyconnect");
	$pdo = $secrets->getPdoObject();
	//determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_METHOD"] : $_SERVER["REQUEST_METHOD"];
	var_dump($method);
	if($method === "POST") {
		//process the request content and decode the json object into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//check to make sure the password and email field is not empty
		if(empty($requestObject->userEmail)) {
			throw(new \InvalidArgumentException("No email address given", 405));
		}
		//verify that display name is present
		if(empty($requestObject->userDisplayName) === true) {
			throw(new \InvalidArgumentException("No username given",405));
		}

		if(empty($requestObject->userPhoneNumber) === true) {
			throw(new \InvalidArgumentException("Must input valid phone number", 405));
		}
		//verify that user password is present
		if(empty($requestObject->userPassword) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}
		//verify that the confirm password is present
		if(empty($requestObject->userPasswordConfirm) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}
		if(empty($requestObject->userFamilyId) === true) {
			throw(new \InvalidArgumentException ("Must have family", 405));
		}
		//make sure the password and confirm password match
		if ($requestObject->userPassword !== $requestObject->userPasswordConfirm) {
			throw(new \InvalidArgumentException("Passwords do not match"));
		}
		$hash = password_hash($requestObject->userPassword, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$userActivationToken = bin2hex(random_bytes(16));
		// create the user object and prepare to insert into the database
		$user = new User(generateUuidV4(), $requestObject->userFamilyId, $userActivationToken, "http://awesomephoto.com" , $requestObject->userDisplayName, $requestObject ->userEmail, $hash, $requestObject->userPhoneNumber, 0);
		//insert the user into the database
		$user->insert($pdo);
		//compose the email message to send with the activation token
		$messageSubject = "One step closer -- Account Activation";
		//building the activation link that can travel to another server and still work. this is the link that will be clicked to confirm the account
		$basePath = dirname($_SERVER["SCRIPT_NAME"], 3);
		//create the path
		$urlglue = $basePath . "/api/activation/?activation=" . $userActivationToken;
		//create the redirect link
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;
		//compose the message to send with email
		$message = <<< EOF
<h2>Welcome to FamilyConnect.</h2>
<p>In order to use FamilyConnect, please confirm your account</p>
<p><a href="$confirmLink">$confirmLink</a></p>
EOF;
		//create swift email
		$swiftMessage = new Swift_Message();
		//attach the sender to the message
		//this takes the form of an associative array where the email is the key to a real name
		$swiftMessage->setFrom(["antgarcia014@gmail.com" => "Anthony Garcia"]);
		/**
		 *attach recipients to the message
		 **/
		//define who the recipient is
		$recipients = [$requestObject->userEmail];
		//set the recipient to the swift message
		$swiftMessage->setTo($recipients);
		//attach the subject line to the email message
		$swiftMessage->setSubject($messageSubject);
		/**
		 *attach the message to the email
		 **/
		//attach the html version of the message
		$swiftMessage->setBody($message, "text/html");
		//attach the plain text version of the message
		$swiftMessage->addPart(html_entity_decode($message), "text/plain");
		/**
		 *send the email via SMTP;
		 * @see http://swiftmailer.org/docs/sending.html Sending Messages - Documentation - SwitftMailer
		 **/
		//setup smtp
		$smtp = new Swift_SmtpTransport(
			"localhost", 25);
		$mailer = new Swift_Mailer($smtp);
		//send the message
		$numSent = $mailer->send($swiftMessage, $failedRecipients);
		/**
		 *the send method returns the number of recipients that accepted the email
		 * if the number of attempted sign ups is not the number accepted its an exception
		 **/
		if($numSent !== count($recipients)) {
			//the $failedRecipients parameter passed in the send() method now contains an array of the emails that failed to pass
			throw(new RuntimeException("Unable to send email", 400));
		}
		//update reply
		$reply->message = "Thank you for creating an account with FamilyConnect. You'll receive a message shortly.";
	} else {
		throw (new InvalidArgumentException("invalid http request", 418));
	}
} catch(\Exception |\TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
}
header("Content-type: application/json");
echo json_encode($reply);