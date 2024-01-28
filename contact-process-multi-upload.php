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
	
	if (empty($_POST["address"])) {
		$errormsg .= "Address required. ";
	} else {
		$address = filter_var($_POST['address'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
		
	if (empty($_POST["jobtitle"])) {
		$errormsg .= "Job Title required. ";
	} else {
		$jobtitle = filter_var($_POST['jobtitle'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
		
	if (empty($_POST["jobskills"])) {
		$errormsg .= "Job Skills required. ";
	} else {
		$jobskills = filter_var($_POST['jobskills'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if (empty($_POST["message"])) {
		$errormsg .= "Message required. ";
	} else {
		$message = filter_var($_POST['message'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$message = nl2br($message);
	}
		
	$allowed =  array('doc','docx','pdf','png');
	if (!empty($_FILES['userfile']['name'])) {
		if ($_FILES['userfile']['size'] > 2097152) {
			$errormsg .= "Attachment is greter than 2 MB. ";
		}
		
		$filename = $_FILES['userfile']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if(!in_array($ext,$allowed) ) {
			$errormsg .= "Attachment alowed only doc/docx/pdf/png. ";
		}
	}
	if (!empty($_FILES['userfile2']['name'])) {
		if ($_FILES['userfile2']['size'] > 2097152) {
			$errormsg .= "Attachment2 is greter than 2 MB. ";
		}
		
		$filename2 = $_FILES['userfile2']['name'];
		$ext2 = pathinfo($filename, PATHINFO_EXTENSION);
		if(!in_array($ext2,$allowed) ) {
			$errormsg .= "Attachment2 alowed only doc/docx/pdf/png. ";
		}
	}
	if (!empty($_FILES['userfile3']['name'])) {
		if ($_FILES['userfile3']['size'] > 2097152) {
			$errormsg .= "Attachment3 is greter than 2 MB. ";
		}
		
		$filename3 = $_FILES['userfile3']['name'];
		$ext3 = pathinfo($filename, PATHINFO_EXTENSION);
		if(!in_array($ext3,$allowed) ) {
			$errormsg .= "Attachment3 alowed only doc/docx/pdf/png. ";
		}
	}	
	
	$success = '';
	if (!$errormsg){
		
		require_once "mgs-functions.php";
		
		//email subject (Change here)
		if($_POST["subject"])
			$mail->Subject = filter_var($_POST['subject'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		else
			$mail->Subject = "New Clean Form demo Job Application with Tags Submitted";
		
		$mgsetemple = true;		//Boolean true/false	true: email template	false: plain text email
		$body_message = "";
		if(!$mgsetemple) {
			//prepare email body [for Plain email use this]
			$body_message .= "Applicant IP: " . get_client_ip() ."<br>";
			$body_message .= "Applicant Name: " . $fname ."<br>";
			$body_message .= "Applicant email: " . $email ."<br>";
			$body_message .= "Applicant Phone: " . $phone ."<br>";
			$body_message .= "Applicant Address: " . $address ."<br>";
			$body_message .= "Job Title: " . $jobtitle ."<br>";
			$body_message .= "Applicant Skills: " . $jobskills ."<br>";
			$body_message .= "\n\n". $message;
		}
		else{			
			//prepare email body [Using email template]
			$body_message = file_get_contents('mgsc-email-template/mgsc-email-template-job3.php');
			$mgsemailshorttag = array("[mgs-sender-ip]", "[mgs-sender-name]", "[mgs-sender-email]", "[mgs-sender-phone]", "[mgs-sender-address]", "[mgs-sender-jobtitle]", "[mgs-sender-jobskills]", "[mgs-sender-message]");
			$mgsemailshorttagvalue   = array(get_client_ip(), $fname, $email, $phone, $address, $jobtitle, $jobskills, $message);
			$body_message = str_replace($mgsemailshorttag, $mgsemailshorttagvalue, $body_message);
		}
		
		$mail->Body = $body_message;
		
		$uploadfile = "";
		$uploadfile2 = "";
		$uploadfile3 = "";
		$sname = strtolower(str_replace(" ", "-", $fname));
		if (!empty($_FILES['userfile']['name'])) {
			
			$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
			$uploadfile = 'uploads/' . substr( base_convert( time(), 10, 36 ) . md5( microtime() ), 0, 8 ). '-' . $sname . '.' . $ext;
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
				// Attach the uploaded file
				$mail->addAttachment($uploadfile, $sname .'file-'. $_FILES['userfile']['name']);
			}
			
		}
		if (!empty($_FILES['userfile2']['name'])) {
			
			$ext2 = pathinfo($_FILES['userfile2']['name'], PATHINFO_EXTENSION);
			$uploadfile2 = 'uploads/' . substr( base_convert( time(), 10, 36 ) . md5( microtime() ), 0, 8 ). '-' . $sname . '.' . $ext2;
			if (move_uploaded_file($_FILES['userfile2']['tmp_name'], $uploadfile2)) {
				// Attach the uploaded file
				$mail->addAttachment($uploadfile2, $sname .'file-'. $_FILES['userfile2']['name']);
			}
			
		}
		if (!empty($_FILES['userfile3']['name'])) {
			
			$ext3 = pathinfo($_FILES['userfile3']['name'], PATHINFO_EXTENSION);
			$uploadfile3 = 'uploads/' . substr( base_convert( time(), 10, 36 ) . md5( microtime() ), 0, 8 ). '-' . $sname . '.' . $ext3;
			if (move_uploaded_file($_FILES['userfile3']['tmp_name'], $uploadfile3)) {
				// Attach the uploaded file
				$mail->addAttachment($uploadfile3, $sname .'file-'. $_FILES['userfile3']['name']);
			}
			
		}
		
		//send mail
		if(!$mail->send()) {
			
			//delete files from server
			if (file_exists($uploadfile)){
				unlink($uploadfile);
			}
			if (file_exists($uploadfile2)){
				unlink($uploadfile2);
			}
			if (file_exists($uploadfile3)){
				unlink($uploadfile3);
			}
			echo "Mailer Error: " . $mail->ErrorInfo;
		} 
		else {
			//delete files from server
			if (file_exists($uploadfile)){
				unlink($uploadfile);
			}
			if (file_exists($uploadfile2)){
				unlink($uploadfile2);
			}
			if (file_exists($uploadfile3)){
				unlink($uploadfile3);
			}
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
