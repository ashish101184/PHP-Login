<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard | HD VBX</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"/>
  <link rel="stylesheet" href="<?php echo PATH_DOMAIN; ?>/bootstrap/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"/>
  <link rel="stylesheet" href="<?php echo PATH_DOMAIN; ?>/dist/css/AdminLTE.min.css"/>
  <link rel="stylesheet" href="<?php echo PATH_DOMAIN; ?>/dist/css/skins/skin-yellow.min.css"/>

  <link rel="stylesheet" href="<?php echo PATH_DOMAIN; ?>/template/css/styles.css"/>
  <link rel="stylesheet" href="<?php echo PATH_DOMAIN; ?>/template/css/styles-session.css"/>

  <meta name="msapplication-TileImage" content="<?php echo PATH_DOMAIN; ?>/template/img/logo/hdvbxlogo-270x270.png" />
  <link rel="shortcut icon" href="<?php echo PATH_DOMAIN; ?>/template/img/logo/hdvbxlogo.png" />
  <link rel="icon" href="<?php echo PATH_DOMAIN; ?>/template/img/logo/hdvbxlogo-32x32.png" sizes="32x32" />
  <link rel="icon" href="<?php echo PATH_DOMAIN; ?>/template/img/logo/hdvbxlogo-192x192.png" sizes="192x192" />
  <link rel="apple-touch-icon-precomposed" href="<?php echo PATH_DOMAIN; ?>/template/img/logo/hdvbxlogo-180x180.png" />
</head>
<body class="hold-transition skin-yellow sidebar-mini">

<!-- /* THIS SHOULD SHOW WHEN PAGE LOADS */
<div align="center" class="cssload-fond"><div class="cssload-container-general"><div class="cssload-internal"><div class="cssload-ballcolor cssload-ball_1"> </div></div><div class="cssload-internal"><div class="cssload-ballcolor cssload-ball_2"> </div></div><div class="cssload-internal"><div class="cssload-ballcolor cssload-ball_3"> </div></div><div class="cssload-internal"><div class="cssload-ballcolor cssload-ball_4"> </div></div></div>-->

<div class="wrapper">
	<?php
	include(PATH_INCLUDE.'/template/php/header.php');
	include(PATH_INCLUDE.'/template/php/sidebar.php');
	?>
	<div class="content-wrapper">
		<?php if($_SESSION['use_site_as_another_user'] != ''){ ?>
		<div class="alert alert-danger">
			<strong>You are currently using the panel under <?php print $_SESSION['client']['firstname'].' '.$_SESSION['client']['lastname'].' ('.$_SESSION['client']['email'].')'; ?>. <a href="<?php print PATH_DOMAIN ?>/admin/virtualuser">Revert back to your own account?</a></strong>
		</div>
		<?php } ?>
		<div id="maincontent">
			<section class="content-header"><h1>Loading...</h1></section>
		</div>
	</div>
	<?php
	include(PATH_INCLUDE.'/template/php/footer.php');
	?>
</div>
</div>
<?php include(PATH_INCLUDE.'/template/php/javascript.php'); ?>

</body>
</html>