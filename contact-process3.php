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
		
	if (empty($_POST["service"])) {
		$errormsg .= "Service required. ";
	} else {
		$service = filter_var($_POST['service'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if (empty($_POST["subject"])) {
		$errormsg .= "Subject required. ";
	} else {
		$subject = filter_var($_POST['subject'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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
		if($subject)
			$mail->Subject = $subject;
		else
			$mail->Subject = "New Clean Form Demo Contact Request Submitted";
		
		$mgsetemple = true;		//Boolean true/false	true: email template	false: plain text email
		$body_message = "";
		if(!$mgsetemple) {
			//prepare email body [for Plain email use this]
			$body_message .= "Sender IP: " . get_client_ip() ."<br>";
			$body_message .= "Sender Name: " . $fname ."<br>";
			$body_message .= "Sender email: " . $email ."<br>";
			$body_message .= "Sender Phone: " . $phone ."<br>";
			$body_message .= "Required Service: " . $service ."<br>";
			$body_message .= "\n\n". $message;
		}
		else{			
			//prepare email body [Using email template]
			$body_message = file_get_contents('mgsc-email-template/mgsc-email-template.php');
			$mgsemailshorttag = array("[mgs-sender-ip]", "[mgs-sender-name]", "[mgs-sender-email]", "[mgs-sender-phone]", "[mgs-sender-service]", "[mgs-sender-message]");
			$mgsemailshorttagvalue   = array(get_client_ip(), $fname, $email, $phone, $service, $message);
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
