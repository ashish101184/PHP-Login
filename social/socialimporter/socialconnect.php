<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>SocialInviter - Social Connect</title>
    <!-- META-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
</head>
<body>
	 

    <!-- SOCIAL INVITER CODE -->
    <div class="socialinviter" type="socialconnect" appearance="square" layout="small"></div>
    <!-- /SOCIAL INVITER CODE -->

     <!-- Place the below script at the end of the file -->
     <script type="text/javascript">
         
         var storeImportedProfile = function () {
			 var data =  {
				 action: "profile",
				 data:JSON.stringify(socialinviter.socialconnect.getProfile().details)
			 };
			 $.post("processor.php", data, function (response) {
				console.log(response);
			 });
         }
    </script>
    
    <script type="text/javascript">
        var licenses = "<?php echo $sclicense ?>";
        var authpageUrl = "<?php echo $authpageUrl ?>";
        var SIConfiguration = {
            "path": {
                "authpage": authpageUrl
            },
            "callbacks": {
                "login": function (service, response) {
                    if (response.responseStatus.type == "success") {
                        storeImportedProfile();
                    }
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

