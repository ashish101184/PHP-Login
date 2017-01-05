<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>SocialInviter - Social Post</title>
    <!-- META-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
</head>
<body>
	
    <!-- SOCIAL POST -->
    <div class="socialinviter" type="socialpost" appearance="circle" layout="small"></div>
    <!-- /SOCIAL POST -->
                        
    <script type="text/javascript">
        var shareObj = {
            title: "Social Inviter",
            link: "http://socialinviter.com",
            picture: "http://socialinviter.com/assets/img/icons/brandlogo.jpg",
            description: "Engage your user using socialinviter services.",
            comment: "Allows your business to promote through multiple social networks."
        };

        var licenses = "<?php echo $splicense ?>";
        var authpageUrl = "<?php echo $authpageUrl ?>";
        var SIConfiguration = {
            "path": {
                "authpage": authpageUrl
            },
            "callbacks": {
                "post": function (service, response) {
                    if (response.responseStatus.type == "success") {
                        //your logic here
                    }
                }
            }
        }

        /* Initialize the plugin */
        var fileref=document.createElement("script");fileref.setAttribute("type","text/javascript");fileref.setAttribute("id","apiscript");fileref.setAttribute("src","//socialinviter.com/all.js?keys="+licenses);
		try{document.body.appendChild(fileref)}catch(a){document.getElementsByTagName("head")[0].appendChild(fileref);}var loadInitFlg=0,socialinviter,loadConf=function(){window.setTimeout(function(){$(document).ready(function(){loadInitFlg++;
		socialinviter?socialinviter.load(SIConfiguration):15>loadInitFlg&&window.setTimeout(loadConf,200)})},250)};window.setTimeout(loadConf,200);
        window.setTimeout(function () { socialinviter.socialpost.setPostValues(shareObj); }, 2500);
    </script>
</body>
</html>

