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

	var dt = new Date();
/*
|--------------------------------------------------------------------------
	Book Restaurant Table (setDaysOfWeekDisabled)
|--------------------------------------------------------------------------
*/
	$("#preferreddate").datetimepicker({
		format: "dd MM yyyy - HH:ii P",
		showMeridian: true,
		startDate: dt,					//startDate: "0d",	//if need to select past date
		//daysOfWeekDisabled: [0],		//Sunday Off
		todayHighlight: true,
		autoclose: true,
		minuteStep: 5
	});
	
/*
|--------------------------------------------------------------------------
	Quote Form Process
|--------------------------------------------------------------------------
*/	
	$("#quoteForm").validator().on("submit", function (event) {
		if (event.isDefaultPrevented()) {
			//handle the invalid form...
			formError();
			submitQuoteMSG(false, "Please fill in the form properly!");
			sweetAlert("Oops...", "Please fill in the form properly!!!", "error");
		} else {
			
			var phone = $("#phone").val();
			var form_data = new FormData($("#quoteForm")[0]);
			
			if(phone){
				var validphone = isPhone(phone);
				if(!validphone){
					$("#phone").css({"border-width": "2px", "border-color": "#ce0606"});
				}
			}	
			else{
				validphone = 1;
			}
			
			var servicetype = $('input[name=servicetype]:checked').val();
			var bedrooms = $('input[name=bedrooms]:checked').val();
			var sittingroom = $('input[name=sittingroom]:checked').val();
			var bathrooms = $('input[name=bathrooms]:checked').val();
			var rooms = $('input[name=rooms]:checked').val();
			var conferenceroom = $('input[name=conferenceroom]:checked').val();
			var washrooms = $('input[name=washrooms]:checked').val();
				
			if( servicetype == "Residential" ) {
				
				var servicetypepropertychecked1 = '';
				if( bedrooms )
					$( ".validbedrooms .help-block.with-errors" ).html( '' );
				else
					$( ".validbedrooms .help-block.with-errors" ).html( '<ul class="list-unstyled"><li>Please Select Bedrooms</li></ul>' );
				
				if( sittingroom )
					$( ".validsittingroom .help-block.with-errors" ).html( '' );
				else
					$( ".validsittingroom .help-block.with-errors" ).html( '<ul class="list-unstyled"><li>Please Select Guest Room</li></ul>' );
				
				if( bathrooms )
					$( ".validbathrooms .help-block.with-errors" ).html( '' );
				else
					$( ".validbathrooms .help-block.with-errors" ).html( '<ul class="list-unstyled"><li>Please Select Bathrooms</li></ul>' );
				
				if( bedrooms && sittingroom && bathrooms ) {
					var servicetypepropertychecked1 = 1;
				}
				
			}	
			else{
				
				var servicetypepropertychecked2 = '';
				if( rooms )
					$( ".validrooms .help-block.with-errors" ).html( '' );
				else
					$( ".validrooms .help-block.with-errors" ).html( '<ul class="list-unstyled"><li>Please Select Rooms</li></ul>' );
				
				if( conferenceroom )
					$( ".validconferenceroom .help-block.with-errors" ).html( '' );
				else
					$( ".validconferenceroom .help-block.with-errors" ).html( '<ul class="list-unstyled"><li>Please Select Conference Room</li></ul>' );
				
				if( washrooms )
					$( ".validwashrooms .help-block.with-errors" ).html( '' );
				else
					$( ".validwashrooms .help-block.with-errors" ).html( '<ul class="list-unstyled"><li>Please Select Washrooms</li></ul>' );
				
				if( rooms && conferenceroom && washrooms ) {
					var servicetypepropertychecked2 = 1;
				}
				
			}
			if( servicetype == "Residential" )
				var servicetypepropertychecked = servicetypepropertychecked1;
			else
				var servicetypepropertychecked = servicetypepropertychecked2;
			
			
			if (servicetypepropertychecked) {
				if ($("#g-recaptcha-response").val()) {
					
					if (validphone > 0){ 			
						
						//everything looks good!
						event.preventDefault();
						
						$('#processing-image').show();
						$('#submitButtonHolder').hide();
						
						$.ajax({
							type: "POST",
							url: "quote-process3-cond.php",
							data: form_data,
							processData: false,
							contentType: false,
							success : function(text){
								if ($.trim(text) === "success") {
									quoteFormSuccess();
								} else {
									formError();
									submitQuoteMSG(false,text);
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
						submitQuoteMSG(false, "Please enter valid phone!!!");
						sweetAlert("Oops...", "Please enter valid phone!!!", "error");
						return false;
					}
										
				}
				else{
					submitQuoteMSG(false, "You are not a human!!!");
					sweetAlert("Oops...", "Seems! You are not a human!!!", "error");
					return false;
				}
			}
			else{
				submitQuoteMSG(false, "Please select Property Type Info!!!");
				sweetAlert("Oops...", "Please select Property Type Info!!!", "error");
				return false;
			}
		}
	});
	
	
	$(function() {  
		
		$( "#residential-services-box" ).css( 'display', 'none' );
		$( "#commercial-services-box" ).css( 'display', 'none' );
		
		$("input[name='servicetype']").on("click", function() {				
			var servicetype = $('input[name=servicetype]:checked').val();
			
			if( servicetype == "Residential" ) {
				$( "#residential-services-box" ).css( 'display', 'block' );
				$( "#commercial-services-box" ).css( 'display', 'none' );
			}	
			else{
				$( "#commercial-services-box" ).css( 'display', 'block' );
				$( "#residential-services-box" ).css( 'display', 'none' );
			}
			
        });
				
	});
	
/*
|--------------------------------------------------------------------------
	Common function
|--------------------------------------------------------------------------
*/	
	
	function quoteFormSuccess(){
		$("#quoteForm")[0].reset();
		$("#quoteForm").css('display', 'none');
		submitQuoteMSG(true, "Your Quote Request Submitted Successfully!!!");
		$( "#msgContactSubmitDone" ).html( '<div class="h3 text-center text-success"> Thank you. We will get back to you soon!!! </div>' );
		swal("Good job!", "Your Quote Request Submitted Successfully!!!", "success");
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
	
	function submitQuoteMSG(valid, msg){
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