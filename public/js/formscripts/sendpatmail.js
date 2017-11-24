$(document).ready(function(){
    $('#patmailform').validate({
        rules: {
            contenuto: "required",
            oggettomail: "required"
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
			$.post("formscripts/sendpatmail.php",
			{
				nomeutente:		$("#nomeutente").val(),
				mail:			$("#mail").val(),
				oggettomail:	$("#oggettomail").val(),
				contenuto:		$("#contenuto").val()
			},
  			function(status){
				$('#patmailform')[0].reset();
    			alert("Status: " + status);
				$('#formModal').modal('hide');
  			});
		}
    });
});