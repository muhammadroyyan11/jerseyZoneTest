/*
|--------------------------------------------------------------------------
	Clean Form - PHP Working Contact Quote Booking JobApply Reservation Multi-purpose Form Main JS
	Author: MGScoder
	Author URL: https://codecanyon.net/user/mgscoder
|--------------------------------------------------------------------------
*/
document.addEventListener("touchstart", function() {},false);
(function ($) {
	"use strict";
	
/*
|--------------------------------------------------------------------------
	Math Captcha
|--------------------------------------------------------------------------
*/	
	$(function(){
	
		var randNumber_1 = parseInt( Math.ceil( Math.random() * 15 ), 10 );
		var randNumber_2 = parseInt( Math.ceil( Math.random() * 15 ), 10 );       
		humanCheckCaptcha(randNumber_1, randNumber_2);
	 
	});
	function humanCheckCaptcha(randNumber_1, randNumber_2){
		$( "#humanCheckCaptchaBox" ).html( "Solve The Math " );
		$( "#firstDigit" ).html( '<input name="mathfirstnum" id="mathfirstnum" class="form-control" type="text" value="' + randNumber_1 + '" readonly>' );
		$( "#secondDigit" ).html( '<input name="mathsecondnum" id="mathsecondnum" class="form-control" type="text" value="' + randNumber_2 + '" readonly>' );
	} 

/*
|--------------------------------------------------------------------------
	Contact Form Process
|--------------------------------------------------------------------------
*/	
	$("#contactForm").validator().on("submit", function (event) {
		if (event.isDefaultPrevented()) {
			//handle the invalid form...
			formError();
			submitContactMSG(false, "Please fill in the form properly!");
			sweetAlert("Oops...", "Please fill in the form properly!!!", "error");
		} else {
			var mathPart_1 = parseInt( $("#mathfirstnum").val(), 10 );
			var mathPart_2 = parseInt( $("#mathsecondnum").val(), 10 );       
			var correctMathSolution = parseInt( ( mathPart_1 + mathPart_2 ), 10 );
			var inputHumanAns = $("#humanCheckCaptchaInput").val();
			
			var phone = $("#phone").val();
			
			if(phone){
				var validphone = isPhone(phone);
				if(!validphone){
					$("#phone").css({"border-width": "2px", "border-color": "#ce0606"});
				}
			}	
			else{
				validphone = 1;
			}
			
			
			if (validphone > 0){
				if (inputHumanAns == correctMathSolution){ 
					//everything looks good!
					event.preventDefault();
					
					$('#processing-image').show();
					$('#submitButtonHolder').hide();
					
					$.ajax({
						type: "POST",
						url: "contact-process.php",
						data: $( "#contactForm" ).serialize(),
						success : function(text){
							if ($.trim(text) === "success") {
								contactFormSuccess();
							} else {
								formError();
								submitContactMSG(false,text);
								sweetAlert("Oops...", text, "error");
							}
						},
						complete: function(){
							$('#processing-image').hide();
							$('#submitButtonHolder').show();
						}
					});
					
				}
				else{
					submitContactMSG(false, "Please solve Human Check Captcha!!!");
					sweetAlert("Oops...", "Please solve Human Captcha!!!", "error");
					return false;
				}
					
			}
			else{
				submitContactMSG(false, "Please enter valid phone!!!");
				sweetAlert("Oops...", "Please enter valid phone!!!", "error");
				return false;
			}
		}
	});
	
	
/*
|--------------------------------------------------------------------------
	Common function
|--------------------------------------------------------------------------
*/	
	
	function contactFormSuccess(){
		$("#contactForm")[0].reset();
		submitContactMSG(true, "Your Message Submitted Successfully!!!");
		$( "#submitButtonHolder" ).html( '<div class="h3 text-center text-success"> Thank you. We will get back to you soon!!! </div>' );
		swal("Good job!", "Your Message Submitted Successfully!!!", "success");
	}
	
	function isPhone(phone) {
		var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
		if (filter.test(phone)) {
			var validphone = 1;
		}
		else{
			var validphone = 0;
		}
		return validphone;
	}
	
	function formError(){
		$(".help-block.with-errors").removeClass('hidden');
	}
	
	function submitContactMSG(valid, msg){
		if(valid){
			var msgClasses = "h3 text-center text-success";
		} else {
			var msgClasses = "h3 text-center text-danger";
		}
		$("#msgContactSubmit").removeClass().addClass(msgClasses).text(msg);
		return false;
	}	
	
	
/*
|--------------------------------------------------------------------------
	Print Current Year in html footer copyright
|--------------------------------------------------------------------------
*/
	$('span#mgsYear').html( new Date().getFullYear() );
	
		
})(jQuery);
	

/*
|--------------------------------------------------------------------------
	Google Map
|--------------------------------------------------------------------------
*/
	function myMap() {
		var mapCanvas = document.getElementById("map");
		  var mapOptions = {
			center: new google.maps.LatLng(51.899124, -0.438638),
			zoom: 12,
			scrollwheel: false,
			styles: [
            {
				featureType: 'water',
				elementType: 'geometry',
				stylers: [{color: '#0147fe'}]
            }
          ]

		}
		var map = new google.maps.Map(mapCanvas, mapOptions);
		
		var infowindow = new google.maps.InfoWindow({
			content:'<div class="map-marker"><h3>Company Name</h3><p>70 Trent Rd, Luton LU3 1TA, UK.</p></div>'
		});
		
		var marker = new google.maps.Marker({
			position:  new google.maps.LatLng(51.899124, -0.438638),
			map: map,
			title: 'Company Name'
		});
		marker.addListener('click', function() {
			infowindow.open(map, marker);
        });

	}
/*
|--------------------------------------------------------------------------
	End
|--------------------------------------------------------------------------
*/