<?php
	$errormsg = "";
	
	if (empty($_POST["fname"])) {
		$errormsg .= "Name required. ";
	} else {
		$fname = filter_var($_POST['fname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if (empty($_POST["email"])) {
		$errormsg .= "Email required. ";
	} else {
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	}
	
	$phone = (isset($_POST["phone"])) ? filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT) : '';
		
	if (empty($_POST["adultcount"])) {
		$errormsg .= "Adult required. ";
	} else {
		$adultcount = filter_var($_POST['adultcount'], FILTER_SANITIZE_NUMBER_INT);
	}
		
	if (empty($_POST["childcount"])) {
		$childcount = 'NULL';
	} else {
		$childcount = filter_var($_POST['childcount'], FILTER_SANITIZE_NUMBER_INT);
	}
		
	if (empty($_POST["pet"])) {
		$errormsg .= "Pet required. ";
	} else {
		$pet = filter_var($_POST['pet'], FILTER_SANITIZE_NUMBER_INT);
	}
	
	if (empty($_POST["checkindatetime"])) {
		$errormsg .= "Check in date & time required. ";
	} else {
		$checkindatetime = filter_var($_POST['checkindatetime'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if (empty($_POST["checkoutdatetime"])) {
		$errormsg .= "Checkout date & time required. ";
	} else {
		$checkoutdatetime = filter_var($_POST['checkoutdatetime'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if (empty($_POST["message"])) {
		$errormsg .= "Message required. ";
	} else {
		$message = filter_var($_POST['message'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$message = nl2br($message);
	}
	
	$success = '';
	if (!$errormsg){
		
		require_once "mgs-functions.php";
		
		//email subject (Change here)
		if($_POST["subject"])
			$mail->Subject = filter_var($_POST['subject'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		else
			$mail->Subject = "New Clean Form Demo Hotel Reservation Request Submitted";
		
		$mgsetemple = true;		//Boolean true/false	true: email template	false: plain text email
		$body_message = "";
		if(!$mgsetemple) {
			//prepare email body [for Plain email use this]
			$body_message .= "Sender IP: " . get_client_ip() ."<br>";
			$body_message .= "Sender Name: " . $fname ."<br>";
			$body_message .= "Sender email: " . $email ."<br>";
			$body_message .= "Sender Phone: " . $phone ."<br>";
			$body_message .= "Adult: " . $adultcount ."<br>";
			$body_message .= "Child: " . $childcount ."<br>";
			$body_message .= "Pet: " . $pet ."<br>";
			$body_message .= "Check in date & time: " . $checkindatetime ."<br>";
			$body_message .= "Checkout date & time: " . $checkoutdatetime ."<br>";
			$body_message .= "\n\n". $message;
		}
		else{			
			//prepare email body [Using email template]
			$body_message = file_get_contents('mgsc-email-template/mgsc-email-template-hotel-reservation.php');
			$mgsemailshorttag = array("[mgs-sender-ip]", "[mgs-sender-name]", "[mgs-sender-email]", "[mgs-sender-phone]", "[mgs-sender-adultcount]", "[mgs-sender-childcount]", "[mgs-sender-pet]", "[mgs-sender-checkindatetime]", "[mgs-sender-checkoutdatetime]", "[mgs-sender-message]");
			$mgsemailshorttagvalue   = array(get_client_ip(), $fname, $email, $phone, $adultcount, $childcount, $pet, $checkindatetime, $checkoutdatetime, $message);
			$body_message = str_replace($mgsemailshorttag, $mgsemailshorttagvalue, $body_message);
		}
		
		$mail->Body = $body_message;	
		
		//send mail
		if(!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} 
		else {
			//send confirmation email
			if($mgssendconfirmation){
				require_once "mgs-send-confirmation.php";
			}
			echo "success";		//DO NOT CHNAGE THIS LINE (required)
		}
		
	}
	else {
		echo "Something went wrong: ".$errormsg;
	}
	
?>
