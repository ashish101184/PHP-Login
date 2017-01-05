<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title><?php if(isset($pagename)){ print $pagename; }else{ print 'Your virtual call center'; } ?> | HD VBX PhoneBook</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
  <link rel="stylesheet" href="<?php print PATH_DOMAIN ?>/bootstrap/css/bootstrap.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="<?php print PATH_DOMAIN ?>/template/css/styles.css" />
  <link rel="stylesheet" href="<?php print PATH_DOMAIN ?>/template/css/styles-nosession.css" />
  <?php if(isset($header_css)){ print $header_css; } ?>
	
  <meta name="msapplication-TileImage" content="<?php echo PATH_DOMAIN; ?>/template/img/logo/hdvbxlogo-270x270.png" />
  <link rel="shortcut icon" href="<?php echo PATH_DOMAIN; ?>/template/img/logo/hdvbxlogo.png" />
  <link rel="icon" href="<?php echo PATH_DOMAIN; ?>/template/img/logo/hdvbxlogo-32x32.png" sizes="32x32" />
  <link rel="icon" href="<?php echo PATH_DOMAIN; ?>/template/img/logo/hdvbxlogo-192x192.png" sizes="192x192" />
  <link rel="apple-touch-icon-precomposed" href="<?php echo PATH_DOMAIN; ?>/template/img/logo/hdvbxlogo-180x180.png" />
</head>
<body>
<div class="wrapper">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-offset-2 col-md-8 text-center">
				<div class="header">
					<a href="<?php print PATH_DOMAIN ?>">
						<img src="<?php print PATH_DOMAIN ?>/template/img/logo/hdvbxlogo-180x180.png"/>
						<div>HD VBX PhoneBook</div>
					</a>
				</div>
			</div>
		</div>
		<?php if(isset($donotshow)){ ?>
	</div>
</div>
</body>
</html>
<?php } ?>
