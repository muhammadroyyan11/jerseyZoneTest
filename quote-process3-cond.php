<?php
	$errormsg = "";
	
	if (empty($_POST["cleaningtype"])) {
		$errormsg .= "Cleaning Type required. ";
	} else {
		$cleaningtype = filter_var($_POST['cleaningtype'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if (empty($_POST["propertysize"])) {
		$errormsg .= "ProPerty Size required. ";
	} else {
		$propertysize = filter_var($_POST['propertysize'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if (empty($_POST["servicetype"])) {
		$errormsg .= "Property Type required. ";
	} else {
		$servicetype = filter_var($_POST['servicetype'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if ( $_POST["servicetype"] == "Residential" ) {
		
		if (empty($_POST["bedrooms"])) {
			$errormsg .= "Bedrooms required. ";
		} else {
			$bedrooms = filter_var($_POST['bedrooms'], FILTER_SANITIZE_NUMBER_INT);
		}
		if (empty($_POST["sittingroom"])) {
			$errormsg .= "Guest Room required. ";
		} else {
			$sittingroom = filter_var($_POST['sittingroom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		if (empty($_POST["bathrooms"])) {
			$errormsg .= "Bathrooms required. ";
		} else {
			$bathrooms = filter_var($_POST['bathrooms'], FILTER_SANITIZE_NUMBER_INT);
		}
		
	}
	else {
		
		if (empty($_POST["rooms"])) {
			$errormsg .= "Rooms required. ";
		} else {
			$rooms = filter_var($_POST['rooms'], FILTER_SANITIZE_NUMBER_INT);
		}
		if (empty($_POST["conferenceroom"])) {
			$errormsg .= "Conference Room required. ";
		} else {
			$conferenceroom = filter_var($_POST['conferenceroom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		if (empty($_POST["washrooms"])) {
			$errormsg .= "Washrooms required. ";
		} else {
			$washrooms = filter_var($_POST['washrooms'], FILTER_SANITIZE_NUMBER_INT);
		}
		
	}	
		
	if (empty($_POST["kitchen"])) {
		$errormsg .= "Kitchen required. ";
	} else {
		$kitchen = filter_var($_POST['kitchen'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if (empty($_POST["kitchenitems"])) {
		$errormsg .= "Kitchen Items required. ";
	} else {
		$kitchenitems = implode(", ",$_POST["kitchenitems"]);
		$kitchenitems = filter_var($kitchenitems, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if (empty($_POST["propertyaddress"])) {
		$errormsg .= "Property Address required. ";
	} else {
		$propertyaddress = filter_var($_POST['propertyaddress'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if (empty($_POST["preferreddate"])) {
		$errormsg .= "Preferred Date required. ";
	} else {
		$preferreddate = filter_var($_POST['preferreddate'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
		
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
			$mail->Subject = "New Clean Form Demo Cleaning Service Quotation Request Submitted";
		
		$mgsetemple = true;		//Boolean true/false	true: email template	false: plain text email
		$body_message = "";
		if(!$mgsetemple) {
			//prepare email body [for Plain email use this]
			$body_message .= "Sender IP: " . get_client_ip() ."<br>";
			$body_message .= "Required Cleaning Type: " . $cleaningtype ."<br>";
			$body_message .= "ProPerty Size: " . $propertysize ."sq. ft.<br>";
			$body_message .= "Selected Property Type: " . $servicetype ."<br>";
					
			if ( $_POST["servicetype"] == "Residential" ) {
				$body_message .= "Bedrooms: " . $bedrooms ."<br>";
				$body_message .= "Guest Room: " . $sittingroom ."<br>";
				$body_message .= "Bathrooms: " . $bathrooms ."<br>";
			}
			else {
				$body_message .= "Rooms: " . $rooms ."<br>";
				$body_message .= "Conference Room: " . $conferenceroom ."<br>";
				$body_message .= "Washrooms: " . $washrooms ."<br>";
			}	
			
			$body_message .= "Kitchen: " . $kitchen ."<br>";
			$body_message .= "Kitchen Items: " . $kitchenitems ."<br>";
			$body_message .= "Preferred Date: " . $preferreddate ."<br>";
			$body_message .= "Property Address: " . $propertyaddress ."<br>";
			$body_message .= "\n\n";
			$body_message .= "Customer Full Name: " . $fname ."<br>";
			$body_message .= "Customer email: " . $email ."<br>";
			$body_message .= "Customer Phone: " . $phone ."<br>";
			$body_message .= "Short Note: " . $message ."<br>";
		}
		else{			
			//prepare email body [Using email template]
			if ( $_POST["servicetype"] == "Residential" ) {
				$body_message = file_get_contents('mgsc-email-template/mgsc-email-template-quote-residential.php');
				$mgsemailshorttag = array("[mgs-sender-ip]", "[mgs-sender-required-cleaning-type]", "[mgs-sender-property-size]", "[mgs-sender-selected-property-type]", "[mgs-sender-property-bedrooms]", "[mgs-sender-property-bathrooms]", "[mgs-sender-property-sittingroom]", "[mgs-sender-property-kitchen]", "[mgs-sender-property-kitchenitems]", "[mgs-sender-preferreddate]", "[mgs-sender-property-address]", "[mgs-sender-name]", "[mgs-sender-email]", "[mgs-sender-phone]", "[mgs-sender-message]");
				$mgsemailshorttagvalue   = array(get_client_ip(), $cleaningtype, $propertysize, $servicetype, $bedrooms, $bathrooms, $sittingroom, $kitchen, $kitchenitems, $preferreddate, $propertyaddress, $fname, $email, $phone, $message);
				$body_message = str_replace($mgsemailshorttag, $mgsemailshorttagvalue, $body_message);
			}
			else {
				$body_message = file_get_contents('mgsc-email-template/mgsc-email-template-quote-commercial.php');
				$mgsemailshorttag = array("[mgs-sender-ip]", "[mgs-sender-required-cleaning-type]", "[mgs-sender-property-size]", "[mgs-sender-selected-property-type]", "[mgs-sender-property-rooms]", "[mgs-sender-property-conferenceroom]", "[mgs-sender-property-washrooms]", "[mgs-sender-property-kitchen]", "[mgs-sender-property-kitchenitems]", "[mgs-sender-preferreddate]", "[mgs-sender-property-address]", "[mgs-sender-name]", "[mgs-sender-email]", "[mgs-sender-phone]", "[mgs-sender-message]");
				$mgsemailshorttagvalue   = array(get_client_ip(), $cleaningtype, $propertysize, $servicetype, $rooms, $conferenceroom, $washrooms, $kitchen, $kitchenitems, $preferreddate, $propertyaddress, $fname, $email, $phone, $message);
				$body_message = str_replace($mgsemailshorttag, $mgsemailshorttagvalue, $body_message);
			}
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
