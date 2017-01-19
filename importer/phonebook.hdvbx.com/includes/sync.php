<?php include('../config.php');

if(!isset($_GET['service']) || $_GET['service'] == ''){
	$pagename = "Sync";
}else{
	$result = $db->query('SELECT ss.*, cs.lastsync, cs.authkey FROM system_syncservices ss
	LEFT JOIN client_services cs ON ss.service_id = cs.service_id AND cs.client_id="'.$_SESSION['client']['client_id'].'"
	WHERE ss.socialinviter_name = "'.htmlentities($_GET['service']).'" AND ss.service_status = 1
	');
	$service_exists = $result->num_rows;
	if($service_exists > 0){
		$service = $result->fetch_array(MYSQLI_BOTH);
		if($service['fa_icon_name'] == ''){ $fa_icon_name = ''; }else{ $fa_icon_name = $service['fa_icon_name']; }
		$pagename = "Sync - ".$service['service_name'];
	}else{
		include('index-invalidurl.php');
		exit;
	}
}

?>
<section class="content-header">
  <h1><?php print $pagename; ?></h1>
</section>

<?php if( !isset($_GET['service']) || (isset($_GET['service']) && $service_exists == 0) ){ ?>

<section class="content">
  <div class="box">
	<div class="box-body">
	<p>Here are the services which our system can sync your contacts.</p>
	<?php
	$result = $db->query('
	SELECT ss.service_id, ss.service_name, ss.socialinviter_name, ss.service_status, ss.fa_icon_name, cs.*
	FROM system_syncservices ss
	LEFT JOIN client_services cs ON ss.service_id = cs.service_id AND cs.client_id="'.$_SESSION['client']['client_id'].'"
	');
	if($result->num_rows > 0){ ?>
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead class="thead">
			<tr>
				<th style="width: 15px"></th>
				<th style="width: 100px">Service</th>
				<th>Last Synced</th>
				<th>URL</th>
				<th>Contacts</th>
				<th style="width: 100px">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php while($sql = $result->fetch_array(MYSQLI_BOTH)){
				if($sql['fa_icon_name'] == ''){ $fa_icon_name = ''; }else{ $fa_icon_name = $sql['fa_icon_name']; }
				$url = PATH_DOMAIN.'/export/?'.$sql['authkey'];
				print '<tr>
					<td><i class="fa '.$fa_icon_name.'"></i></td>
					<td><a href="'.PATH_DOMAIN.'/sync/?service='.$sql['socialinviter_name'].'" class="dynaload">'.$sql['service_name'].'</a></td>
					<td>'.$sql['lastsync'].'</td>
					<td><a href="'.$url.'">'.$url.'</a></td>
					<td>'.(isset($generalAllservies[$sql['socialinviter_name']])?$generalAllservies[$sql['socialinviter_name']]:0).'</td>
					<td>
						<button type="button" class="btn btn-xs btn-primary" title="Authenticate" onclick="socialinviter.contactimporter.auth(\''.$sql['socialinviter_name'].'\')"><i class="fa fa-fw fa-play"></i>&nbsp;&nbsp;Sync Now</button>
					</td>
				</tr>';
			} ?>
		</tbody>
	</table>
	</div>
	<?php }else{ print '<div class="alert alert-danger">There are no sync services enabled.</div>'; } ?>
	</div>
  </div>
</section>

<?php }else{ ?>

<section class="content">
  <div class="box">
	<div class="box-body">
	<h1><i class="fa <?php print $fa_icon_name; ?>"></i> <?php print $service['service_name']; ?></h1>
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead class="thead">
			<tr>
				<th style="width: 15px"></th>
				<th style="width: 100px">Service</th>
				<th>Last Synced</th>
				<th>URL</th>
				<th>Contacts</th>
				<th style="width: 100px">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$url = PATH_DOMAIN.'/export/?'.$service['authkey'];
				print '<tr>
					<td><i class="fa '.$service['fa_icon_name'].'"></i></td>
					<td>'.$service['service_name'].'</td>
					<td>'.$service['lastsync'].'</td>
					<td><a href="'.$url.'">'.$url.'</a></td>
					<td>'.(isset($generalAllservies[$service['socialinviter_name']])?$generalAllservies[$service['socialinviter_name']]:0).'</td>
					<td>
						<button type="button" class="btn btn-xs btn-primary" title="Authenticate" onclick="socialinviter.contactimporter.auth(\''.$service['socialinviter_name'].'\')"><i class="fa fa-fw fa-play"></i>&nbsp;&nbsp;Sync Now</button>
					</td>
				</tr>';
			?>
		</tbody>
	</table>
	</div>
	<?php
	$result = $db->query('SELECT * FROM client_contacts WHERE service = "'.$service['socialinviter_name'].'" AND client_id="'.$_SESSION['client']['client_id'].'"');
	if($result->num_rows > 0){ ?>
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead class="thead">
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Address</th>
				<th>DOB</th>
				<th>Phone</th>
				<th>Image</th>
				<th>Website</th>
				<th>Notes</th>
				<th>Last Modified</th>
			</tr>
		</thead>
		<tbody>
            <?php while($sql = $result->fetch_array(MYSQLI_BOTH)){
				if($sql['imageurl']!=''){
					$url = PATH_DOMAIN.'/contacts/'.$sql['client_id'].'/'.$sql['contact_id'].'.jpg';
					if(file_exists($url)){
						$imageurl = '<a href="'.$sql['imageurl'].'" target="_new"><img src="'.$url.'" class="img-responsive" /></a>';
					}else{ $url = ''; }
				}else{
					$url = ''; $imageurl = '';
				}
			print '<tr>
					<td>'.$sql['first_name'].'</td>
					<td>'.$sql['last_name'].'</td>
					<td>'.$sql['email'].'</td>
					<td>'.$sql['address'].'</td>
					<td>'.$sql['dob'].'</td>
					<td>'.$sql['phone'].'</td>
					<td>'.$imageurl.'</td>
					<td>'.$sql['website'].'</td>
					<td>'.$sql['notes'].'</td>
                    <td>'.$sql['last_modified'].'</td>
				</tr>';
			} ?>
		</tbody>
	</table>
	</div>
	<?php }else{ print '<div class="alert alert-danger">No contacts that have been synced.</div>'; } ?>
	</div>
  </div>
</section>

<?php } ?>


<script type="text/javascript">
         var storeImportedContacts = function (service,data) {
             console.log(socialinviter);
			var len = data.length;
             var contacts = "";
             for (var i = 0; i < len; i++) {
                 if (i != 0) {
                     contacts += ", "
                 }
				 console.log(data);
                 contacts += data[i].name.first_name + " " + data[i].name.last_name;
                 contacts += "< " + data[i].email[0] + " > ";
             }
//             $("#txtloadedContacts").html(unescape(contacts));
             var postdata =  {action: "contacts",service:service,data:JSON.stringify(data)};
			 $.post("<?php print PATH_DOMAIN ?>/syncing/processor.php", postdata, function (response) {
				<?php 
                                if($_GET['service']){
                                    ?>                                                
                                    window.location = "<?php print PATH_DOMAIN ?>/sync/?service="+service;
                                <?php 
                                }else{ 
                                ?>
                                    window.location = "<?php print PATH_DOMAIN ?>/sync";      
                                <?php
                                } 
                                ?>
			 });
         }
         var storeSelectedContacts = function () {
			 var contacts = "";
             var data = socialinviter.contactimporter.getSelectedContacts().addressbook;
             var len = data.length;
             for (var i = 0; i < len; i++) {
                 if (i != 0) {
                     contacts += ", "
                 }
                 contacts += data[i].name.first_name + " " + data[i].name.last_name;
                 contacts += "< " + data[i].email[0] + " > ";
             }
//             $("#txtselectedcontacts").html(unescape(contacts));
             var postdata =  {action: "selectedcontacts",data:JSON.stringify(socialinviter.contactimporter.getSelectedContacts().addressbook)};
             $.post("<?php print PATH_DOMAIN ?>/syncing/processor.php", postdata, function (response) {
                //console.log(response);
             });
         }
         var sendSelectedContacts = function () {
			
			 var data =  {
				 action: "selectedcontacts",
				 data:JSON.stringify(socialinviter.contactimporter.getRecipients()),
				 subject:$(".mailing-subject").val(),
				 message: $(".mailing-message").val()
			 };
			 $.post("<?php print PATH_DOMAIN ?>/syncing/processor.php", data, function (response) {
				//console.log(response);
				//socialinviter.modalSI.showSuccessMessage("Success: Email sent.");
				socialinviter.modalSI.showInfoMessage("Note: Please use your SMTP to send emails");
			 });
         }
       
    </script>
    
    <script type="text/javascript">
        var licenses = "<?php echo cilicense ?>";
        var authpageUrl = "<?php echo authpageUrl ?>";
        var SIConfiguration = {
            "path": {
                "authpage": authpageUrl
            },
            "callbacks": {
                "loaded": function (service, data) {
                    storeImportedContacts(service,data);
                },
                "send": function (event, service, recipients, response) {
                    sendSelectedContacts();
                },
                "proceed": function (event, service) {
                    storeSelectedContacts();
                }
            }
        }

        /* Initialize the plugin */
        var fileref=document.createElement("script");fileref.setAttribute("type","text/javascript");fileref.setAttribute("id","apiscript");fileref.setAttribute("src","//socialinviter.com/all.js?keys="+licenses);
		try{document.body.appendChild(fileref)}catch(a){document.getElementsByTagName("head")[0].appendChild(fileref);}var loadInitFlg=0,socialinviter,loadConf=function(){window.setTimeout(function(){$(document).ready(function(){loadInitFlg++;
		socialinviter?socialinviter.load(SIConfiguration):15>loadInitFlg&&window.setTimeout(loadConf,200)})},250)};window.setTimeout(loadConf,200);
    </script>