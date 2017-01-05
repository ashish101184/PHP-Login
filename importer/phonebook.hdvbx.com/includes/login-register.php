<?php if($_SESSION['loggedin'] == 1){ header('Location: '.PATH_DOMAIN); exit; } ?>
<section class="content">
  <div class="col-xs-offset-1 col-xs-10 col-sm-offset-4 col-sm-4">
	<p>Register.</p>
	<?php if(!isset($invalid)){ ?>
	<form action="" method="post" id="registerForm" class="form"> 
		<div class="form-group has-feedback">
			<input type="firstname" class="form-control" placeholder="Firstname" value="" id="firstname" name="firstname" required=""/>
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		</div>
		<div class="form-group has-feedback">
			<input type="lastname" class="form-control" placeholder="Lastname" value="" id="lastname" name="lastname" required=""/>
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		</div>
		<div class="form-group has-feedback">
			<input type="email" class="form-control" placeholder="Email" value="" id="email" name="email" required=""/>
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		</div>
		<div class="form-group has-feedback">
			<input type="text" class="form-control" placeholder="Country" value="" id="country" name="country" required=""/>
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		</div>
		<div class="form-group has-feedback">
			<input type="password" class="form-control" placeholder="Password" value="" id="password" name="password" required=""/>
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>
		<div class="form-group has-feedback">
			<input type="password" class="form-control" placeholder="Confirm Password" value="" id="password_confirm" name="password_confirm" required=""/>
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>
		<div class="form-group">
			<div class="g-recaptcha" data-sitekey="<?php echo $publickey; ?>" data-callback="captcha_callback"></div>
			<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
		</div>
		<div class="notifymsg"></div>
		<input type="submit" class="btn btn-primary btn-block" id="registerSubmit" name="registerSubmit" value="Register"/>
	</form>
	<?php }else{ ?>
		<div class="alert alert-danger">Invalid Link</div>
	<?php } ?>
  </div>
</section>
<?php $footer_javascript = '
<script src="'.PATH_DOMAIN.'/template/js-plugins/loadingoverlay.js"></script>
<script src="'.PATH_DOMAIN.'/template/js/nosession.js"></script>
<script type="text/javascript">
	$(document).ready(function(){ $("input#firstname").focus(); });
</script>';
include(PATH_INCLUDE.'/template/php-nosession/footer.php');
?>