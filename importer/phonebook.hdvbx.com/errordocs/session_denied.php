<?php $pagename = "Access Denied"; ?>
<section class="content-header">
  <h1><?php print $pagename; ?></h1>
  <ol class="breadcrumb">
	<li><a href="<?php print PATH_DOMAIN ?>"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active"><?php print $pagename; ?></li>
  </ol>
</section>
<section class="content">
  <div class="box">
	<div class="box-body">
	  <div class="alert alert-danger">
		  Access Denied. You do not have the appropriate permissions to access this page.
	  </div>
	</div>
  </div>
</section>