<?php if($_SESSION['loggedin'] == 1){ header('Location: '.PATH_DOMAIN); exit; } ?>
<section class="content">
  <div class="col-xs-offset-1 col-xs-10 col-sm-offset-4 col-sm-4">
	<p>Activation Successful.</p>
	<?php if(!isset($invalid)){ ?>
		<div class="alert alert-success">Your account has been created and your email verified. <a href="<?php print PATH_DOMAIN; ?>">Login</a></div>
	<?php }else{ ?>
		<div class="alert alert-danger">Invalid Link</div>
	<?php } ?>
  </div>
</section>
<?php include(PATH_INCLUDE.'/template/php-nosession/footer.php'); ?>