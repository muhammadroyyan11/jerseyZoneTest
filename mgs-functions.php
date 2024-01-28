<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
		
	//Sending Email from Local Web Server using PHPMailer			
	require 'phpmailer/src/PHPMailer.php';
	require 'phpmailer/src/Exception.php';
	//Create a new PHPMailer instance
	$mail = new PHPMailer;
	$mail->CharSet = 'UTF-8';
	
	//keep smtpoption false if you don't need smtp
	$smtpoption = false;		//Boolean true/false	true: email send using SMTP		false: email send using default
	if($smtpoption) {
		require 'phpmailer/src/SMTP.php';
		
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server (Change here)
		$mail->Host = "mail.yoursite.com";
		//Set the SMTP port number - likely to be 25, 465 or 587 (Change here)
		$mail->Port = 25;
		//open tls if you use as like for gmail
		//$email->SMTPSecure = 'tls';
		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;
		//Username to use for SMTP authentication (Change here)
		$mail->Username = "emailid@yoursite.com";
		//Password to use for SMTP authentication (Change here)
		$mail->Password = "yourpassword";
		
	}
	
	//From email address and name (Change here)
	$mail->From = "emailid2@yoursite.com";
	$mail->FromName = "yoursite Contact";
	
	//Recipient address and name (Change here)
	$mail->addAddress("emailid@yoursite.com", "yoursite Contact person");
	
	$usercopy = (isset($_POST["usercopy"])) ? filter_var($_POST['usercopy'], FILTER_SANITIZE_NUMBER_INT) : 0;
	if($usercopy){
		$mail->addAddress($email, $fname);
	}
	
	//Set true if want to send Confirmation email to sender
	$mgssendconfirmation = false;	//Boolean true/false	true: Confirmation email will send to sender	false: Confirmation email will not send to sender
	
	//Address to which recipient will reply
	$mail->addReplyTo($email, $fname);
	
	//Send HTML or Plain Text email
	$mail->isHTML(true);
	
	function get_client_ip() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
	
?>
