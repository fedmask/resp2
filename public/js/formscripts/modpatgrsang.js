/*									  
$(document).ready(function(){
    $('#modpatgrsang').validate({
        rules: {
            patgrsang: "required"
        },
        errorClass: 'help-block col-lg-6',
        errorElement: 'span',
        highlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },
		submitHandler: function(event) { 
			$.post("formscripts/modpatgrsang.php",
			{
				patgrsang:		$("#patgrsang").val()
			},
  			function(status){
				//$('#modpatinfo')[0].reset();
    			alert("Status: " + status);
				$('#modpatgrsangmodal').modal('hide');
				location.reload();
  			});
		}
    });
});*/
$(document).ready(function(){
    $('#modpatgrsang').validate({
        rules:  
        {
        'patgrsang':{  
            required: true
            },  
		},
        errorClass: 'help-block col-lg-6',
        errorElement: 'span',
        highlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },
		submitHandler: function(event) { 
				$.post("formscripts/modpatgrsang.php",
			
			{
				patgrsang:	$("#patgrsang").val(),
			},
			
		
			
			
  			function(status){
				//$('#modpatpsw')[0].reset();
    			//alert("Status: " + status );
				alert("Cambio gruppo sanguigno effettuato con successo " + status );
				$('#modpatgrsang').modal('hide');
				location.reload();
  			});
		}
    });
});