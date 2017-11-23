$(document).ready(function(){
    $('#form_contact_us').validate({
        rules: {
			nome: "required",
            mail: {
      				required: true,
      				email: true
    			  },
            messaggio: "required"
        },
        errorClass: 'help-block col-lg-12',
        errorElement: 'span',
        highlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },
		submitHandler: function(event) { 
			$.post("formscripts/contact_us2.php",
			{
				nome:			$("#nome").val(),
				mail:			$("#mail").val(),
				messaggio:		$("#messaggio").val(),
			},
  			function(status){
				$('#form_contact_us')[0].reset();
    			alert("Status: " + status);
  			});
		}
    });
});