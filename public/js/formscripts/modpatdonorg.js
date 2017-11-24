$(document).ready(function(){
	
    $('#saveModPatDonOrg').click(function(){
		$.post("formscripts/modpatdonorg.php",
			{
				patdonorg:	function(){
	
								if ($("#negpatdonorg").prop("checked"))
									return 0;
								else 
									return 1;
							}		
			},
  			function(status){
				//$('#modpatinfo')[0].reset();
    			//alert("Status: " + status);
				$('#modpatdonorgmodal').modal('hide');
				location.reload();
  			});
    });
	
});