$(document).ready(function(){
	
	$('form#loginForm').submit(function(){
		var email = $('input#email'),
			password = $('input#password'),
			hiddenRecaptcha = $('#g-recaptcha-response').val(),
            msg = '',
			notifymsg = $('.notifymsg');
		var elementOverlay = $('form#loginForm'); elementOverlay.LoadingOverlay("show");
		notifymsg.html('');
		if(email.val() == '') {
			notifymsg.show();
			notifymsg.html('<div class="alert alert-danger help-block">Please enter an email address.</div>');
			email.focus();
		}else if (hiddenRecaptcha == ''){
			notifymsg.show();
			notifymsg.html('<div class="alert alert-danger help-block">Captcha needed.</div>');
		}else{
			$.ajax({
				type : 'POST',
				dataType : 'json',
				data: {
					action: 'login',
					email: email.val(),
					password: password.val(),
					hiddenRecaptcha: hiddenRecaptcha
				},
				url  : '/includes/index-query.php',
				success: function(responseText){
                  if(responseText.response != 'success'){
						password = ''; hiddenRecaptcha = '';
						if(responseText.response == 'fail'){
							msg = "Email required.";						
						}else if(responseText.response == 'fail_captcha'){
							msg = 'Captcha Mismatched!';
						}else if(responseText.response == 'fail_login'){
							msg = 'Username or Password Incorrect!';						
						}else if(responseText.response == 'fail_acclocked'){
							msg = 'User Locked Out.';						
						}else if(responseText.response == 'fail_verify'){
							msg = 'Account not verified.';						
						}
						else{
							msg = 'Problem logging in... Please try again.';
						}
						notifymsg.show();
						notifymsg.html('<div class="alert alert-danger help-block">' + msg + '</div>');
				  }else{
					  $('#loginForm').html('<div class="alert alert-success">Logging in.</div>');
					  window.location.href = 'https://'+window.location.hostname;
				  }
				}
			});
		}
		elementOverlay.LoadingOverlay("hide", true);
		return false;
	});
	
	$("#forgotModal").on("shown.bs.modal", function () {
		$('form#forgotForm').reset;
		$("#email").focus();
	});
	
	$('form#forgotForm').submit(function(){
		var email = $('input#forgotemail'),
            msg = '',
			notifymsg = $('.notifymsg');
		var elementOverlay = $('form#forgotForm'); elementOverlay.LoadingOverlay("show");
		notifymsg.html('');
		if(email.val() == '') {
			notifymsg.show();
			notifymsg.html('<div class="alert alert-danger help-block">Please enter an email address.</div>');
			email.focus();
		} else {
			$.ajax({
				type : 'POST',
				dataType : 'json',
				data: {
					action: 'forgot',
					email: email.val()
				},
				url  : '/includes/index-query.php',
				success: function(responseText){
                  if(responseText.response != 'success'){
						if(responseText.response == 'fail'){
							msg = "Email required.";
						}else if(responseText.response == 'fail_invalid'){
							msg = "Email address does not exist.";
						}
						notifymsg.show();
					  	notifymsg.html('<div class="alert alert-danger help-block">' + msg + '</div>');
				  }else{
				 	$('.modal-body').html('<div class="alert alert-success">Email has been sent. Click the link in the email to reset your password.</div>');
					$("#forgotSubmit").attr("disabled", "true");
				  }
				}
			});
		}
		elementOverlay.LoadingOverlay("hide", true);
		return false;
	});
	
	$('form#registerForm').submit(function(){
		var firstname = $('#firstname'),
			lastname = $('#lastname'),
			country = $('#country'),
			email = $('#email'),
			password = $('#password'),
			password_confirm = $('#password_confirm'),
            hiddenRecaptcha = $('#g-recaptcha-response').val(),
			msg = '',
			notifymsg = $('.notifymsg');
		$.LoadingOverlay("show");
		notifymsg.html('');
		if(firstname.val() == '' || lastname.val() == '' || country.val() == '' || email.val() == '' || password.val() == '' || password_confirm.val() == ''){
            notifymsg.show();
			notifymsg.html('<div class="alert alert-danger help-block">All fields required!</div>');
		}else if(password.val() != password_confirm.val()){
			password.val(''); password_confirm.val('');			
            notifymsg.show();
			notifymsg.html('<div class="alert alert-danger help-block">Passwords do not match!</div>');
			password.focus();
		}else if (hiddenRecaptcha == ''){
			notifymsg.show();
			notifymsg.html('<div class="alert alert-danger help-block">Captcha needed.</div>');
		}else{
			$.ajax({
			type : 'POST',
			dataType : 'json',
			data: {
				action: 'register',
				firstname: firstname.val(),
				lastname: lastname.val(),
				country: country.val(),
				email: email.val(),
				p: password.val(),
				pc: password_confirm.val()
			},
			url  : '/includes/index-query.php',
			success: function(responseText){
            	if(responseText.response != 'success'){
					password.val(''); password_confirm.val('');
					if(responseText.response == 'fail'){
						msg = 'All fields required.';
					}else if(responseText.response == 'fail_match'){
						msg = 'Passwords do not match.';
					}else if(responseText.response == 'fail_exists'){
						msg = 'Account already exists.';
					}else if(responseText.response == 'fail_db'){
						msg = responseText.details;
					}else{
						msg = 'Problem registering. Please try again.';
					}
					notifymsg.show();
					notifymsg.html('<div class="alert alert-danger help-block">' + msg + '</div>');
				}else{
					$('#registerForm').html('<div class="alert alert-success">Please check your emails for the confirmation email.</div>');
					setTimeout(function() { 
						window.location.href = 'https://'+window.location.hostname;
					}, 4000);
				}
            }
			});
		}
		$.LoadingOverlay("hide", true);
		return false;
	});
	
	$('form#resetForm').submit(function(){
		var r = $('#r').val(),
			password = $('#password'),
			password_confirm = $('#password_confirm'),
            msg = '',
			notifymsg = $('.notifymsg');
		$.LoadingOverlay("show");
		notifymsg.html('');
		if(password.val() != password_confirm.val()){
			password.val(''); password_confirm.val('');			
            notifymsg.show();
			notifymsg.html('<div class="alert alert-danger help-block">Passwords do not match!</div>');
			password.focus();
		}
        else{
			$.ajax({
			type : 'POST',
			dataType : 'json',
			data: {
				action: 'reset',
				r: r,
				p: password.val(),
				pc: password_confirm.val()
			},
			url  : '/includes/index-query.php',
			success: function(responseText){
            	if(responseText.response != 'success'){
					password.val(''); password_confirm.val('');
					if(responseText.response == 'fail'){
						msg = 'All fields required.';
					}else if(responseText.response == 'fail_match'){
						msg = 'Passwords do not match.';
					}else if(responseText.response == 'fail_acclocked'){
						msg = 'Account locked out.';
					}else if(responseText.response == 'fail_verify'){
						msg = 'Account not verified.';
					}else if(responseText.response == 'fail_invalid'){
						msg = 'Invalid reset link.';
					}               
					else{
						msg = 'Problem resetting password. Please try again.';
					}
					notifymsg.show();
					notifymsg.html('<div class="alert alert-danger help-block">' + msg + '</div>');
				}else{
					$('#resetForm').html('<div class="alert alert-success">Password has been reset. Redirecting to login page...</div>');
					setTimeout(function() { 
						window.location.href = 'https://'+window.location.hostname;
					}, 2000);
				}
            }
			});
		}
		$.LoadingOverlay("hide", true);
		return false;
	});
});