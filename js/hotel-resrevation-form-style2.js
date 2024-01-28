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
	Book Hotel Room (Format: dd M, yyyy)
|--------------------------------------------------------------------------
*/
	$("#reservation-Date").datepicker({
		title:  'Choose Reservation Date',
		format: "dd M, yyyy",
		startDate: "0d",
		todayBtn: "linked",
		clearBtn: true,
		todayHighlight: true,
		autoclose: true
	}); 

/*
|--------------------------------------------------------------------------
	Reservation Form Process
|--------------------------------------------------------------------------
*/	
	$("#reservationForm").validator().on("submit", function (event) {
		if (event.isDefaultPrevented()) {
			//handle the invalid form...
			formError();
			submitReservationMSG(false, "Please fill in the form properly!");
			sweetAlert("Oops...", "Please fill in the form properly!!! \r\n Check in and Checkout date mandatory!", "error");
		} else {
			
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
						
			if ($("#g-recaptcha-response").val()) {			
			
				if (validphone > 0){
					
					//everything looks good!
					event.preventDefault();
					
					$('#processing-image').show();
					$('#submitButtonHolder').hide();
					
					$.ajax({
						type: "POST",
						url: "hotel-reservation-process2-new.php",
						data: $( "#reservationForm" ).serialize(),
						success : function(text){
							if ($.trim(text) === "success") {
								reservationFormSuccess();
							} else {
								formError();
								submitReservationMSG(false,text);
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
					submitReservationMSG(false, "Please enter valid phone!!!");
					sweetAlert("Oops...", "Please enter valid phone!!!", "error");
					return false;
				}
									
			}
			else{
				submitReservationMSG(false, "You are not a human!!!");
				sweetAlert("Oops...", "Seems! You are not a human!!!", "error");
				return false;
			}
		}
	});
	
	
/*
|--------------------------------------------------------------------------
| Common function
|--------------------------------------------------------------------------
*/	
	
	function reservationFormSuccess(){
		$("#reservationForm")[0].reset();
		submitReservationMSG(true, "Your Reservation Request Submitted Successfully!!!");
		$( "#submitButtonHolder" ).html( '<div class="h3 text-center text-success"> Thank you. We will Confirm you soon!!! </div>' );
		swal("Good job!", "Your Reservation Request Submitted Successfully!!!", "success");
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
	
	function submitReservationMSG(valid, msg){
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
	End
|--------------------------------------------------------------------------
*/