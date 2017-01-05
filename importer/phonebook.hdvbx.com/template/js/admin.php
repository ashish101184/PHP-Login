<?php

include('../../config.php');

header("Content-type: text/javascript");

print '
$("#use_site_as_another_user").click(function(){
	var test_account = $("#test_account").val();
	$.ajax({
	  url: "../../includes/admin/query.php",
	  type: "POST",
	  dataType : "json",
	  data: {
		  action: "use_site_as_another_user",
		  test_account: test_account
	  },
	  success: function(data){
		  if(data.response == "success"){
			  window.location.href = "http://"+window.location.hostname;
		  }else{
		  	  //failed
		  }
	  },
	  error: function(jqXHR, textStatus, errorThrown) {
		  console.log(textStatus, errorThrown);
	  }
	});
	return false;
});

';

?>