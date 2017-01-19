<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel">
	<div class="pull-left image">
	  <img src="<?php print PATH_DOMAIN; ?>/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
	</div>
	<div class="pull-left info">
		<p><?php print $_SESSION['client']['firstname'].' '.$_SESSION['client']['lastname']; ?></p>
		<!-- Status -->
		<?php if($_SESSION['client']['balance'] == '0.00'){
			print '<a href="#"><i class="fa fa-circle text-danger"></i> Offline</a>';
		}else{
			print '<a href="#"><i class="fa fa-circle text-success"></i> Online</a>';
		} ?>
	</div>
  </div>
  <!-- search form (Optional) -->
  <form action="#" method="get" class="sidebar-form">
	<div class="input-group">
	  <input type="text" name="q" class="form-control" placeholder="Search...">
		  <span class="input-group-btn">
			<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
			</button>
		  </span>
	</div>
  </form>
  <!-- /.search form -->

  <!-- Sidebar Menu -->
  <ul class="sidebar-menu">
	<li class="active"><a href="<?php print PATH_DOMAIN ?>" class="nav"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
	<?php if($_SESSION['client']['access']=='a'){ ?>
	<li class="treeview">
	  <a href="#"><i class="fa fa-sheild"></i> <span>ADMIN PANEL</span> <i class="fa fa-angle-left pull-right"></i></a>
	  <ul class="treeview-menu">
		<li><a href="<?php print PATH_DOMAIN ?>/admin/dashboard">Dashboard</a></li>
		<li><a href="<?php print PATH_DOMAIN ?>/admin/virtualuser">Virtual User</a></li>
	  </ul>
	</li>
	<?php }elseif($_SESSION['client']['access']=='m'){ ?>
	<li class="treeview">
	  <a href="#"><i class="fa fa-sheild"></i> <span>MODERATOR PANEL</span> <i class="fa fa-angle-left pull-right"></i></a>
	  <ul class="treeview-menu">
		<li><a href="<?php print PATH_DOMAIN ?>/admin">Dashboard</a></li>
	  </ul>
	</li>
	<?php } ?>
	<li class="treeview"><a href="<?php print PATH_DOMAIN ?>/profile"><i class="fa fa-user"></i> <span>Profile</span></a></li>
	<li class="treeview"><a href="<?php print PATH_DOMAIN ?>/services"><i class="fa fa-plug"></i> <span>Services</span></a></li>
	<li class="treeview">
	  <a href="#"><i class="fa fa-refresh"></i> <span>Syncing</span> <i class="fa fa-angle-left pull-right"></i></a>
	  <ul class="treeview-menu">
		<li class="treeview"><a id="syncAll" href="<?php print PATH_DOMAIN ?>/sync"><i class="fa fa-refresh"></i> <span>Syncing</span></a></li>
		<?php
		$result = $db->query('
		SELECT ss.service_id, ss.service_name, ss.socialinviter_name, ss.service_status, ss.fa_icon_name, cs.*
		FROM system_syncservices ss
		LEFT JOIN client_services cs ON ss.service_id = cs.service_id AND cs.client_id="'.$_SESSION['client']['client_id'].'"
		');
		if($result->num_rows > 0){
			while($sql = $result->fetch_array(MYSQLI_BOTH)){
				
				//GET CONTACT COUNT
				$contact_count = (isset($generalAllservies[$sql['socialinviter_name']])?$generalAllservies[$sql['socialinviter_name']]:0);
				
				if($sql['fa_icon_name'] == ''){ $fa_icon_name = ''; }else{ $fa_icon_name = $sql['fa_icon_name']; }
				print '
				<li class="treeview">
					<a id="torefresh_'.$sql['socialinviter_name'].'" href="'.PATH_DOMAIN.'/sync/?service='.$sql['socialinviter_name'].'" title="Sync - '.$sql['socialinviter_name'].'">
						<i class="fa '.$sql['fa_icon_name'].'"></i> 
						<span>'.$sql['service_name'].'</span>
						<span class="label label-primary pull-right">'.$contact_count.'</span>
					</a>
				</li>
				';
			}
		} ?>
	  </ul>
	</li>
	<li class="treeview"><a href="<?php print PATH_DOMAIN ?>/TestingInvalidURL"><i class="fa fa-refresh"></i> <span>Test Invalid Page</span></a></li>
  </ul>
  <!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
</aside>