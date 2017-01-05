<?php

include('../../config.php');

header("Content-type: text/javascript");

echo '

function encrypt(string){ return Base64.encode(Base64.encode(Base64.encode(string))); }
function decrypt(string){ return Base64.decode(Base64.decode(Base64.decode(string))); }

/* PAGE LOADER */
	$(window).load(function() {
		//$("#loadingcontent").addClass("loadingcontent_hidden");
	});

/* NOTIFICATIONS > DESKTOP */
/*	// Check if the browser supports notifications
	if (!("Notification" in window)) {
		alert("This browser does not support system notifications.");
	}
	else if (Notification.permission === "granted") {
		//var notification = new Notification("HD VBX Notifications have already been enabled!");
	}
	else if (Notification.permission !== "denied") {
		Notification.requestPermission(function (permission) {
			if (permission === "granted") {
				var notification = new Notification("HD VBX Notifications have been enabled!");
			}
		});
	}
	else if (Notification.permission == "denied") {
		//alert("HD VBX does not force you to have notifications enabled, but is highly recommended for when a call or sms comes though.");
	}
*/
	
/* NOTIFICATIONS > FAVICO */
	$(document).ready(function() {
		var badge = 5;
		var favicon = new Favico({
			animation : "popFade"
		});
		//intial value
		favicon.badge(badge);
	});
	
/* CONTENT > TOOLTIPS */
	$(document).ready(function() {
		$("[data-toggle=\'tooltip\']").tooltip();
	});

/* URL > GET QUERY STRING PARAMETERS */
	function getQueryString(name, url) {
		if (!url) url = window.location.href;
		name = name.replace(/[\[\]]/g, "\\$&");
		var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
			results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return "";
		return decodeURIComponent(results[2].replace(/\+/g, " "));
	}

/* ON PAGE LOAD, CALL AJAX */
	$("document").ready(function() {
		var pageURL = $(location).attr("href");
		var linkexists = "no";
		var getQuery = "";
		var elementOverlay = $("#maincontent");
		if(pageURL != "'.str_replace("https://", "", PATH_DOMAIN).'"){
			$(".sidebar-menu a").each(function(index, element) {
				if(pageURL == element){
					$(this).trigger("click");
					linkexists = "yes";
				}
			});
			if(linkexists == "no"){
				var pageURL = pageURL.replace(/https?:\/\/[^\/]+/i, "");

				if(pageURL == ""){
					pageURL = "/dashboard";
					getQuery = "";
				}else{
					pageURL = pageURL.replace("'.PATH_DOMAIN.'", "");
					pageURL_new = pageURL.substring(0 , pageURL.indexOf("?"));
					if(pageURL_new != ""){
						getQuery = pageURL.replace(pageURL_new, "");
						pageURL = pageURL_new;
					}
				}
				
				$.ajax({
				  url: "/includes" + pageURL + ".php" + getQuery,
				  type: "POST",
				  beforeSend: function(){
					  elementOverlay.LoadingOverlay("show");
				  },
				  success: function(data){
					  $("#maincontent").html(data);
				  },
				  error: function (xhr, ajaxOptions, thrownError) {
					  //$("#maincontent").html(xhr.status + " > " + thrownError);
					  $("#maincontent").load( "/includes/index-invalidurl.php" );
				  },
				  complete: function(data){
					  elementOverlay.LoadingOverlay("hide");
				  }
				});
			}
		}
	});

/* LOAD CONTENT ON CLICK */
	$(".main-sidebar a, .dynaload").click(function(){
		var href = $(this).attr("href"), href_text = $(this).text();
		var elementOverlay = $("#maincontent");
		var getQuery = "";
		if (href.indexOf("#") == -1) {
			history.pushState(null, null, href );
			$(document).prop("title", href_text + " | HD VBX");
			
			$(".active").not(".control-sidebar .active").removeClass( "active" );
			$(this).closest("li").addClass( "active" );
			
			var pageURL = href.replace(/https?:\/\/[^\/]+/i, "");
			
			if(pageURL == ""){
				pageURL = "/dashboard";
				getQuery = "";
			}else{
				pageURL = pageURL.replace("'.PATH_DOMAIN.'", "");
				pageURL_new = pageURL.substring(0 , pageURL.indexOf("?"));
				if(pageURL_new != ""){
					getQuery = pageURL.replace(pageURL_new, "");
					pageURL = pageURL_new;
				}
			}
			
			$.ajax({
			  url: "/includes" + pageURL + ".php" + getQuery,
			  type: "POST",
			  beforeSend: function(){
				  elementOverlay.LoadingOverlay("show");
			  },
			  success: function(data){
				  $("#maincontent").html(data);
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				  //$("#maincontent").html(xhr.status + " > " + thrownError);
				  $("#maincontent").load( "/includes/index-invalidurl.php" );
			  },
			  complete: function(data){
				  elementOverlay.LoadingOverlay("hide");
			  }
			});
			return false;
		}
	});

';

?>