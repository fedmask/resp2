$(document).ready(function(){
	
	var editContact = 0;
	var delContact = 0;
	
	$('.editContact').click(function(){
		editContact = $(this).val();
		var numbeRow = $('#modvalcontemerg_hidden_'+editContact).val();
		$('#contactName').text("Numero n.: " + numbeRow);
		$('#modcontemerg_hidden').val(editContact);
		
		$('#modtelcontemerg1').val($('#contattoemergenza_'+numbeRow+'_tel').text());
		$('#modtipcontemerg1').val($('#contattoemergenza_'+numbeRow+'_tip').text());
		$('#modcontemerg1').val($('#contattoemergenza_'+numbeRow).text());
		
	});
	
	
	
	$('.removeContact').click(function(){
		delContact = $(this).val();
		$('#delcontemerg_hidden').val(delContact);
		//console.log("delete: "+delContact);
		$.post("formscripts/delpatcontemerg.php",
			{
				idcontemerg:	$('#delcontemerg_hidden').val()
				/*contemerg2:		$("#modcontemerg2").val(),
				telcontemerg2:	$("#modtelcontemerg2").val(),
				contemerg3:		$("#modcontemerg3").val(),
				telcontemerg3:	$("#modtelcontemerg3").val()
				*/
			},
  			function(status){
				location.reload();
  			}
		);
			
	});
	
    $('#modpatcontemerg').validate({
        rules: {
            modcontemerg1: {
				required: "#modtelcontemerg1:filled"
			},
			modtelcontemerg1: {
				required: "#modcontemerg1:filled",
                digits: true
            }/*,
			modcontemerg2: {
				required: "#modtelcontemerg2:filled"
			},
			modtelcontemerg2: {
				required: "#modcontemerg2:filled",
                digits: true
            },
			modcontemerg3: {
				required: "#modtelcontemerg3:filled"
			},
			modtelcontemerg3: {
				required: "#modcontemerg3:filled",
                digits: true
            },*/


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
			$.post("formscripts/modpatcontemerg.php",
			{
				contemerg:		$("#modcontemerg1").val(),
				telcontemerg:	$("#modtelcontemerg1").val(),
				idcontemerg:	$('#modcontemerg_hidden').val()
				/*contemerg2:		$("#modcontemerg2").val(),
				telcontemerg2:	$("#modtelcontemerg2").val(),
				contemerg3:		$("#modcontemerg3").val(),
				telcontemerg3:	$("#modtelcontemerg3").val()
				*/
			},
  			function(status){
				
    			//alert("Status: " + status);
				$('#modpatcontemergmodal').modal('hide');
				//$('#modpatcontemergmodal')[0].reset();
				location.reload();
  			});
		}
    });
	
	$('#addpatcontemerg').validate({
        rules: {
            modcontemerg_add: {
				required: "#modcontemerg_add:filled"
			},
			modtelcontemerg_add: {
				required: "#modtelcontemerg_add:filled",
                digits: true
            },
            modtipcontemerg_add: {
				required: "#modtipcontemerg_add:filled"
			}
			
			


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
			$.post("formscripts/addpatcontemerg.php",
			{
				contemerg:		$("#modcontemerg_add").val(),
				telcontemerg:	$("#modtelcontemerg_add").val(),
				tipcontemerg :  $ ("#modtipcontemerg_add").val(),
				/*contemerg2:		$("#modcontemerg2").val(),
				telcontemerg2:	$("#modtelcontemerg2").val(),
				contemerg3:		$("#modcontemerg3").val(),
				telcontemerg3:	$("#modtelcontemerg3").val()
				*/
			},
  			function(status){				
    			//alert("Status: " + status);
				$('#modpatcontemergmodal').modal('hide');
				//$('#modpatcontemergmodal')[0].reset();
				location.reload();
  			});
		}
    });

	
	//Aggiunge gli altri contatti Controllo JS per i contatti non di emergenza
	$('#addpatcont').validate({
     
	   rules: {
		   
            modcontemerg_add: {
				required: "#modcontemerg_add2:filled"
			},
			modtelcontemerg_add: {
				required: "#modtelcontemerg_add2:filled",
                digits: true
            },
            modtipcontemerg_add: {
				required: "#modtipcontemerg_add2:filled"
			}
			

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
			$.post("formscripts/addpatcontemerg.php",
			{
				contemerg:		$("#modcontemerg_add2").val(),
				telcontemerg:	$("#modtelcontemerg_add2").val(),
				tipcontemerg:	$("#modtipcontemerg_add2").val()
				
				
			},
  			function(status){				
    			//alert("Status: " + status);
				$('#modpatcontmodal').modal('hide');
				//$('#modpatcontemergmodal')[0].reset();
				location.reload();
  			});
		}
    });
	
	});