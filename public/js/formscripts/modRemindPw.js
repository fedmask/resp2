$(document).ready(function(){
    $('#form_rec_pw').validate({
        /*rules: {
            mail: "required",
            cod_fisc: "required",
			cod_fisc: {
                required: true,
                rangelength: [19,19]
            },
        },*/
		rules: {
            'email': {
                required: true
            },
			'cod_fisc': {
                required: true,
                rangelength: [19,19]
            }
        },
		messages:  
        {  
        'email':{  
            required: "Campo obbligatorio!",
            }, 
        'cod_fisc':{  
            required: "Campo obbligatorio!", 
            } 
        } ,	 
        errorClass: 'help-block col-lg-6',
        errorElement: 'span',
        highlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },
		submitHandler: function(event) {
			//alert($("#cod_fisc").val());			
			$.post("formscripts/modRemindPw.php",
			{
				cf:				$("#cod_fisc").val(),
				email:			$("#email").val(),
			},
  			function(status){
				//$('#modpatinfo')[0].reset();
    			alert("Status: " + status);
				//$('#modpatinfomodal').modal('hide');
				//location.reload();
  			});
		}
    });
});