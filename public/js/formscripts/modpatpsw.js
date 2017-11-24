/*Add validation rule that checks password validity (e.g. 8 characters length and at least one alphanumeric character)*/
jQuery.validator.addMethod("checkPassword", function(value, element) {
	if(value.length <8)
		return false;
	
	var validAlpha = /[a-zA-Z]/;
	var validDigit = /[0-9]/;
	
	if(!validAlpha.test(value) || !validDigit.test(value))
		return false;
	else
		return true;
    
}, "Inserire una password valida.");

$(document).ready(function(){
    $('#modpatpsw').validate({
        rules:  
        {
        'modcurrentpsw':{  
            required: true//,
	    //checkPassword: false
            },  
        'modnewpsw':{  
            required: true,
	    checkPassword: true
            },  
        'modconfirmpsw':{  
            equalTo: '#modnewpsw'  
            }  
        },
	 messages:  
        {  
        'modcurrentpsw':{  
            required: "Campo obbligatorio!",
	    checkPassword: "La password deve contenere almeno otto caratteri tra cui una cifra!" 
            }, 
        'modnewpsw':{  
            required: "Campo obbligatorio!",
	    checkPassword: "La password deve contenere almeno otto caratteri tra cui una cifra!" 
            },  
        'modconfirmpsw':{  
            equalTo: "Le due password non coincidono!"  
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
				$.post("formscripts/modpatpsw.php",
			
			{
				currentpsw:	$("#modcurrentpsw").val(),
				newpsw:		$("#modnewpsw").val(),
				confirmpsw:	$("#modconfirmpsw").val(),
				
			},
			
		
			
			
  			function(status){
				//$('#modpatpsw')[0].reset();
    			alert("Status: " + status );
				$('#modpatpswmodal').modal('hide');
				location.reload();
  			});
		}
    });
});