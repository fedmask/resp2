/*
* File javascript che comunica con i file php. Ogni informazione viene o trasferita in una tabella o estratta da una tabella, * modificata e riportata nella tabella. In questo file si realizza il pannello di controllo per pazienti ed admin
* @author Francesco Faggiani - Mat. 512320
*/

function modpermconc (id){ //modifica permesso concesso

	$.post("formscripts/getpermessi.php",
	{
			id_permesso: id
	},
  			
  	function(json_permessi){
		$("#permmod-modal").modal('show');
		$('#permmod-form')[0].reset();	
		
		var permessi = JSON.parse(json_permessi);
		$("#permmodcpp_title").html(permessi.cpp);
		$("#permmodresource_title").html(permessi.risorsa);
		
		$("#permmod_cpp").val(permessi.cpp);
		$("#permmod_risorsa").val(permessi.risorsa);
		$("#permmod_azioni").val(permessi.azioni);
		$("#permmod_scadenza").val(permessi.scadenza);
		
		var vis = '.visibilitym[id='+permessi.visibilita+']';
		//var dut = '.dutym[id='+permessi.obblighi+']';
		
		$("#permmod_visibilita").val($(vis).text());
		$("#permmod_visibilita_caret").val(permessi.visibilita);
		
		$("#permmod_obblighi").val(permessi.obblighi);
		/*if(permessi.obblighi == "Nessun obbligo")
			$("#permmod_obblighi_caret").val(1);
		else
			$("#permmod_obblighi_caret").val(2);
		*/	
  	});
	
	    $('#permmod-form').validate({
        rules: {
            permmod_cpp: "required", 
			permmod_risorsa: "required",
			permmod_azioni: "required",
			permmod_visibilita: "required",
			permmod_scadenza: "required"
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
			
			$.post("formscripts/modifypermission.php", 
			{
				id_permesso: id,
				cpp: $("#permmod_cpp").val(), 
				risorsa: $("#permmod_risorsa").val(),
				azioni: $("#permmod_azioni").val(),
				scadenza: $("#permmod_scadenza").val(),
				visibilita:	$("#permmod_visibilita_caret").val(),
				obblighi:	$("#permmod_obblighi").val(),
			},
  			function(status){ 
  				$('#permmod-form')[0].reset(); 
  				$('#permmod-modal').modal('hide'); 
  				location.reload();
			});
		}
    });
	
	
}

function eliminapermconc (id){ 

	if (confirm('Eliminare il permesso?') == true){ 
	
		$.post("formscripts/deletepermessi.php", 

		{ 
			id_permesso: id
		},
 
 		function(status){ 
 			alert("Permesso eliminato con successo"); 
 			location.reload(); 
 		}); 
 	
 	} 
 }


function newpermconc (){ //inserisce un nuovo permesso

	$('#permconc-modal').modal('toggle');
	$('#permconc-form')[0].reset();
	
    $('#permconc-form').validate({
        rules: {
            permconc_cpp: "required",
			permconc_risorsa: "required",
			permconc_azioni: "required",
			permconc_visibilita: "required"
        },
        errorClass: 'help-block col-lg-6',
        errorElement: 'span',
		errorPlacement: function (error, element) {
            var type = $(element).attr("type");
            
            error.insertAfter($('#'+$(element).attr("id")+'_caret')).wrap('<div/>');
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },
		submitHandler: function(event) { 
			$.post("formscripts/modsicurezza.php", 
			{
				cpp: $("#permconc_cpp_caret").val(),
				risorsa: $("#permconc_risorsa").val(),
				azioni: $("#permconc_azioni").val(),
				scadenza: $("#permconc_scadenza").val(),
				visibilita:	$("#permconc_visibilita_caret").val(),
				obblighi:	$("#permconc_obblighi").val(),
			}, 
  			function(status){ 
  				$('#permconc-form')[0].reset(); 
  				$('#permconc-form').modal('hide'); 
  				location.reload(); 
			});
			}
    });

	
}

function visaccsistema (id){ //visualizza accessi al sistema
	

}


$(document).ready(function () {
	
	//add
	$('#permconc_scadenza').css('width', '90%');
	
	$('#permconc_cpp').css('width', '90%');
	$('.cppUl').css('width', '90%');	
	$('#permconc_cpp').css('text-align', 'left');
	
	$('#permconc_risorsa').css('width', '90%');
	$('.resourceUl').css('width', '90%');	
	$('#permconc_risorsa').css('text-align', 'left');
	
	$('#permconc_azioni').css('width', '90%');
	$('.actionUl').css('width', '90%');	
	$('#permconc_azioni').css('text-align', 'left');
	
	$('#permconc_visibilita').css('width', '90%');
	$('.visibilityUl').css('width', '90%');	
	$('#permconc_visibilita').css('text-align', 'left');
	
	$('#permconc_obblighi').css('width', '90%');
	$('.dutyUl').css('width', '90%');	
	$('#permconc_obblighi').css('text-align', 'left');
	
	$('.cpp').click(function(){
		$('#permconc_cpp').html( $(this).text());
		$('#permconc_cpp_caret').val( $(this).attr("id"));
		$('#permconc_cpp').val( $(this).text());
	});
	
	$('.resource').click(function(){
		$('#permconc_risorsa').html( $(this).text());
		$('#permconc_risorsa').val( $(this).text());
	});
	
	$('.action').click(function(){
			$('#permconc_azioni').html( $(this).text());
			$('#permconc_azioni').val( $(this).text());
	});
	
	$('.visibility').click(function(){
			$('#permconc_visibilita').html( $(this).text());
			$('#permconc_visibilita_caret').val( $(this).attr("id"));
			$('#permconc_visibilita').val( $(this).text());
	});
	
	$('.duty').click(function(){
			$('#permconc_obblighi').html( $(this).text());
			$('#permconc_obblighi').val( $(this).text());
	});
	
	//modify
	$('#permmod_scadenza').css('width', '90%');
	
	$('#permmod_azioni').css('width', '90%');
	$('.actionUlm').css('width', '90%');	
	$('#permmod_azioni').css('text-align', 'left');
	
	$('#permmod_visibilita').css('width', '90%');
	$('.visibilityUlm').css('width', '90%');	
	$('#permmod_visibilita').css('text-align', 'left');
	
	$('#permmod_obblighi').css('width', '90%');
	$('.dutyUlm').css('width', '90%');	
	$('#permmod_obblighi').css('text-align', 'left');
	
	$('input[readonly]').focus(function(){
		this.blur();
	});
	
	
	$('.actionm').click(function(){
			$('#permmod_azioni').html( $(this).text());
			$('#permmod_azioni').val( $(this).text());
	});
	
	$('.visibilitym').click(function(){
			$('#permmod_visibilita').html( $(this).text());
			$('#permmod_visibilita_caret').val( $(this).attr("id"));
			$('#permmod_visibilita').val( $(this).text());
	});
	
	$('.dutym').click(function(){
			$('#permmod_obblighi').html( $(this).text());
			$('#permmod_obblighi').val( $(this).text());
	});
	
	
	
	$('#dataTables-permconc').dataTable({
		 "order": [ 0, 'asc' ], //valori ammessi '0' è l'indice di colonna, 'asc' e 'desc' sono il tipo di ordinamento
		 //paging: false
	});
	
	$('#dataTables-accsistema').dataTable({
		 "order": [ 3, 'desc' ],
		 //paging: false
	});

	//Set textual level value
	var textualLevels = ['null','Basso','Moderato','Normale','Riservato','Strettamente riservato','Nessuna restrizione'];
	var numericLevels = [{'null':'0','Basso':'1','Moderato':'2','Normale':'3','Riservato':'4','Strettamente riservato':'5','Nessuna restrizione':'6'}];
	$('#level_1').text(textualLevels[$('#level_1').text()]);
	$('#level_2').text(textualLevels[$('#level_2').text()]);
	$('#level_3').text(textualLevels[$('#level_3').text()]);
	$('#level_4').text(textualLevels[$('#level_4').text()]);
	$('#level_5').text(textualLevels[$('#level_5').text()]);
	$('#level_6').text(textualLevels[$('#level_6').text()]);
	$('#level_7').text(textualLevels[$('#level_7').text()]);
	$('#level_8').text(textualLevels[$('#level_8').text()]);
	$('#level_9').text(textualLevels[$('#level_9').text()]);
	$('#level_10').text(textualLevels[$('#level_10').text()]);
	$('#level_11').text(textualLevels[$('#level_11').text()]);
	$('#level_12').text(textualLevels[$('#level_12').text()]);
	$('#level_13').text(textualLevels[$('#level_13').text()]);
	$('#level_14').text(textualLevels[$('#level_14').text()]);
	$('#level_15').text(textualLevels[$('#level_15').text()]);
	
	$('.level').click(function(){
		
		var result = $(this).attr("id").split('_');
		
		$.post("formscripts/modrisorsalevel.php", 
			{
				id: result[1],
				risorsa: result[2],
				permesso: result[0]
			}, 
  			function(status){ 
  				location.reload(); 
			});
	});
});// JavaScript Document