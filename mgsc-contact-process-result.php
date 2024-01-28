<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1"/>
	
	<title>Clean Form - PHP Working Contact Quote Booking JobApply Reservation Multi-purpose Form</title>	
	<!-- set your website meta description and keywords -->
	<meta name="description" content="Add your business website description here">
	<meta name="keywords" content="Add your business website keywords here">
	<!-- set your website favicon -->
	<link href="favicon.ico" rel="icon">
	
	<!-- Font Awesome Stylesheets -->
	<link rel="stylesheet" href="css/fontawesome/all.min.css">
	<!-- sweetalert Stylesheets -->
	<link rel="stylesheet" href="css/sweetalert.css" type="text/css">
	<!-- Template Main Stylesheets -->
	<link rel="stylesheet" href="css/contact-form-php-style2.css" type="text/css">
</head>

<body>	
	<!-- start contact -->
	<section id="contact-form-section" class="contact-form-section">
		<div class="container">
			<div class="formrow">
				<div class="col-12">
					<div class="contact-form-title-wrap">
						<h2 class="title-text"><span>Send me a <strong>Message</strong></span></h2>
						<div class="title-line text-center">
							<span class="short-line"></span>
							<span class="long-line"></span>
						</div><!-- end title-line -->
					</div><!-- end contact-form-title-wrap -->
					<div class="intro-text text-center">
						A wonderful serenity has taken possession of my entire soul like these sweet mornings.
					</div><!-- end intro-text -->
				</div><!--End col-12 -->
				
				<div class="col-8 col-offset-2">
					
					<div class="col-12">
							<div class="title-box">
								<?php 
									if($_REQUEST['mgsfpmsg'] == 'psuccess'){
										echo '<div class="h3 text-center text-success">' .$_REQUEST['sucmsg']. '</div>'; 
								?>
							</div><!-- end title-box -->
								
							<h2 class="success-text text-success">Thanks for Contacting Us</h2>
							<blockquote>
								<p>&nbsp;</p>
								<p>Thank you for getting in touch!</p>
								<p>We appreciate you contacting us. One of our customer happiness members will be getting back to you shortly.</p>
								<p>While we do our best to answer your queries quickly, it may take about 12 hours to receive a response from us during peak hours.</p>
								<p>Thanks in advance for your patience.</p>
								<p>Have a great day!</p>
								<p>&nbsp;</p>
							</blockquote>
							
								<?php
									} elseif($_REQUEST['mgsfpmsg'] == 'perror'){
										echo '<div class="h3 text-center text-danger">' .$_REQUEST['errmsg']. '</div></div>';
										echo '<p class="text-center"><a href="contact-form-php-style-2.html">Back to Form Page</a></p>';
									}
								?>
							
					</div><!-- end col-12 -->
					
				</div><!-- end col-sm-8 -->
				
				<!-- start contact Info -->
				<div class="col-12">
					<div class="contactInfo-wrap">
						<div class="col-12">
							<div class="title-box">
								<h3>Contact <strong>Info</strong></h3>
							</div><!-- end title-box --> 
						</div><!-- end col-12 -->
						<div class="col-4">
							<div class="contact-item">
								<div class="contact-item-inner">
									<div class="contact-icon">
										<i class="fa-solid fa-location-dot"></i>
									</div><!-- end contact-icon -->
									<div class="contact-desc">
										<h4>70 Trent Rd, Luton LU3 1TA</h4>
									</div><!-- end contact-desc -->
								</div><!-- end contact-item-inner -->
							</div><!-- end contact-item -->
						</div><!-- end col-4 -->
						<div class="col-4">
							<div class="contact-item">
								<div class="contact-item-inner">
									<div class="contact-icon">
										<i class="fa-solid fa-envelope"></i>
									</div><!-- end contact-icon -->
									<div class="contact-desc">
										<h4><a href="mailto:sales@yourwebsite.com">sales@website.com</a></h4>
									</div><!-- end contact-desc -->
								</div><!-- end contact-item-inner -->
							</div><!-- end contact-item --> 
						</div><!-- end col-4 -->
						<div class="col-4">
							<div class="contact-item">
								<div class="contact-item-inner">
									<div class="contact-icon">
										<i class="fa-solid fa-phone"></i>
									</div><!-- end contact-icon -->
									<div class="contact-desc">
										<h4><a href="tel:000-0000-0000">+000 0000 0000</a></h4>
									</div><!-- end contact-desc -->
								</div><!-- end contact-item-inner --> 
							</div><!-- end contact-item --> 
						</div><!-- end col-4 -->
					</div><!-- end contactInfo-wrap -->
				</div><!-- end col-12 -->
				<!-- end contact Info -->
				
			</div><!-- end formrow -->
			
			<div class="formrow">					
				<div class="footer-top col-12">
					<p class="text-center copyright">&copy; <script>document.write(new Date().getFullYear())</script> Clean Form. <a href="https://1.envato.market/AYdWK" class="footer-site-link" target="_blank">MGScoder</a> All rights reserved. <a href="https://codecanyon.net/item/clean-form-php-working-contact-quote-booking-jobapply-reservation-multipurpose-form/21155924?ref=mgscoder" class="footer-site-link">Buy Clean Form Script</a></p>
				</div><!-- end col --> 
			</div><!-- end formrow -->
			
		 </div><!-- end container --> 
	</section>
	<!-- end contact -->
	
	<!-- jQuery Library -->
	<script src="js/jquery-3.5.1.min.js"></script>
	<!-- sweetalert Js -->
    <script src="js/sweetalert.min.js"></script>
	<script>
		<?php if($_REQUEST['mgsfpmsg'] == 'psuccess'){ ?>
		swal("Good job!", "<?php echo $_REQUEST['sucmsg']; ?>", "success");
		<?php } elseif($_REQUEST['mgsfpmsg'] == 'perror'){ ?>
		sweetAlert("Oops...", "<?php echo $_REQUEST['errmsg']; ?>", "error");
		<?php } ?>
	</script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-93541536-2', 'auto');
	  ga('send', 'pageview');

	</script>
	
</body>
</html>