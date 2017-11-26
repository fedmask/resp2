$(document).ready(function(){
    $('#form_login').validate({ 
        rules: {
			user: "required",
            pass: "required"
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
			$.post("modello PBAC/Process.php",
			{
				user:			$("#user").val(),
				pass:			$("#pass").val(),
				remember:		$("#remember").prop("checked")
			},
			
  			function(status){
				if(status==1){
                                        progressionInit();
					window.location= "index.php";
}
              			else if(status==2){
                                        progressionInit();
                    window.location= "adminPanel.php";
					}
				else if(status==3){
                                        progressionInit();
					window.location= "carePanel.php";
}
				else
    					alert("Status : " + status);
    			
  			});
		}
    });
});