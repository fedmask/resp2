$(document).ready(function(){
	
	jQuery.fn.outerHTML = function() {
		return jQuery('<div />').append(this.eq(0).clone()).html();
	};
	
	$("#testButton").click(function(){
		
		$('#tableConfermate').append('<tr><td>my data</td><td>more data</td><td>my data</td><td>my data</td><td>my data</td></tr>');
	
	});
	

	$('#concludiD').prop('disabled',true);
	$('#annullaD').prop('disabled',true);
	$('#nomeCp').prop('disabled',true);
	$('#cognomeCp').prop('disabled',true);
	
    $("#nuovaD").click(function(){
		
        $("#formD").show(200);
		$('#nuovaD').prop('disabled',true);
		$('#concludiD').prop('disabled',false);
		$('#annullaD').prop('disabled',false);
    });
	
	$( "#cpD" ).change(function() {
		
		
		if($("#cpD").val()==-1) {
			$('#nomeCp').prop('disabled',false);
			$('#cognomeCp').prop('disabled',false);
		}else{
			$('#nomeCp').prop('disabled',true);
			$('#cognomeCp').prop('disabled',true);
		}
	});
	
	
    $("#concludiD").click(function(){
	
		//if (confirm("Are you sure?"))
			
		var dia = $('#nomeD').val();
		var nomeCp = $('#nomeCpD').val();
		
		if((dia.trim())=='' || nomeCp.trim()==''){
			alert('Tutti i campi sono obbligatori');
		}else{
			
		$("#formD").hide(200);
		$('#nuovaD').prop('disabled',false);
		$('#concludiD').prop('disabled',true);
		$('#annullaD').prop('disabled',true);
		
		var idNuova;
		
		idNuova = $.post("formscripts/nuovaDiagnosi.php",
			{	
			
				patologia:  $("#nomeD").val(),
				nomeCp:     $("#nomeCpD").val(),
				cpId:       $("#cpId").val(),
				pzId:       $("#pzId").val(),
				stato:      $("#statoD").val(),
				conf:       $("#confD").val(),
			},
			function(status){				
    			status = parseInt(status); // Contiene l'id della diagnosi appena inserita
				var confidenzialita='';
		
			
			
			var tasti='<div id="row"><div id="col-lg-12"><div id="btn-group"><button id='+status+' class="indagini btn btn-primary"><i class="icon-search icon-white"></i></button> <button id='+status+' class="modifica btn btn-success "><i class="icon-pencil icon-white"></i></button> <button id='+status+' class="elimina btn btn-danger"><i class="icon-remove icon-white"></i></button></div></div></div>';
			var tastiConferma='<div id="row"><div id="col-lg-12"><div id="btn-group"><button id='+status+' class="indagini btn btn-primary"><i class="icon-search icon-white"></i></button> <button id='+status+' class="terapie btn btn-warning "><i class="icon-lightbulb  icon-white"></i></button> <button id='+status+' class="elimina btn btn-danger"><i class="icon-remove icon-white"></i></button></div></div></div>';
			var tastiNoModifica='<div id="row"><div id="col-lg-12"><div id="btn-group"><button id='+status+' class="indagini btn btn-primary"><i class="icon-search icon-white"></i></button> <button id='+status+' class="elimina btn btn-danger"><i class="icon-remove icon-white"></i></button></div></div></div>';
		
			var modificaStato='<tr id="riga'+status+'" style="display:none;"><td colspan="5"><form class="form-horizontal"><div class="row"><div class="col-lg-12" style=""><div class="form-group"><label class="control-label col-lg-4">Stato:</label><div class="col-lg-4"><select class="form-control" id="selStat'+status+'"><option value="0" selected>Sospetta</option><option value="1" >Confermata</option><option value="2" >Esclusa</option></select></div></div></div>';     
			
			var dispNone='';
			var conf1='>Nessuna restrizione</option>';    if($("#confD").val()==1) conf1='selected'+conf1;
			var conf2='>Basso</option>';				  if($("#confD").val()==2) conf2='selected'+conf2;   
			var conf3='>Normale</option>';				  if($("#confD").val()==3) conf3='selected'+conf3;
			var conf4='>Moderato</option>';				  if($("#confD").val()==4) conf4='selected'+conf4;
			var conf5='>Riservato</option>';			  if($("#confD").val()==5) conf5='selected'+conf5;
			var conf6='>Strettamente riservato</option>'; if($("#confD").val()==6) conf6='selected'+conf6;
			
			if($("#cpId").val()!= '-1') dispNone='style="display:none;"';
			
			var modificaConf='<div class="col-lg-12"'+dispNone+'><div class="form-group"><label class="control-label col-lg-4">Confidenzialità:</label><div class="col-lg-4"><select class="form-control" id="selConf'+status+'"><option value="1"'+conf1+'<option value="2"'+conf2+'<option value="3"'+conf3+'<option value="4"'+conf4+'<option value="5"'+conf5+'<option value="6"'+conf6+'</select></div></div></div>    ';

			var modificaCp='<div class="col-lg-12"'+dispNone+'><div class="form-group"><label class="control-label col-lg-4">Care provider:</label><div class="col-lg-4"><input id="txt'+status+'" type="text"  class="form-control" value="'+$("#nomeCpD").val()+'"</div></div></div></div>	</form>';
			var modificaTasti='<div style="text-align:right;"><a href="" onclick="return false;" class=annulla id="'+status+'">[Annulla]</a> <a href="" onclick="return false;" class=conferma id="'+status+'">[Conferma]</a></div> </tr></td>';
			
			var currentDate = new Date()
			var day = currentDate.getDate()
			var month = currentDate.getMonth() + 1
			var year = currentDate.getFullYear()
			currentDate = day + "-" + month + "-" + year;
		
			if($("#statoD").val()==0){
				$('#tableSospette').append('<tr id="r'+status+'"><td id="diagnosiSosp'+status+'">'+$("#nomeD").val()+'</td><td id="dataSosp'+status+'">'+currentDate+'</td><td id="confSosp'+status+'">'+$("#confD").val()+'</td><td id="cpSosp'+status+'">'+$("#nomeCpD").val()+' (Sospetta)</td><td>'+tasti+'</td></tr>');
				$('#tableSospette').append(modificaStato+modificaConf+modificaCp+modificaTasti);
			}
			
			if($("#statoD").val()==1){
				$('#tableConfermate').append('<tr id="r'+status+'"><td>'+$("#nomeD").val()+'</td><td>'+currentDate+'</td><td>'+$("#confD").val()+'</td><td>'+$("#nomeCpD").val()+' (Conferm.)</td><td>'+tastiConferma+'</td></tr>');
			}
			
			if($("#statoD").val()==2){
				$('#tableEscluse').append('<tr id="r'+status+'"><td>'+$("#nomeD").val()+'</td><td>'+currentDate+'</td><td>'+$("#confD").val()+'</td><td>'+$("#nomeCpD").val()+' (Esclusa)</td><td>'+tastiNoModifica+'</td></tr>');
			}
				$('#formD')[0].reset();
  			});
		
}
        
    });
	

	
	$("#annullaD").click(function(){
        $("#formD").hide(200);
		$('#nuovaD').prop('disabled',false);
		$('#concludiD').prop('disabled',true);
		$('#annullaD').prop('disabled',true);
    });
	
	
	
	




 
}); 
	


$(document).on('click', "button.modifica", function () {
    $(this).prop('disabled', true);
	var id = '#riga'+$(this).attr('id');
	console.log(id);
	$(id).show(200);
});


$(document).on('click', "button.elimina", function () {
    
	
	
	
	if (confirm("Eliminare la diagnosi?")){
	
	$.post("formscripts/eliminaDiagnosi.php",
			{	
			idDiagnosi: $(this).attr('id')
			
			},
				
			function(status){
				$('#formD')[0].reset();
    			//alert("Status: " + status);
  			});
			
	var id = $(this).attr('id');
	var riga = "#r"+id;	
	$(riga).hide(250);
	riga = "#riga"+id;	
	$(riga).hide(250);
	}
	
	
});

$(document).on('click', "button.anamnesi", function () {
    
	
	
	
	if (confirm("Eliminare la diagnosi?")){
	
	$.post("formscripts/eliminaDiagnosiConfermate.php",
			{	
			idDiagnosi: $(this).attr('id')
			
			},
				
			function(status){
				$('#formD')[0].reset();
    			//alert("Status: " + status);
  			});
			
	var id = $(this).attr('id');
	var riga = "#r"+id;	
	$(riga).hide(250);
	riga = "#riga"+id;	
	$(riga).hide(250);
	}
	
	
});

$(document).on('click', "button.terapie", function () {
    
	var id = '#terapie'+$(this).attr('id');
	$(id).submit();
	
	
});

$(document).on('click', "button.indagini", function () {
    
	var id = '#indagini'+$(this).attr('id');
	$(id).submit();
	
	
});


$(document).on('click', "a.annulla", function () {
    var but = '#'+$(this).attr('id');
	$(but+'.modifica').prop('disabled', false);
	
	var id = '#riga'+$(this).attr('id');
	$(id).hide(200);
});

$(document).on('click', "a.conferma", function () {
	
	var id = $(this).attr('id');
	var textbox = "#txt"+id;
	var selectConf  = "#selConf"+id;
	var selectStat = "#selStat"+id;
	var cp = $(textbox).val();
	var str = cp.split(" ");
	var nome = str[0];
	var cognome = str[1];
	var conf = $(selectConf).val();
	var stat = $(selectStat).val();
	
	var statOld = $(selectStat).val();
	var confOld = $(selectConf).val();
	
	
	
	var r = "#r"+id;
	var riga = "#riga"+id;
	//var r = $(r).outerHTML();
	//$('#tableConfermate').append(r);
	
	if(cp.trim()==''){
		alert('Tutti i campi sono obbligatori.');
	}else{

	$.post("formscripts/modificaDiagnosi.php",
			{	
			idDiagnosi:   $(this).attr('id'),
			careprovider: cp,
			conf:         $(selectConf).val(),
			stat:         $(selectStat).val(),
			idPz:         $('#pzId').val(),
			idCp:         $('#cpId').val(),
			
			},
				
			function(status){
				

				
				if(status==0){ // Vuol dire che lo stato della diagnosi non è cambiato, la riga non va eliminata ma solo modificata
					var textConf = "#confSosp"+id;			
					$(textConf).html('<td id="confSosp'+id+'">'+$(selectConf).val()+'</td>');
					var t = "#diagnosiSosp"+id;
				
				}else{ // Devo ricostruire la riga in base ai valori inseriti
					var diagnosi = "#diagnosiSosp"+id;
					    diagnosi = $(diagnosi).html();
					var data     = "#dataSosp"+id;
					    data     = $(data).html();
					var cpOld    = "#cpSosp"+id;
						cpOld    = $(cpOld).html();
					$(r).remove();
					var tableToUpdate;
					var nuovoStato;
					
					var cpId = $("#cpId").val();
					var pzId = $("#pzId").val();
					var linkIndagini;
					if(cpId==-1){
						linkIndagini = 'index.php?pag=indagini';
					}else{
						cpId = $("#idsorgente").val();
						linkIndagini = 'index.php?pag=indagini&cp_Id='+cpId+'&pz_Id='+pzId;;
					}
					var formIndagini = '<form id="indagini'+id+'" action="'+linkIndagini+'" method="post"><input readonly style="display:none;" type="text" name="idDiagnosi" value="'+id+'" /></form>';
					
					var tastiConferma='<div id="row"><div id="col-lg-12"><div id="btn-group"><button id='+status+' class="indagini btn btn-primary"><i class="icon-search icon-white"></i></button> <button id='+status+' class="terapie btn btn-warning "><i class="icon-lightbulb  icon-white"></i></button> <button id='+status+' class="elimina btn btn-danger"><i class="icon-remove icon-white"></i></button></div></div></div>';
					if($(selectStat).val()==1){
						tableToUpdate = "#tableConfermate";
						nuovoStato = " (Conferm.)<br>";
					}else{
						tableToUpdate = "#tableEscluse";
						nuovoStato = " (Esclusa)<br>";
					}
					$(tableToUpdate).append('<tr id="r'+id+'"><td>'+diagnosi+'</td><td>'+data+'</td><td>'+$(selectConf).val()+'</td><td>'+cp+nuovoStato+cpOld+'</td><td>'+tastiConferma+formIndagini+'</td></tr>');
					$(riga).remove();
				}
				
				$('#formD')[0].reset();
  			});

	var but = '#'+$(this).attr('id')+'.modifica';
	$(but).prop('disabled', false);
	
	var idr = '#riga'+$(this).attr('id');
	$(idr).hide(200);

	}
});





