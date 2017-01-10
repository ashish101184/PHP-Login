<?php
	include('config.php');?>
<script src="<?php echo PATH_DOMAIN;?>/plugins/jQuery/jquery.min.js"></script>
    
    <!--CORE JAVASCRIPT-->
    <script>        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-145464-12', 'auto');
        ga('send', 'pageview');


</script>

     <!-- Place the below script at the end of the file -->
     <script type="text/javascript">
         var storeImportedContacts = function (service,data) {
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
			 $.post("processor.php", postdata, function (response) {
				alert(response);
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
