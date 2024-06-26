
	<div class="row">
	<div class="col-12">
	<div class="box">
	<div class="box-body">
<a class="version_check" id="1"><button class="btn btn-primary">Check for updates<span class="loading"></span></button></a>
	</div>
	</div>
	</div>
	</div>
	<script>
	// function to reorder
$(document).ready(function(){
	// check users files and update with most recent version
	$(".version_check").on('click',function(e) {
		//$(".loading").show();
		var uid = $(this).attr("id");
		var info = "uid="+uid+"&vcheck=1";
		$.ajax({
		   beforeSend: function(){
			   $(".loading").html('<br><img src="<?php echo base_url(); ?>Asset/imgs/loader-update.gif" width="16" height="16" />');
		   },
		   type: "POST",
		   url: "<?php echo base_url(); ?>../update/version_check.php",
		   data: info,
		   dataType: "json",
		   success: function(data){
			   // clear loading information
			   $(".loading").html("");
			   // check for version verification
			   if(data.version != 0){
				   var uInfo = "uid="+uid+"&vnum="+data.version
			    	$.ajax({
					   beforeSend: function(){
						   $(".loading").html('<br><img src="<?php echo base_url(); ?>Asset/imgs/loader-update.gif" width="16" height="16" />');
					   },
					   type: "POST",
					   url: "<?php echo base_url(); ?>../update/update_functions.php",
					   data: uInfo,
					   dataType: "json",
					   success: function(data){
						   // check for version verification
			  			   if(data.copy != 0){
						   	   if(data.unzip == 1){
							       // clear loading information
						   		   $(".version_check").html("");
							       // successful update
						   	   	   $(".loading").html("Successful Update!");
							   }else{
								   // error during update/unzip
								   $(".loading").html("<br>Sorry, there was an error with the update.");
							   }
						   }
					   },
					   error: function() {
						   // error
						   $(".loading").html('<br>There was an error updating your files.');
					   }
					});
			   }else{
				    // user has the latest version already installed
					$(".version_check").html("");
					$(".loading").html("You already have the latest version.");
			   }
		   },
		   error: function() {
			   // error
			   $(".loading").html('<br>There was an error checking your latest version.');
		   }
		});
	});
});
	</script>
