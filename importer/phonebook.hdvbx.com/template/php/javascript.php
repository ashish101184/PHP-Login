<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery -->
<script src="<?php echo PATH_DOMAIN; ?>/plugins/jQuery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo PATH_DOMAIN; ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script>
  var AdminLTEOptions = {
	enableControlSidebar: true,
	controlSidebarOptions: { slide: false }
  };
</script>
<script src="<?php echo PATH_DOMAIN; ?>/dist/js/app.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo PATH_DOMAIN; ?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo PATH_DOMAIN; ?>/plugins/fastclick/fastclick.js"></script>
<!-- Bootstrap MaxLength -->
<script src="<?php echo PATH_DOMAIN; ?>/plugins/bootstrap-maxlength.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo PATH_DOMAIN; ?>/dist/js/demo.js"></script>
<!-- Plugins -->
<script src="<?php echo PATH_DOMAIN; ?>/plugins/favico/favico.min.js"></script>
<!-- HD VBX -->
<script type="text/javascript" src="<?php echo PATH_DOMAIN; ?>/template/js/session.php"></script>
<script type="text/javascript" src="<?php echo PATH_DOMAIN; ?>/template/js-plugins/64base.js"></script>
<script type="text/javascript" src="<?php echo PATH_DOMAIN; ?>/template/js-plugins/loadingoverlay.js"></script>
<?php if($_SESSION['user']['access'] == 'a'){
	print '<script type="text/javascript" src="'.PATH_DOMAIN.'/template/js/admin.php"></script>';
} ?>