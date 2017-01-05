<?php if($_SESSION['loggedin'] == 1){ header('Location: '.PATH_DOMAIN); exit; } ?>
<section class="content">
  <div class="col-xs-offset-1 col-xs-10 col-sm-offset-4 col-sm-4">
	<p>Reset your password.</p>
	<?php if(!isset($invalid)){ ?>
	<form action="" method="post" id="resetForm" class="form"> 
		<input id="r" name="r" type="hidden" required="" value="<?php echo $reset; ?>"/>
		<div class="form-group">
			<input id="password" name="password" type="password" placeholder="Password" class="form-control" required="" value=""/>
		</div>
		<div class="form-group">
			<input id="password_confirm" name="password_confirm" type="password" placeholder="Confirm Password" class="form-control" required="" value=""/>
		</div>
		<div class="notifymsg"></div>
		<input type="submit" class="btn btn-primary btn-block" id="resetSubmit" name="resetSubmit" value="Reset Password"/>
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
	$(document).ready(function(){ $("input#password").focus(); });
</script>';
include(PATH_INCLUDE.'/template/php-nosession/footer.php');
?>