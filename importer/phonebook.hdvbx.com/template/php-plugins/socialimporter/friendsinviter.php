<?php
//session_start();
include 'config.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>SocialInviter - Friends Inviter</title>
    <!-- META-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
</head>
<body>
	
    <input type="hidden" id="friendsinviter" value=""/>
    <input type="hidden" id="selectedfriends" value=""/>
    <input type="hidden" id="subject" value=""/>
    <input type="hidden" id="message" value=""/>

    

    <!-- FRIENDS INVITER CODE -->
    <div class="socialinviter" type="friendsinviter" appearance="square" text="Invite your friends"></div>
    <!-- /FRIENDS INVITER CODE -->

	<h3 class="fl break">Loaded friends</h3>
	<textarea id="txtloadedfriends"></textarea>
	
	<h3 class="fl break">Selected friends</h3>
	<textarea id="txtselectedfriends"></textarea>

                        
    <!-- Place the below script at the end of the file -->
    <script type="text/javascript">
         var storeImportedFriends = function (data) {
			 var len = data.length;
             var contacts = "";
             for (var i = 0; i < len; i++) {
                 if (i != 0) {
                     contacts += ", "
                 }
                 contacts += data[i].name.first_name + " " + data[i].name.last_name;
                 contacts += "< " + data[i].id + " > ";
             }
             $("#txtloadedfriends").html(unescape(contacts));
             var postdata =  {action: "friends",data:JSON.stringify(data)};
			 $.post("processor.php", postdata, function (response) {
				console.log(response);
			 });
         }
         var storeSelectedFriends = function () {
			 var contacts = "";
             var data = socialinviter.friendsinviter.getSelectedContacts().friends;
             var len = data.length;
             for (var i = 0; i < len; i++) {
                 if (i != 0) {
                     contacts += ", "
                 }
                 contacts += data[i].name.first_name + " " + data[i].name.last_name;
                 contacts += "< " + data[i].id + " > ";
             }
             $("#txtselectedfriends").html(unescape(contacts));
             var postdata =  {action: "friends",data:JSON.stringify(data)};
             $.post("processor.php", postdata, function (response) {
                console.log(response);
             });
         }
         var sendFIConfirmation = function () {
			 var data =  {
				 action: "selectedfriends",
				 data:JSON.stringify(socialinviter.friendsinviter.getSelectedContacts().friends)
			 };
			 $.post("processor.php", data, function (response) {
				console.log(response);
				socialinviter.modalSI.showSuccessMessage("Success: Message sent.");
			 });
         }
        
    </script>
    
    <script type="text/javascript">
        var licenses = "<?php echo $filicense ?>";
        var authpageUrl = "<?php echo $authpageUrl ?>";
        var SIConfiguration = {
            "path": {
                "authpage": authpageUrl
            },
			"facebooklink":"https://socialinviter.com/demo.aspx",
            "callbacks": {
                "loaded": function (service, data) {
                    storeImportedFriends(data);
                },
                "send": function (event, service, recipients, response) {
                    if (response.responseStatus.type == "success") {
                        sendFIConfirmation();
                    }
                },
                "proceed": function (event, service) {
                    storeSelectedFriends();
                }
            }
        }

        /* Initialize the plugin */
        var fileref=document.createElement("script");fileref.setAttribute("type","text/javascript");fileref.setAttribute("id","apiscript");fileref.setAttribute("src","//socialinviter.com/all.js?keys="+licenses);
		try{document.body.appendChild(fileref)}catch(a){document.getElementsByTagName("head")[0].appendChild(fileref);}var loadInitFlg=0,socialinviter,loadConf=function(){window.setTimeout(function(){$(document).ready(function(){loadInitFlg++;
		socialinviter?socialinviter.load(SIConfiguration):15>loadInitFlg&&window.setTimeout(loadConf,200)})},250)};window.setTimeout(loadConf,200);
    </script>
</body>
</html>

