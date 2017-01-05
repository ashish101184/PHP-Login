<?php if($_SESSION['loggedin'] == 1){ header('Location: '.PATH_DOMAIN); exit; } ?>
<section class="content">
  <div class="col-xs-offset-1 col-xs-10 col-sm-offset-4 col-sm-4">
	<p>Sign in to start your session</p>
	<form action="" method="post" id="loginForm" class="form"> 
	  <div class="form-group has-feedback">
		<input type="email" class="form-control" placeholder="Email" value="<?php echo isset($_COOKIE['remember_me'])?$_COOKIE['remember_me']:'';?>" id="email" name="email" required=""/>
		<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	  </div>
	  <div class="form-group has-feedback">
		<input type="password" class="form-control" placeholder="Password" value="" id="password" name="password" required=""/>
		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	  </div>
	  <div class="form-group">
		  	<div class="g-recaptcha" data-sitekey="<?php echo $publickey; ?>" data-callback="captcha_callback"></div>
            <script type="text/javascript"
                    src="https://www.google.com/recaptcha/api.js">
            </script>
	  </div>
	  <div class="notifymsg"></div>
	  <div class="row">
		<div class="col-xs-8">
		  <div class="checkbox icheck">
			<label>
			  <input type="checkbox" id="remember" <?php echo isset($_COOKIE['remember_me'])?'checked="checked"':'';?> />Remember Me
			</label>
		  </div>
		</div>
		<div class="col-xs-4">
		  <input type="submit" class="btn btn-primary btn-block btn-flat" id="signin" value="Sign In"/>
		</div>
	  </div>
	<a href="#" data-toggle="modal" data-target="#forgotModal">Forgot Password</a><br/>
	<a href="<?php print PATH_DOMAIN ?>/register" class="text-center">Register a new membership</a>
	</form>
  </div>
  <div class="col-md-4"></div>
</section>
<div class="modal fade" id="forgotModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" id="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Forgot Password</h4>
			</div>
			<form action="" method="post" id="forgotForm" class="form"> 
				<div class="modal-body">
					<h4 class="title">Enter your email address and press send to receive an email with a link to reset your password.</h4>
					<input placeholder="Your Email Address" id="forgotemail" name="forgotemail" class="form-control" type="text">
					<div class="notifymsg"></div>
				</div>
				<div class="modal-footer">
					<input class="btn btn-success" name="forgotSubmit" id="forgotSubmit" value="Send" type="submit">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
isset($_COOKIE['remember_me'])?$focus='password':$focus='email';
$footer_javascript = '
<script src="'.PATH_DOMAIN.'/template/js-plugins/loadingoverlay.js"></script>
<script src="'.PATH_DOMAIN.'/template/js/nosession.js"></script>
<script type="text/javascript">
	$(document).ready(function(){ $("input#'.$focus.'").focus(); });
</script>';
include(PATH_INCLUDE.'/template/php-nosession/footer.php');
?>