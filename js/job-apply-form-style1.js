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
	Job Application Form Process
|--------------------------------------------------------------------------
*/	
	$("#jobapplyForm").validator().on("submit", function (event) {
		if (event.isDefaultPrevented()) {
			//handle the invalid form...
			formError();
			submitJobapplyMSG(false, "Please fill in the form properly!");
			sweetAlert("Oops...", "Please fill in the form properly!!!", "error");
		} else {
			var mathPart_1 = parseInt( $("#mathfirstnum").val(), 10 );
			var mathPart_2 = parseInt( $("#mathsecondnum").val(), 10 );      
			var correctMathSolution = parseInt( ( mathPart_1 + mathPart_2 ), 10 );
			var inputHumanAns = $("#humanCheckCaptchaInput").val();
			
			var phone = $("#phone").val();
			var form_data = new FormData($("#jobapplyForm")[0]);                  
			form_data.append('file', form_data);
			
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
						url: "job-application.php",
						data : form_data,
						processData: false,
						contentType: false,
						success : function(text){
							if ($.trim(text) === "success") {
								jobapplyFormSuccess();
							} else {
								formError();
								submitJobapplyMSG(false,text);
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
					submitJobapplyMSG(false, "Please solve Human Check Captcha!!!");
					sweetAlert("Oops...", "Please solve Human Captcha!!!", "error");
					return false;
				}
					
			}
			else{
				submitJobapplyMSG(false, "Please enter valid phone!!!");
				sweetAlert("Oops...", "Please enter valid phone!!!", "error");
				return false;
			}
		}
	});
	
	//handle the attached file to show attached file name in the form field
	$(function() {

		$(document).on('change', ':file', function() {
			var input = $(this),
				numFiles = input.get(0).files ? input.get(0).files.length : 1,
				label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			input.trigger('fileselect', [numFiles, label]);
		});

		$(':file').on('fileselect', function(event, numFiles, label) {

			var input = $(this).parents('.form-group').find(':text'),
				log = numFiles > 1 ? numFiles + ' files selected' : label;

			if( input.length ) {
				input.val(log);
			} else {
				if( log ) alert(log);
			}

		});
	  
	});
	
	
/*
|--------------------------------------------------------------------------
	Common function
|--------------------------------------------------------------------------
*/	
	
	function jobapplyFormSuccess(){
		$("#jobapplyForm")[0].reset();
		submitJobapplyMSG(true, "Your Application Submitted Successfully!!!");
		$( "#submitButtonHolder" ).html( '<div class="h3 text-center text-success"> Thank you for Your interest!!! </div>' );
		swal("Good job!", "Your Application Submitted Successfully!!!", "success");
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
	
	function submitJobapplyMSG(valid, msg){
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