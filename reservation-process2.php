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
		
	if (empty($_POST["personcount"])) {
		$errormsg .= "Number of Person required. ";
	} else {
		$personcount = filter_var($_POST['personcount'], FILTER_SANITIZE_NUMBER_INT);
	}
	
	if (empty($_POST["reservationdatetime"])) {
		$errormsg .= "Reservation date & time required. ";
	} else {
		$reservationdatetime = filter_var($_POST['reservationdatetime'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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
			$mail->Subject = "New Clean Form Demo Reservation Request Submitted";
		
		$mgsetemple = true;		//Boolean true/false	true: email template	false: plain text email
		$body_message = "";
		if(!$mgsetemple) {
			//prepare email body [for Plain email use this]
			$body_message .= "Sender IP: " . get_client_ip() ."<br>";
			$body_message .= "Sender Name: " . $fname ."<br>";
			$body_message .= "Sender email: " . $email ."<br>";
			$body_message .= "Sender Phone: " . $phone ."<br>";
			$body_message .= "Number of Person: " . $personcount ."<br>";
			$body_message .= "Reservation date & time: " . $reservationdatetime ."<br>";
			$body_message .= "\n\n". $message;
		}
		else{			
			//prepare email body [Using email template]
			$body_message = file_get_contents('mgsc-email-template/mgsc-email-template-reservation.php');
			$mgsemailshorttag = array("[mgs-sender-ip]", "[mgs-sender-name]", "[mgs-sender-email]", "[mgs-sender-phone]", "[mgs-sender-personcount]", "[mgs-sender-reservationdatetime]", "[mgs-sender-message]");
			$mgsemailshorttagvalue   = array(get_client_ip(), $fname, $email, $phone, $personcount, $reservationdatetime, $message);
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
