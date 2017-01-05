<?php include('../config.php'); $pagename = "TEMPLATE"; ?>
<section class="content-header">
  <h1><?php print $pagename; ?></h1>
  <ol class="breadcrumb">
	<li><a href="<?php print $domain ?>"><i class="fa fa-dashboard"></i> Home</a></li>
	<li><a href="#">Groups</a></li>
	<li class="active"><?php print $pagename; ?></li>
  </ol>
</section>
<section class="content">
  <div class="box">
	<div class="box-header with-border">
	  <h3 class="box-title"><?php print $pagename; ?></h3>
	</div>
	<div class="box-body">
	  ...
	</div>
	<div class="box-footer">
	  Footer
	</div>
  </div>
</section>