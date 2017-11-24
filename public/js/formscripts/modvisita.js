var tmp_farmaco="";

function mod_diagnosi(id){
		
		$.post("formscripts/getdiagnosi.php",
			{
				id_diagnosi:	id
			},
  			function(json_diagnosi){
				$("#diagnosiModal").modal('show');
				$('#form_moddiagnosi')[0].reset();	
				var diagnosi = JSON.parse(json_diagnosi);
				$("#titolo_moddiagnosi").html('Modifica diagnosi<small class="help-block">(Ultima modifica effettuata da <b>'
											  +diagnosi.nomeCareProvider+'</b> il <b>'+diagnosi.ultimamodifica+'</b>)');				
				//$('[value="'+diagnosi.codPatologia+'"]').attr('selected',true);
				$("#diag_patologia").val(diagnosi.descrPatologia);
				$("#diag_datainizio").val(diagnosi.dataInizio);
				$("#diag_datafine").val(diagnosi.dataFine);
				$("#diagnosi_osservazioni").val(diagnosi.osservazioni);
				$('#tabs_diagnosi a[href="#tab_moddiagnosi"').tab('show');
				$("#tabella_terfarm").empty(); //modifica
				$("#box_dettagliterfarm").empty();
				$("#diag_patologia_helpblock").empty();
  			});
  			
  			$('#form_moddiagnosi').validate({
        		errorClass: 'help-block col-lg-6',
        		errorElement: 'span',
        		highlight: function (element, errorClass, validClass) {
            		$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        		},
        		unhighlight: function (element, errorClass, validClass) {
            		$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        		},
        		submitHandler: function(event) { 
			
				$.post("formscripts/modifyDiagnosis.php", 
				{
					id_permesso: id,  // prende l'id
					patologia: $("#diag_patologia").val(), // non prende questi valori eppure c'è corrispondenza col template
					datainizio: $("#diag_datainizio").val(),
					datafine: $("#diag_datafine").val(),
					osservazioni: $("#diagnosi_osservazioni").val(),
					status:	$("#diag_status").val(),
				
				},
  				function(status){ 
  					$('#form_moddiagnosi')[0].reset(); 
  					alert('id: ' + id);  // se scrivo + "patologia: " + patologia, non funziona
  					$('#diagnosiModal').modal('hide'); 
  					location.reload(); });
				}
    		});
			
			$.post("formscripts/getterapiediagnosi.php",
			{
				id_diagnosi:	id
			},function(json_diagnosi){
				var diagnosi = JSON.parse(json_diagnosi);
				
				for	(var index = 0; index < diagnosi.terfarm.length; index++) {
					$("#tabella_terfarm").append('<tr class="tr_terfarm" onclick="sospendi_terfarm('+diagnosi.terfarm[index].id+')" data-toggle="tooltip" data-placement="left" title="Visualizza dettagli e/o assegna sospensione">'+
														'<td>'+diagnosi.terfarm[index].farmaco+'</td>'+
														'<td>'+diagnosi.terfarm[index].status+'</td>'+
														'<td>'+diagnosi.terfarm[index].dataInizio+'</td>'+
														'<td>'+diagnosi.terfarm[index].dataFine+'</td>'+
														'<td>'+diagnosi.terfarm[index].formaFarmaceutica+'</td>'+
														'<td>'+diagnosi.terfarm[index].somministrazione+'</td>'+
														'<td>'+diagnosi.terfarm[index].frequenza+'</td>'+
												'</tr>');
					$('[data-toggle="tooltip"]').tooltip();
					
				}
			});
	
}

function sospendi_terfarm(id){
	$.post("formscripts/getterapiafarmacologica.php",
			{
				id_terfarm:	id
			},function(json_terfarm){
				var terfarm = JSON.parse(json_terfarm);
				
				if(terfarm.status!="sospesa")
				{
					$("#box_dettagliterfarm").html('<div class="box dark">'+
											'<header>'+
												'<h5>Dettagli terapia farmacologica<small class="help-block">(Ultima modifica effettuata da <b>'
											  				+terfarm.nomeCareProvider+'</b> il <b>'+terfarm.ultimaModifica+'</b>)</small></h5>'+
												'<div class="toolbar">'+
													 '<ul class="nav">'+
														   '<li onclick="annullanuovaterfarm()"><a id="btn_annullanuovaterfarm"><i class="icon-remove icon-white" ></i> Annulla</a></li>'+
													 '</ul>'+
												'</div>'+
											'</header>'+
											'<div class="body">'+
												'<div class="row">'+									
												'<div class="col-lg-6">'+									
													'<div class="form-group">'+
														'<label class="control-label col-lg-4">Farmaco:</label>'+
														'<div class="col-lg-8">'+
														'<input class="form-control" type="text" id="terfarm_farmaco" onclick="autocompl_listafarmaci()" value="'+terfarm.farmaco+'" readonly>'+
														'<span class="help-block" id="listafarmaci_helpblock"></span>'+
														'</div>'+
													'</div>'+
													'<div class="form-group">'+
														'<label class="control-label col-lg-4">Forma farmaceutica:</label>'+
														'<div class="col-lg-8">'+
														'<select class="form-control" id="terfarm_formafarmaceutica" readonly>'+ 
															'<option value="'+terfarm.formaFarmaceutica+'">'+terfarm.formaFarmaceutica+'</option>'+
														'</select>'+
														'</div>'+
													'</div>'+
													'<div class="form-group">'+
														'<label class="control-label col-lg-4">Somministrazione:</label>'+
														'<div class="col-lg-8">'+
														'<input class="form-control" type="text" id="terfarm_somministrazione" value="'+terfarm.somministrazione+'" readonly>'+
														'</div>'+
													'</div>'+
													'<div class="form-group">'+
														'<label class="control-label col-lg-4">Frequenza:</label>'+
														'<div class="col-lg-8">'+
														'<input class="form-control" type="text" id="terfarm_frequenza" value="'+terfarm.frequenza+'" readonly>'+
														'</div>'+													
													'</div>'+
													'<div class="form-group">'+
                                                        '<label class="control-label col-lg-4">Data inizio:</label>'+
                                                        '<div class="col-lg-8">'+
                                                            '<input type="date" id="terfarm_datainizio" class="form-control" value="'+terfarm.dataInizio+'" readonly>'+
                                                        '</div>'+                                  
													'</div>'+
													'<div class="form-group">'+
														'<label class="control-label col-lg-4">Data fine:</label>'+
														'<div class="col-lg-8">'+
															'<input type="date" id="terfarm_datafine" class="form-control" value="'+terfarm.dataFine+'" readonly>'+
														'</div>'+                                
													'</div>'+
												'</div>'+
												
												'<div class="col-lg-6">'+
												'<div class="panel panel-warning">'+
													'<div class="panel-heading"><i class="icon-ban-circle icon-white"></i> Sospensione</div>'+
													'<div class="panel-body">'+
														'<div class="form-group">'+
															'<label class="control-label col-lg-4">Descr. Efetti collaterali:</label>'+
															'<div class="col-lg-8">'+
															'<textarea class="form-control" type="text" id="terfarmsosp_descrEC"></textarea>'+
															'</div>'+
														'</div>'+
														'<div class="form-group">'+
															'<label class="control-label col-lg-4">Insorgenza nuova patologia:</label>'+
															'<div class="col-lg-8">'+
																'<input class="form-control" type="text" id="terfarmsosp_patologia" onclick="patologie_effetti_collaterali()">'+
																'<span class="help-block" id="terfarmsosp_patologia_helpblock"></span>'+
															'</div>'+
														'</div>'+
														'<div class="form-group">'+
															'<label class="control-label col-lg-4">Peggioramento Malattia:</label>'+
															'<div class="col-lg-8">'+
																'<label class="radio-inline">'+
																	'<input type="radio" name="peggioramento" id="peggioramentoNO" value="false" checked="checked">No'+
																'</label>'+
																'<label class="radio-inline">'+
																	'<input type="radio" name="peggioramento" id="peggioramentoSI" value="true">Si'+
																'</label>'+
															'</div>'+
														'</div>'+
														'<div class="form-group">'+
															'<label class="control-label col-lg-4">Mancata Efficacia:</label>'+
															'<div class="col-lg-8">'+
																'<label class="radio-inline">'+
																	'<input type="radio" name="mancataefficacia" id="mancataefficaciaNO" value="false" checked="checked">No'+
																'</label>'+
																'<label class="radio-inline">'+
																	'<input type="radio" name="mancataefficacia" id="mancataefficaciaSI" value="true">Si'+
																'</label>'+
															'</div>'+
														'</div>'+
														'<div class="form-group">'+
															'<label class="control-label col-lg-4">Mancata Compliance:</label>'+
															'<div class="col-lg-8">'+
																'<label class="radio-inline">'+
																	'<input type="radio" name="mancatacompliance" id="mancatacomplianceNO" value="false" checked="checked">No'+
																'</label>'+
																'<label class="radio-inline">'+
																	'<input type="radio" name="mancatacompliance" id="mancatacomplianceSI" value="true">Si'+
																'</label>'+
															'</div>'+
														'</div>'+
														'<div class="form-group">'+
															'<label class="control-label col-lg-4">Sostituz. altro farmaco:</label>'+
															'<div class="col-lg-8">'+
																'<label class="radio-inline">'+
																	'<input type="radio" name="sostfarmaco" id="sostfarmacoNO" value="false" checked="checked">No'+
																'</label>'+
																'<label class="radio-inline">'+
																	'<input type="radio" name="sostfarmaco" id="sostfarmacoSI" value="true">Si'+
																'</label>'+
															'</div>'+
														'</div>'+														
	
													'</div>'+
													'<div class="panel-footer" style="text-align:right">'+
                            							'<button class="btn btn-warning btn-sm">'+
															'<i class="icon-save icon-white"></i> Salva dati sospensione</button>'+
                        							'</div>'+
												'</div>'+
												'</div>'+
												
												'</div>'+
														
											'</div>'+
										'</div>');
				} else {
					$.post("formscripts/getsospensionefarmaco.php",
					{
						id_terfarm:	id
					},function(json_sospfarm){
						var sospfarm = JSON.parse(json_sospfarm);
						$("#box_dettagliterfarm").html('<div class="box dark">'+
											'<header>'+
												'<h5>Dettagli terapia farmacologica<small class="help-block">(Ultima modifica effettuata da <b>'
											  				+terfarm.nomeCareProvider+'</b> il <b>'+terfarm.ultimaModifica+'</b>)</small></h5>'+
												'<div class="toolbar">'+
													 '<ul class="nav">'+
														   '<li onclick="annullanuovaterfarm()"><a id="btn_annullanuovaterfarm"><i class="icon-remove icon-white" ></i> Annulla</a></li>'+
													 '</ul>'+
												'</div>'+
											'</header>'+
											'<div class="body">'+
												'<div class="row">'+									
												'<div class="col-lg-6">'+									
													'<div class="form-group">'+
														'<label class="control-label col-lg-4">Farmaco:</label>'+
														'<div class="col-lg-8">'+
														'<input class="form-control" type="text" id="terfarm_farmaco" onclick="autocompl_listafarmaci()" value="'+terfarm.farmaco+'" readonly>'+
														'<span class="help-block" id="listafarmaci_helpblock"></span>'+
														'</div>'+
													'</div>'+
													'<div class="form-group">'+
														'<label class="control-label col-lg-4">Forma farmaceutica:</label>'+
														'<div class="col-lg-8">'+
														'<select class="form-control" id="terfarm_formafarmaceutica" readonly>'+ 
															'<option value="'+terfarm.formaFarmaceutica+'">'+terfarm.formaFarmaceutica+'</option>'+
														'</select>'+
														'</div>'+
													'</div>'+
													'<div class="form-group">'+
														'<label class="control-label col-lg-4">Somministrazione:</label>'+
														'<div class="col-lg-8">'+
														'<input class="form-control" type="text" id="terfarm_somministrazione" value="'+terfarm.somministrazione+'" readonly>'+
														'</div>'+
													'</div>'+
													'<div class="form-group">'+
														'<label class="control-label col-lg-4">Frequenza:</label>'+
														'<div class="col-lg-8">'+
														'<input class="form-control" type="text" id="terfarm_frequenza" value="'+terfarm.frequenza+'" readonly>'+
														'</div>'+													
													'</div>'+
													'<div class="form-group">'+
                                                        '<label class="control-label col-lg-4">Data inizio:</label>'+
                                                        '<div class="col-lg-8">'+
                                                            '<input type="date" id="terfarm_datainizio" class="form-control" value="'+terfarm.dataInizio+'" readonly>'+
                                                        '</div>'+                                  
													'</div>'+
													'<div class="form-group">'+
														'<label class="control-label col-lg-4">Data fine:</label>'+
														'<div class="col-lg-8">'+
															'<input type="date" id="terfarm_datafine" class="form-control" value="'+terfarm.dataFine+'" readonly>'+
														'</div>'+                                
													'</div>'+
												'</div>'+
												
												'<div class="col-lg-6">'+
												'<div class="panel panel-danger">'+
													'<div class="panel-heading"><i class="icon-ban-circle icon-white"></i> Sospensione</div>'+
													'<div class="panel-body">'+
														'<div class="form-group">'+
															'<label class="control-label col-lg-4">Descr. Efetti collaterali:</label>'+
															'<div class="col-lg-8">'+
															'<textarea class="form-control" type="text" id="terfarmsosp_descrEC" readonly>'+sospfarm.effettiCollaterali+'</textarea>'+
															'</div>'+
														'</div>'+
														'<div class="form-group">'+
															'<label class="control-label col-lg-4">Insorgenza nuova patologia:</label>'+
															'<div class="col-lg-8">'+
																'<input class="form-control" type="text" id="terfarmsosp_patologia" onclick="patologie_effetti_collaterali()" value="'+sospfarm.patologia+'" readonly>'+
															'</div>'+
														'</div>'+
														'<div class="form-group">'+
															'<label class="control-label col-lg-4">Peggioramento Malattia:</label>'+
															'<div class="col-lg-8">'+
																'<input class="form-control" type="text" value="'+sospfarm.peggioramento+'" readonly>'+
															'</div>'+
														'</div>'+
														'<div class="form-group">'+
															'<label class="control-label col-lg-4">Mancata Efficacia:</label>'+
															'<div class="col-lg-8">'+
																'<input class="form-control" type="text" value="'+sospfarm.mancataEfficacia+'" readonly>'+
															'</div>'+
														'</div>'+
														'<div class="form-group">'+
															'<label class="control-label col-lg-4">Mancata Compliance:</label>'+
																'<div class="col-lg-8">'+
																	'<input class="form-control" type="text" value="'+sospfarm.mancataCompliance+'" readonly>'+
																'</div>'+
															
														'</div>'+
														'<div class="form-group">'+
															'<label class="control-label col-lg-4">Sostituz. altro farmaco:</label>'+
															'<div class="col-lg-8">'+
																'<input class="form-control" type="text" value="'+sospfarm.sostituzFarmaco+'" readonly>'+
															'</div>'+
														'</div>'+														
	
													'</div>'+
													'<div class="panel-footer" style="text-align:right">'+
                            							'<small>effettuata da <b>'+sospfarm.nomeCareProvider+'</b> il <b>'+sospfarm.ultimaModifica+'</b></small>'+
                        							'</div>'+
												'</div>'+
												'</div>'+
												
												'</div>'+
														
											'</div>'+
										'</div>');
					});
					
					
				}
										
			});

}

function patologie_effetti_collaterali(){
	$('#terfarmsosp_patologia').autocomplete({
		serviceUrl: 'formscripts/getpatologie.php',
		//minChars: 3, //numero minimo di caratteri richiesto per avviare l'autocomplete
		onSelect: function (suggestion) {
			$("#terfarmsosp_patologia_helpblock").html('Patologia selezionata: <b>' + suggestion.value + '</b> - codice:<b>' + suggestion.data+'</b>');
		}
	});
}

$(document).ready(function(){
	
	$('#btn_nuovavisita').click(function()
	{
			$('#btn_nuovavisita').html('<i class="icon-stethoscope"></i> Visita in corso...&nbsp;&nbsp;&nbsp;&nbsp;');
			$('#btn_nuovavisita').prop('disabled',true);//this.disabled=true;
			
			$('#btn_concludivisita').prop('disabled',false);
			$('#btn_concludivisita').prop('class','btn btn-success');
			
			$('#btn_annullavisita').prop('disabled',false);
			$('#btn_annullavisita').prop('class','btn btn-danger');
			
			$('#btn_stampavisita').prop('disabled',false);
			
			$('#btn_menu_nuovavisita').html('<i class="icon-stethoscope"></i> Visita in corso...');
			$('#btn_menu_nuovavisita').prop('class','btn btn-success btn-block')
			
			$('#avviso_no_visite').hide();
			$('#display_visita').show();
			
			//TODO submit operazioni per apertura nuova visita
			$('#btn_avviaAlgo').html('<i class="icon-list"></i> Avvia algoritmo diagnostico');
			$('#btn_avviaAlgo').prop('disabled',false)
			
			$('#btn_annullaAlgo').prop('disabled',true);
			$('#btn_annullaAlgo').prop('class','btn btn-warning');
			  
			$('#display_algoritmo').hide();	
			$('#lblJsonAlgoritmo').empty();
	});

	/*
	* Funzione algoritmo diagnostico Spera-Magarelli.
	* Funzioni jQuery che permettono di modificare l’interfaccia della pagina visita.php nel momento in cui 
	* si clicca sul pulsante ‘avvia Algoritmo’
	*/
	$('#btn_avviaAlgo').click(function()
	{
		$('#btn_avviaAlgo').html('<i class="icon-list"></i> Algoritmo in corso...&nbsp;&nbsp;&nbsp;&nbsp;');
		$('#btn_avviaAlgo').prop('disabled',true);

		$('#btn_annullaAlgo').prop('disabled',false);
		$('#btn_annullaAlgo').prop('class','btn btn-danger');

		$('#avviso_no_visite').hide();			
		$('#display_algoritmo').show();

		//TODO submit operazioni per apertura nuova visita
		$('#btn_nuovavisita').html('<i class="icon-stethoscope"></i> Inizia Nuova Visita');
		$('#btn_nuovavisita').prop('disabled',false)
		
		$('#btn_concludivisita').prop('disabled',true);
		$('#btn_concludivisita').prop('class','btn btn-primary');
		
		$('#btn_annullavisita').prop('disabled',true);
		$('#btn_annullavisita').prop('class','btn btn-primary');
		
		$('#btn_menu_nuovavisita').html('<i class="icon-stethoscope"></i> Nuova visita');
		$('#btn_menu_nuovavisita').prop('class','btn btn-primary btn-block')
		
		$('#btn_stampavisita').prop('disabled',true);
		
		$('#display_visita').hide();
		
		$('#form_visita')[0].reset();

		$('#0').show();
		$('#1').show();
		$('#2').show();
		$('#3').show();
		$('#4').show();
	});

	/*
	* Funzione algoritmo diagnostico Spera-Magarelli.
	* Tale funzione genera le checkbox con le relative descrizioni nelle 4 categorie (sintomi, 
	* esami obiettivi, esami di laboratorio e strumentali) dell’algoritmo diagnostico.
	*/
    $("[name='btn_algoritmo']").click(function(){
    	//imposto una variabile e ci associo il suo attributo id
    	var recupero_id = $(this).attr("id");   

    	url =  "sections/algoritmoDiagnosticoInfo.php";
	
		url =  url + "?code=" + recupero_id;

		var lunghezza = recupero_id.length;
		var lettera = recupero_id.substring(lunghezza-1, lunghezza);
		var code = recupero_id.substring(0, lunghezza-1);

		$.get(url, function( data ) {
			document.getElementById("lblJsonCodeAlgo").innerHTML = "";

			if(lettera=="c"){
				document.getElementById("lblDescrizione").innerHTML = "Elenco delle indagini relativi alla patologia selezionata";
				if(data['LAB']['codice'].length!=0){	
					var tabella="";
					for(var i=0;i<data['LAB']['codice'].length;i++){
						var disabilita = "";
						
							if(data['LAB']['contenuto'][i]==true){
								disabilita = 'disabled="disabled" checked';
							}

						tabella = tabella + '<tr> <td> <input id="'+recupero_id+lettera+'" type="checkbox" class="checkAlgoDiagn" value="'+ data['LAB']['codice'][i] + '" '+disabilita+'/> </td> <td>' + data['LAB']['descrizione'][i] + '</td> <td>' + data['LAB']['info'][i] + '</td> </tr>';
					}
					document.getElementById("lblJsonCodeAlgo").innerHTML += '<div class="tab-content"><div class="tab-pane fade in active" id="tab_info"><div class="row"><div  class="col-lg-12"><div class="table-responsive"><table class="table" id="tableConfermate"><thead><tr><th></th><th>Indagini di laboratorio</th><th>Valori Normali</th></tr></thead><tbody>'+tabella+'</tbody></table></div></div></div></div></div>';
				} 
				if(data['STRUM']['codice'].length!=0){
					var tabella="";
					for(var i=0;i<data['STRUM']['codice'].length;i++){
						var disabilita="";
						var element = data[i];
							if(data['STRUM']['contenuto'][i]==true){
								disabilita = 'disabled="disabled" checked';
							}
						tabella = tabella + '<tr> <td> <input id="'+recupero_id+lettera+'" type="checkbox" class="checkAlgoDiagn" value="'+ data['STRUM']['codice'][i] + '" '+disabilita+'/> </td> <td>' + data['STRUM']['descrizione'][i] + '</td> </tr>';
					}
					document.getElementById("lblJsonCodeAlgo").innerHTML += '<div class="tab-content"><div class="tab-pane fade in active" id="tab_info"><div class="row"><div  class="col-lg-12"><div class="table-responsive"><table class="table" id="tableConfermate"><thead><tr><th></th><th>Indagini strumentali</th></tr></thead><tbody>'+tabella+'</tbody></table></div></div></div></div></div>';
				}

			} else if(lettera=="b" && data['OBIETTIVI']['codice'].length!=0){
				document.getElementById("lblDescrizione").innerHTML = "Elenco degli esami obiettivi relativi alla patologia selezionata";	
				var tabella="";
				for(var i=0;i<data['OBIETTIVI']['codice'].length;i++){
					var disabilita="";
						if(data['OBIETTIVI']['contenuto'][i]==true){
								disabilita = 'disabled="disabled" checked';
							}
					tabella = tabella + '<tr> <td> <input id="'+recupero_id+lettera+'" type="checkbox" class="checkAlgoDiagn" value="'+  data['OBIETTIVI']['codiceinfo'][i] + '" '+disabilita+'/> </td> <td>' + data['OBIETTIVI']['descrizione'][i] + '</td> <td>' + data['OBIETTIVI']['info'][i] + '</td> </tr>';
				}
				document.getElementById("lblJsonCodeAlgo").innerHTML += '<div class="tab-content"><div class="tab-pane fade in active" id="tab_info"><div class="row"><div  class="col-lg-12"><div class="table-responsive"><table class="table" id="tableConfermate"><thead><tr><th></th><th>Esame</th><th>Descrizione</th></tr></thead><tbody>'+tabella+'</tbody></table></div></div></div></div></div>';
			} else if(lettera=="a"){
				document.getElementById("lblDescrizione").innerHTML = "Anamnesi relativa alla patologia selezionata";
				if(data['SINTOMI']['codice'].length!=0){
					var tabella="";
					for(var i=0;i<data['SINTOMI']['codice'].length;i++){
						var disabilita="";
							if(data['SINTOMI']['contenuto'][i]==true){
									disabilita = 'disabled="disabled" checked';
								}
						tabella = tabella + '<tr> <td> <input id="'+recupero_id+lettera+'" type="checkbox" class="checkAlgoDiagn" value="'+ data['SINTOMI']['codice'][i]+ '" '+disabilita+'/> </td> <td>' + data['SINTOMI']['descrizione'][i] + '</td> </tr>';
					}
					document.getElementById("lblJsonCodeAlgo").innerHTML += '<div class="tab-content"><div class="tab-pane fade in active" id="tab_info"><div class="row"><div  class="col-lg-12"><div class="table-responsive"><table class="table" id="tableConfermate"><thead><tr><th></th><th>Sintomi</th></tr></thead><tbody>'+tabella+'</tbody></table></div></div></div></div></div>';
				}
				if(data['REMOTA']['codice'].length!=0){
					var tabella="";
					for(var i=0;i<data['REMOTA']['codice'].length;i++){
						var disabilita="";
							if(data['REMOTA']['contenuto'][i]==true){
								disabilita = 'disabled="disabled" checked';
							}
						tabella = tabella + '<tr> <td> <input id="'+recupero_id+lettera+'" type="checkbox" class="checkAlgoDiagn" value="'+ data['REMOTA']['codice'][i] + '" '+disabilita+'/> </td> <td>' + data['REMOTA']['descrizione'][i] + '</td> </tr>';
					}
					document.getElementById("lblJsonCodeAlgo").innerHTML += '<div class="tab-content"><div class="tab-pane fade in active" id="tab_info"><div class="row"><div  class="col-lg-12"><div class="table-responsive"><table class="table" id="tableConfermate"><thead><tr><th></th><th>Anamnesi Patologica Remota</th></tr></thead><tbody>'+tabella+'</tbody></table></div></div></div></div></div>';
				}
				if(data['FAMILIARE']['codice'].length!=0){
					var tabella="";
					for(var i=0;i<data['FAMILIARE']['codice'].length;i++){
						var disabilita="";
							if(data['FAMILIARE']['contenuto'][i]==true){
								disabilita = 'disabled="disabled" checked';
							}
						tabella = tabella + '<tr> <td> <input id="'+recupero_id+lettera+'" type="checkbox" class="checkAlgoDiagn" value="'+ data['FAMILIARE']['codice'][i] + '" '+disabilita+'/> </td> <td>' + data['FAMILIARE']['descrizione'][i] + " (" + data['FAMILIARE']['gradoFamiliare'][i] + ")" + '</td> </tr>';
					}
					document.getElementById("lblJsonCodeAlgo").innerHTML += '<div class="tab-content"><div class="tab-pane fade in active" id="tab_info"><div class="row"><div  class="col-lg-12"><div class="table-responsive"><table class="table" id="tableConfermate"><thead><tr><th></th><th>Anamnesi Familiare</th></tr></thead><tbody>'+tabella+'</tbody></table></div></div></div></div></div>';
				}
			}else {
				document.getElementById("lblDescrizione").innerHTML = "Non sono presenti elementi";
				document.getElementById("lblJsonCodeAlgo").innerHTML = "";
			}				
		}); 
    }); //fine click function  
	
	$('#btn_concludivisita').click(function()
	{
			$('#btn_nuovavisita').html('<i class="icon-stethoscope"></i> Inizia Nuova Visita');
			$('#btn_nuovavisita').prop('disabled',false)
			
			$('#btn_concludivisita').prop('disabled',true);
			$('#btn_concludivisita').prop('class','btn btn-primary');
			
			$('#btn_annullavisita').prop('disabled',true);
			$('#btn_annullavisita').prop('class','btn btn-primary');
			
			$('#btn_stampavisita').prop('disabled',true);
			
			$('#btn_menu_nuovavisita').html('<i class="icon-stethoscope"></i> Nuova visita');
			$('#btn_menu_nuovavisita').prop('class','btn btn-primary btn-block')
			
			$('#avviso_no_visite').show();
			$('#display_visita').hide();
			
			//TODO submit delle operazioni di chiusura della visita
			
			$.post("formscripts/modvisita.php",
			{
				
				proprietario:	$("#proprietario").val(),
				datavisita:		$("#datavisita").val(),
				motivoVisita: 	$("#motivovisita").val(),
				osservazioni: 	$("#visita_osservazioni").val(),
				conclusioni: 	$("#visita_conclusioni").val(),
				visita_altezza: $("#visita_altezza").val(),
				visita_peso: 	$("#visita_peso").val(),
				visita_PAmax: 	$("#visita_PAmax").val(),
				visita_PAmin: 	$("#visita_PAmin").val(),
				visita_FC: 		$("#visita_FC").val(),
			},
  			function(status){
				$('#form_visita')[0].reset();
    			alert("Status: " + status);
  			});
			
			
			/*
			var form = $("#form_visita");
			
			form.submit();
			
			alert('Visita conclusa con successo');
			*/
	});	

	/*
	* Funzione algoritmo diagnostico Spera-Magarelli.
	* Tale che invia il codice della patologia da inserire come 
	* sospetta alla funzione salvaDiagnosiSospetta contenuta nella pagina modvisita.php.
	*/
	$("[name='btn_salvaDiagnosi']").click(function()	
	{
		var recupero_id = $(this).attr("id"); 

		var lunghezza = recupero_id.length;
		var lettera = recupero_id.substring(lunghezza-1, lunghezza);
		var code = recupero_id.substring(0, lunghezza-1);

		if (confirm('Aggiungere tra le diagnosi sospette?') == true){
			$.post("formscripts/modvisita.php",
			{		
				codeDiagnosiConf: code,
				lettera: lettera				
			},
  			function(status){
    			alert("Status: " + "Modifica effettuata");
                window.location.reload();
  			});
  		}
	});


	$('#btn_annullavisita').click(function()
	{
		if (confirm('Eliminare la visita corrente?') == true)
		{
			$('#btn_nuovavisita').html('<i class="icon-stethoscope"></i> Inizia Nuova Visita');
			$('#btn_nuovavisita').prop('disabled',false)
			
			$('#btn_concludivisita').prop('disabled',true);
			$('#btn_concludivisita').prop('class','btn btn-primary');
			
			$('#btn_annullavisita').prop('disabled',true);
			$('#btn_annullavisita').prop('class','btn btn-primary');
			
			$('#btn_menu_nuovavisita').html('<i class="icon-stethoscope"></i> Nuova visita');
			$('#btn_menu_nuovavisita').prop('class','btn btn-primary btn-block')
			
			$('#btn_stampavisita').prop('disabled',true);
			
			$('#avviso_no_visite').show();
			$('#display_visita').hide();
			
			$('#form_visita')[0].reset();	
		}
	});	


	$('#btn_annullaAlgo').click(function()
	{
		if (confirm('Terminare l\'algoritmo?') == true)
		{
			$('#btn_avviaAlgo').html('<i class="icon-list"></i> Avvia algoritmo diagnostico');
			$('#btn_avviaAlgo').prop('disabled',false)
			
			$('#btn_annullaAlgo').prop('disabled',true);
			$('#btn_annullaAlgo').prop('class','btn btn-warning');
			
			$('#avviso_no_visite').show();
			$('#display_algoritmo').hide();	
			$('#lblJsonAlgoritmo').empty();	
		}
	});
	
	 $("#visita_fileupl").fileinput({
        uploadAsync: false,
        uploadUrl: "files/upload.php"
		/*
		// è possibile inserire ulteriori informazioni da trasmettere al server
        uploadExtraData: function() {
            return {
                userid: $("#userid").val(),
                username: $("#username").val()
            };
        }*/

    });
	
	$('#btn_nuovadiagnosi').click(function()
	{
		$("#diagnosiModal").modal('show');
		$("#titolo_moddiagnosi").text('Nuova Diagnosi');
		$('#form_moddiagnosi')[0].reset();
		$("option:selected").prop("selected", false)	
		$('#tabs_diagnosi a[href="#tab_moddiagnosi"').tab('show');
		$("#tabella_terfarm").empty();
		$("#box_dettagliterfarm").empty();
		$("#diag_patologia_helpblock").empty();
		
	});
	
	$('#form_visita').validate({
        rules: {
            datavisita: {
                required: true,
                date: true
            },
			visita_altezza: {
                digits: true
            },
			visita_peso: {
                digits: true
            },
			visita_PAmin: {
                digits: true
            },
			visita_PAmax: {
                digits: true
            },
			visita_FC: {
                digits: true
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
    });
	
	
	$('#dataTables-visita_diagnosi').dataTable({
		 //paging: false
	});
	
	$('body').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });
	
	$("#diagnosiModal").on('shown.bs.modal', function(e){
		$("#diagnosi_osservazioni").height( $("#diagnosi_osservazioni")[0].scrollHeight);
	});
	
	$('#tabs_diagnosi a[href="#tab_moddiagnosi"').on('shown.bs.tab', function(e){
		$("#diagnosi_osservazioni").height( $("#diagnosi_osservazioni")[0].scrollHeight);
	});
	
	
	
	$('#diag_patologia').autocomplete({
		serviceUrl: 'formscripts/getpatologie.php',
		//minChars: 3, //numero minimo di caratteri richiesto per avviare l'autocomplete
		onSelect: function (suggestion) {
			$("#diag_patologia_helpblock").html('Patologia selezionata: <b>' + suggestion.value + '</b> - codice:<b>' + suggestion.data+'</b>');
		}
	});
	
	$('#btn_nuovaterfarm').click(function()
	{
		$("#box_dettagliterfarm").html('<div class="box dark">'+
											'<header>'+
												 '<h5>Nuova terapia farmacologica</h5>'+
												'<div class="toolbar">'+
													 '<ul class="nav">'+
														   '<li onclick="annullanuovaterfarm()"><a id="btn_annullanuovaterfarm"><i class="icon-remove icon-white" ></i> Annulla</a></li>'+
													 '</ul>'+
												'</div>'+
											'</header>'+
											'<div class="body">'+
												'<div class="row">'+									
												'<div class="col-lg-12">'+									
													'<div class="form-group">'+
														'<label class="control-label col-lg-4">Farmaco:</label>'+
														'<div class="col-lg-8">'+
														'<input class="form-control" type="text" id="terfarm_farmaco" onclick="autocompl_listafarmaci()">'+
														'<span class="help-block" id="listafarmaci_helpblock"></span>'+
														'</div>'+
													'</div>'+
													'<div class="form-group">'+
														'<label class="control-label col-lg-4">Forma farmaceutica:</label>'+
														'<div class="col-lg-8">'+
														'<select class="form-control" id="terfarm_formafarmaceutica">'+ 
														'</select>'+
														'</div>'+
													'</div>'+
													'<div class="form-group">'+
														'<label class="control-label col-lg-4">Somministrazione:</label>'+
														'<div class="col-lg-8">'+
														'<input class="form-control" type="text" id="terfarm_somministrazione">'+
														'</div>'+
													'</div>'+
													'<div class="form-group">'+
														'<label class="control-label col-lg-4">Frequenza:</label>'+
														'<div class="col-lg-8">'+
														'<input class="form-control" type="text" id="terfarm_frequenza">'+
														'</div>'+													
													'</div>'+
													'<div class="form-group">'+
                                                        '<label class="control-label col-lg-4">Data inizio:</label>'+
                                                        '<div class="col-lg-8">'+
                                                            '<input type="date" id="terfarm_datainizio" class="form-control">'+
                                                        '</div>'+                                  
													'</div>'+
													'<div class="form-group">'+
														'<label class="control-label col-lg-4">Data fine:</label>'+
														'<div class="col-lg-8">'+
															'<input type="date" id="terfarm_datafine" class="form-control">'+
														'</div>'+                                
													'</div>'+
												'</div>'+
												'<div class="col-lg-12">'+
													'<center><a href="#" class="btn btn-danger"><i class="icon-save"></i> Salva nuova terapia farmacologica</a></center>'+
												'</div>'+
												'</div>'+
														
											'</div>'+
										'</div>');	

	});
	
});

/*
* Funzione algoritmo diagnostico Spera-Magarelli.
* Questa funzione permette salvataggio delle checkbox selezionate nelle 4 
* categorie (sintomi, esami obiettivi, esami di laboratorio e strumentali) dell’algoritmo diagnostico
*/
function salvaCheckAlgoDiag(){
	var checkedValue = null; 
	var somma = [];
	var inputElements = document.getElementsByClassName('checkAlgoDiagn');
	var recupero_id = $(inputElements).attr("id");

	var lunghezza = recupero_id.length;
	var lettera = recupero_id.substring(lunghezza-1, lunghezza);
	var codeDiagnosi = recupero_id.substring(0, lunghezza-2);		

	for(var i=0; inputElements[i]; ++i){
		if((inputElements[i].checked)&&(inputElements[i].disabled==false)){
			checkedValue = inputElements[i].value;
			somma.push(checkedValue);
		}
	}

	$.post("formscripts/modvisita.php",
		{		
			codeDiagnosi: codeDiagnosi,
			lettera: lettera,
			checkedValCode:	somma,
			
		},
			function(status){
			
			alert("Status: " + "Modifica effettuata");
            window.location.reload();
			});
}

/*
* Funzione algoritmo diagnostico Spera-Magarelli.
* Questa funzione permette di mostrare una lista modificabile (5-10-All) 
* delle possibili patologie diagnosticate dall’algoritmo.
*/
function cambiaNumPatologie(index){
	if(index==0){
		$('.righe').hide();
		$('#0').show();
		$('#1').show();
		$('#2').show();
		$('#3').show();
		$('#4').show();	
	} else if(index==1){
		$('.righe').hide();
		$('#0').show();
		$('#1').show();
		$('#2').show();
		$('#3').show();
		$('#4').show();
		$('#5').show();
		$('#6').show();
		$('#7').show();
		$('#8').show();
		$('#9').show();
	} else {
		$('.righe').show();
	}
}

function annullanuovaterfarm()
	{
		$("#box_dettagliterfarm").empty();
	}

function autocompl_listafarmaci(){
	$('#terfarm_farmaco').autocomplete({
		serviceUrl: 'formscripts/getfarmaci.php',
		//minChars: 3, //numero minimo di caratteri richiesto per avviare l'autocomplete
		onSelect: function (suggestion) {
			$("#listafarmaci_helpblock").html('Farmaco selezionato: <b>' + suggestion.value + '</b> - codice ATC:<b>' + suggestion.data+'</b>');
			
			$.post("formscripts/getformafarmaceutica.php",
			{
				codice_farmaco:	suggestion.data
			},
  			function(json_formafarm){
				var formafarm = JSON.parse(json_formafarm);
				$("#terfarm_formafarmaceutica").empty();
				for	(var index = 0; index < formafarm.length; index++) {
					$("#terfarm_formafarmaceutica").append('<option val="'+formafarm[index]+'">'+formafarm[index]+'</option>');
				}			
			});
		}
	});
}
