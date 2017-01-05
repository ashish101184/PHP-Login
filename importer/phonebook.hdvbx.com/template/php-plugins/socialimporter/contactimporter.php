<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>SocialInviter - Contact Importer</title>
    <!-- META-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
</head>
<body>
	
    <input type="hidden" id="addressbook" value=""/>
    <input type="hidden" id="selectedcontacts" value=""/>
    <input type="hidden" id="subject" value=""/>
    <input type="hidden" id="message" value=""/>

    
    
    <!-- CONTACT IMPORTER CODE -->
    <div class="socialinviter" type="contactimporter"></div>
    <!-- /CONTACT IMPORTER CODE -->

	<h3 class="fl break">Loaded contacts</h3>
     <textarea id="txtloadedContacts"></textarea>

     <h3 class="fl break">Selected contacts</h3>
   	 <textarea id="txtselectedcontacts"></textarea>
                     

     <!-- Place the below script at the end of the file -->
     <script type="text/javascript">
         var storeImportedContacts = function (data) {
			var len = data.length;
             var contacts = "";
             for (var i = 0; i < len; i++) {
                 if (i != 0) {
                     contacts += ", "
                 }
                 contacts += data[i].name.first_name + " " + data[i].name.last_name;
                 contacts += "< " + data[i].email[0] + " > ";
             }
             $("#txtloadedContacts").html(unescape(contacts));
             var postdata =  {action: "contacts",data:JSON.stringify(data)};
			 $.post("processor.php", postdata, function (response) {
				//console.log(response);
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
             $("#txtselectedcontacts").html(unescape(contacts));
             var postdata =  {action: "selectedcontacts",data:JSON.stringify(socialinviter.contactimporter.getSelectedContacts().addressbook)};
             $.post("processor.php", postdata, function (response) {
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
			 $.post("processor.php", data, function (response) {
				//console.log(response);
				//socialinviter.modalSI.showSuccessMessage("Success: Email sent.");
				socialinviter.modalSI.showInfoMessage("Note: Please use your SMTP to send emails");
			 });
         }
       
    </script>
    
    <script type="text/javascript">
        var licenses = "<?php echo $cilicense ?>";
        var authpageUrl = "<?php echo $authpageUrl ?>";
        var SIConfiguration = {
            "path": {
                "authpage": authpageUrl
            },
            "callbacks": {
                "loaded": function (service, data) {
                    storeImportedContacts(data);
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
</body>
</html>

