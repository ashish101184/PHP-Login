<?php include('../config.php'); $pagename = "Services"; ?>
<section class="content-header">
  <h1><?php print $pagename; ?></h1>
</section>
<section class="content">
  <div class="box">
	<div class="box-body">
	<p>Here are the services which our system can sync your contacts.</p>
	<?php
	$result = $db->query('
	SELECT ss.service_id, ss.service_name, ss.service_status, cs.linkedservice_id, cs.client_id, cs.status 
	FROM system_syncservices ss
	LEFT JOIN client_services cs ON ss.service_id = cs.service_id AND cs.client_id="'.$_SESSION['client']['client_id'].'"
	');
	if($result->num_rows > 0){ ?>
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead class="thead">
			<tr>
				<th style="width: 100px">Service</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php while($sql = $result->fetch_array(MYSQLI_BOTH)){
				print '<tr id="service_'.$sql['service_id'].'">
					<td>'.$sql['service_name'].'</td>
					<td>
						<button type="button" class="btn btn-xs btn-primary button_authorize'.($sql['status']==0?'':' hidden').'" title="Authorize"><i class="fa fa-fw fa-play"></i>&nbsp;&nbsp;Authorize</button>
						<button type="button" class="btn btn-xs btn-danger button_unauthorize'.($sql['status']==1?'':' hidden').'" title="Remove Authentication"><i class="fa fa-fw fa-remove"></i>&nbsp;&nbsp;Un-Authorize</button>
						<span class="notifymsg"></span>
					</td>
				</tr>';
			} ?>
		</tbody>
	</table>
	</div>
	<? }else{
		print '<div class="alert alert-danger">There are no sync services enabled.</div>';
	}
	?>
	</div>
  </div>

</section>
<script type="text/javascript">

	$(".button_authorize, .button_unauthorize").click(function(){
		var elementOverlay = $(this).closest("table"); elementOverlay.LoadingOverlay("show");
		var service_id = $(this).closest("tr").attr('id'),
			notifymsg = $(this).next(".notifymsg");
		
		service_id = service_id.replace("service_", "");
		
		if( $(this).hasClass("button_authorize") ){
			action = 'authorize';
			closest = '.button_unauthorize';
		}else{
			action = 'unauthorize';
			closest = '.button_authorize';
		}
		
		$.ajax({
			type : 'POST',
			dataType : 'json',
			data: {
				action: action,
				service_id: service_id
			},
			url  : '/includes/services-query.php',
			success: function(responseText){
				if(responseText.response != 'success'){
					notifymsg.show();
					notifymsg.html('<span class="text-danger">' + responseText.details + '</span>');
				}else{
					alert('Pending: Make THIS hidden');
					$(this).addClass("hidden");
					if( $(this).hasClass("button_authorize") ){
						alert('Pending: Show UNauthorize button');
						$(this).next().removeClass('hidden');
					}else{
						alert('Pending: Show authorize button');
						$(this).closest('button.button_authorize').removeClass('hidden');
					}
				}
			}
		});

		elementOverlay.LoadingOverlay("hide", true);
		return false;
	});
	
</script>