function hideActive(radioGroupName) {
      var all = document.getElementById(radioGroupName).value;
      if(all == "fill_form"){
		document.getElementById('div_form').style.display = 'block';
		document.getElementById('div_cv').style.display = 'none';
	  }else{
		document.getElementById('div_form').style.display = 'none';
		document.getElementById('div_cv').style.display = 'block';
	  }
    }
jQuery('document').ready(function($){	
	$('.refresh_captcha').click( function(event) {
		event.preventDefault(); 
		event.stopPropagation();
		var urls = document.getElementById('urls').value;
		$.ajax({
			type: "GET",
			url:"wp-admin/admin-ajax.php",
			data: {action:'rctjp_re_captcha',data:''},
			success: function(response) {
				$('#rtcjp_captcha_session_cv').val(response);
				$('#rtcjp_captcha_session').val(response);
				$('.cap').attr('src', urls+'/templates/captcha.php?' + (new Date).getTime());
			}
		});

	});
	$('#position_applay').change( function() {
		var hide_value = $("#position_applay").attr("value");
		$("#position_applay2").val(hide_value);
	});
	
	$(function() {	
		$("#application_form").validate({
			success: function(label,element) {
                label.hide();  
            },
			rules: {
				position_applay : "required",
				cv:"required",
				p_name : "required",
				rtcjp_captcha_cv : "required",
			},
			messages : {
				position_applay : "Please select applay position",
				cv:"please upload your resume",
				p_name : "Please enter your name",
				rtcjp_captcha_cv: {required: "Please enter the verifcation code."}
			},
			
			submitHandler: function(form) {
				var captcha = $("#rtcjp_captcha_cv").attr("value");
				var captcha_session = $("#rtcjp_captcha_session_cv").attr("value");
				if( captcha_session == captcha){
					form.submit();
				}else{
					$('#rtcjp_captcha_cv').val('');
					$("#captcha-error-cv").html("<h4 style='color:red'>Please enter right captcha</h4>");	
					return false;
				}
				
			}
		});
	})
	//jQuery Captcha Validation
    
	$(function() {
		$("#application_form2").validate({
			
			success: function(label,element) {
                label.hide();  
            },
			rules: {
				p_name: "required",
				age:{
					required: true,
                    number: true,
					maxlength : 2
				},
				city: "required",
				phone_number: {
					required: true,
                    number: true, 
					maxlength : 10
				},
				qualification: "required",
				ssc_school:"required",
				ssc_year: {
					required: true,
                    number: true,
					maxlength : 4
				},
				ssc_mark: {
					required: true,
                    number: true,
					maxlength : 5,
					max:100
				},
				ssc_location: "required",
				hsc_school:"required",
				hsc_year: {
					required: true,
                    number: true,
					maxlength : 4,
					
				},
				hsc_mark: {
					required: true,
                    number: true,
					maxlength :5,
					max:100
				},
				hsc_location: "required",
				skill_strength: "required",
				roles: "required",
				dislike_company: "required",
				change_reason:"required",
				family_bg: "required",
				gdu_year:{	number:true,maxlength : 4 },
				gdu_mark:{	number:true, maxlength : 5,max:100 },
				pg_year:{	number:true, maxlength : 4 },
				pg_mark:{	number:true, maxlength : 5, max:100 },
				otr_year:{	number:true, maxlength : 4 },
				otr_mark:{	number:true, maxlength : 5,max:100 },
				salary:{
					required: true,
                    number: true,
					maxlength : 10
				},
				rtcjp_captcha:"required",
			
			},
			messages: {
				p_name: "Please enter your name",
				age:{
					required: "Please enter your age",
                    number: "Invalid Age. Please enter only numeric value",
					maxlength : "Invalid Age. please enter 2 digit value"
				},
				city : "Please enter your city",
				phone_number : {
					required: "Please enter phone number",
					number: "Invalid phone number. Please enter only numeric value",
					maxlength : "Invalid phone number. Please enter 10 digit number"
				},
				qualification: "Please enter your qualification",
				ssc_school:"Please enter your SSC school name",
				ssc_year: {
					required: "Please enter your SSC passing year",
                    number: "Invalid year. Please enter only numeric value",
					maxlength : "Only four digit allow"
				},
				ssc_mark: {
					required: "Please enter your SSC mark",
                    number: "Invalid mark. Please enter only numeric value",
					maxlength : "Only five digit allow",
					max:"maximum value is 100"
				},
				ssc_location: "Please enter location of SSC school",
				hsc_school:"Please enter your SSC school name",
				hsc_year: {
					required: "Please enter your SSC passing year",
                    number: "Invalid year. Please enter only numeric value",
					maxlength : "Only four digit allow"
				}, 
				hsc_mark: {
					required: "Please enter your SSC mark",
                    number: "Invalid mark. Please enter only numeric value",
					maxlength : "Only five digit allow",
					max:"maximum value is 100"
				},
				hsc_location: "Please enter location of SSC school",
				gdu_year:{	number: "Invalid year. Please enter only numeric value", maxlength : "Only four digit allow" },
				gdu_mark:{	number: "Invalid mark. Please enter only numeric value", maxlength : "Only five digit allow", max:"maximum value is 100" },
				pg_year:{	number: "Invalid year. Please enter only numeric value", maxlength : "Only four digit allow" },
				pg_mark:{	number: "Invalid mark. Please enter only numeric value", maxlength : "Only five digit allow", max:"maximum value is 100" },
				otr_year:{	number: "Invalid year. Please enter only numeric value", maxlength : "Only four digit allow" },
				otr_mark:{	number: "Invalid mark. Please enter only numeric value", maxlength : "Only five digit allow", max:"maximum value is 100" },
				salary:{
					required: "Please enter your salary",
                    number: "Invalid salary. Please enter only numeric value",
					maxlength : "Only ten digit allow"
				},
				skill_strength: "Please enter your skill and srength",
				roles: "Please enter your roles of current company",
				dislike_company: "Please enter your disk like or like about current company",
				change_reason:"Please enter reason for leave current company",
				family_bg: "Please enter your family background",
				rtcjp_captcha: {
                    required: "Please enter the verifcation code.",
                   
                }
				
			},
			submitHandler: function(form) {
				$('#fill_up_form').attr('disabled','disabled');
				var position = $("#position_applay2").attr("value");
				var captcha_session = $("#rtcjp_captcha_session").attr("value");
				var captcha = $("#rtcjp_captcha").attr("value");
				var capch = '<?php echo $cap; ?>';
				var urls = document.getElementById('urls').value;
				if(position){
					if( captcha_session == captcha){
						var datastring = $("#application_form2").serializeArray();
						$.ajax({
							type: "POST",
							url: "wp-admin/admin-ajax.php",
							data: {action : "rctjp_contact_send_mail" ,data:datastring},
							success: function(data) {
								$('#fill_up_form').removeAttr('disabled');
								form.submit();
								$("#simple-msg").html("<h3 style='color:green'>Apply Sucessfully</h3>");
							}
						});
					}else{
						$('#fill_up_form').removeAttr('disabled');
						$('#rtcjp_captcha').val('');
						$("#captcha-error").html("<h4 style='color:red'>Please enter right captcha</h4>");	
						return false;
					}
				}else{
					$('#fill_up_form').removeAttr('disabled');
					$("#simple-msg").html("<h3 style='color:green'>Please select apply position</h3>");
					//alert("Please select applay position");
					return false;
				}	
				return true;
			}
		});
	});
});
