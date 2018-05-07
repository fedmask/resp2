@extends('layouts.app')
@extends('includes.template_head')

@section('pageTitle', 'Indagini')
@section('content')
<!--PAGE CONTENT -->
<!--nella pagina vengono riportate in sezioni diverse le indagini diagnostiche richieste nella pagina "indagini richieste",
le indagini diagnostiche programmate , quelle effettuate, quelle refertate,queste devono essere evidenziabili
se rilevanti per la storiaclinica -->

 
 		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="assets/js/moment-with-locales.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
        <script src="formscripts/jquery-ui.js"></script>
        <script src="formscripts/indagini.js"></script>
 
 <div id="content">
   <div class="inner" style="min-height:1200px;">
      <div class="row">
          <div class="col-lg-12">
 
        <hr>
        <h2>Indagini diagnostiche</h2>
        <hr/>
 
       <!-- ACCORDION -->
        <div class="panel-group ac" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading row">
                    <div class="col-lg-6">
                        <h3><a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><i class="icon-book"></i>
                                Diario indagini diagnostiche</a></h3>
                    </div>
                    <div class="col-lg-6">
                        <h3><a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><i class="icon-map-marker"></i>
                            Centri indagini diagnostiche</a></h3>
                    </div>
                </div>
 
                <!-- COLLAPSE DIARIO INDAGINI DIAGNOSTICHE -->
                <div id="collapse1" class="panel-collapse collapse in"><hr/>
 
                    <!-- FORM NUOVA INDAGINE -->
                <div class="row">
                    <div class="col-lg-12" >
                        <div class="btn-group">
                            <button class="btn btn-primary" id="nuovoFile"><i class="icon-file-text-alt"></i> Nuova indagine</button>
                            <button class="btn btn-primary" id="concludi" onclick="nuovaIndagine()"><i class="icon-ok-sign"></i> Concludi indagine</button>
                            <button class="btn btn-primary" id="annulla"><i class="icon-trash"></i> Annulla indagine</button>
                        </div>
                    </div>
                </div>
                
                <script >

                
                $('#concludi').prop('disabled',true);
                $('#annulla').prop('disabled',true);

                $('#nomeCp').prop('disabled',true);
                $('#cognomeCp').prop('disabled',true);

                $('#responso').prop('disabled',true);

                 $('#formModal').on('shown.bs.modal', function() {
                	 
                	});

                $("#nuovoFile").click(function(){
                	
                    $("#formIndagini").show(200);
                	$('#nuovoFile').prop('disabled',true);
                	$('#concludi').prop('disabled',false);
                	$('#annulla').prop('disabled',false);
                });

                $("#annulla").click(function(){
                	
                    $("#formIndagini").hide(200);
                	$('#nuovoFile').prop('disabled',false);
                	$('#concludi').prop('disabled',true);
                	$('#annulla').prop('disabled',true);
                });

                //imposta il form della nuova indagine in base allo stato selezionato
                function stato(){
                var stato = document.getElementById("statoIndagine_new").value;

                if(stato == 0){
                	document.getElementById("divCentro_new").style.display = 'none';
                	document.getElementById("divData_new").style.display = 'none';
                	document.getElementById("divReferto_new").style.display = 'none';
                	document.getElementById("divAllegato_new").style.display = 'none';
                    }
                if(stato == 1){
                	document.getElementById("divCentro_new").style.display = 'block';
                	document.getElementById("divData_new").style.display = 'block';
                	document.getElementById("divReferto_new").style.display = 'none';
                	document.getElementById("divAllegato_new").style.display = 'none';
                    }
                if(stato == 2){
                	document.getElementById("divCentro_new").style.display = 'block';
                	document.getElementById("divData_new").style.display = 'block';
                	document.getElementById("divReferto_new").style.display = 'block';
                	document.getElementById("divAllegato_new").style.display = 'block';
                    
                    }
                }

                //permette di visaulizzare l'input text 'altra motivazione' nel form della nuova indagine
                function altraMotivazione(){
             	   var motivo = document.getElementById("motivoIndagine_new").value;
                    if(motivo == 0){
                 	   document.getElementById("motivoAltro_new").type = "text";
                    }else{
                 	   document.getElementById("motivoAltro_new").type = "hidden";
                        }
                    }

              //permette di visaulizzare l'input text 'nuovo careprovider' nel form della nuova indagine
                function altroCpp(){
             	   var cpp = document.getElementById("cppIndagine_new").value;
                    if(cpp == -1){
                 	   document.getElementById("cppAltro_new").type = "text";
                 	   }else{
                 	   document.getElementById("cppAltro_new").type = "hidden";
                 	   }
                    }
                

              //permette di inserire una nuova indagine
               function nuovaIndagine(){
            	   
            	   var tipo = document.getElementById("tipoIndagine").value;

            	   var motivo;
            	   if(document.getElementById("motivoIndagine_new").value == 0){
                	   motivo = document.getElementById("motivoAltro_new").value;
                	   }else{
                		   motivo = document.getElementById("motivoIndagine_new").value;
                    	   }

           		var Cpp; 
           		var idCpp;
           		
           			Cpp = document.getElementById("cppIndagine_new").value;
           			var options = cppIndagine_new.options;
           			idCpp = options[options.selectedIndex].id;

           			if(document.getElementById("cppIndagine_new").value == -1){
                   		Cpp = document.getElementById("cppAltro_new").value;
                   		idCpp = 0;
               		}
            		var idPaz = document.getElementById("idPaziente").value;
            		var stato = document.getElementById("statoIndagine_new").value;

            		var centro = $("#centroIndagine_new").find('option:selected').attr('id');

            		var dataVis = document.getElementById("addIndagineData").value; 

            		var referto = document.getElementById("referto_new").value;
            		var allegato = document.getElementById("allegato_new").value; 

            		if(stato == '0'){
                		if((tipo == '' || motivo == '') || (Cpp == '') || (idPaz == '' || stato == '')){
                            alert("Inserire tutti i campi");
                		}else{
                    		window.location.href = "http://localhost:8000/addIndRichiesta/"+tipo+"/"+motivo+"/"+Cpp+"/"+idCpp+"/"+idPaz+"/"+stato;

                    		$('#formIndagini')[0].reset();
                    		
                    		}	
                		}

            		if(stato == '1'){
                		if((tipo == '' || motivo == '') || (Cpp == '') || (idPaz == '' || stato == '') || (centro == ''|| dataVis=='')){
                			alert("Inserire tutti i campi");
                    		}else{

                        		window.location.href = "http://localhost:8000/addIndProgrammata/"+tipo+"/"+motivo+"/"+Cpp+"/"+idCpp+"/"+idPaz+"/"+stato+"/"+centro+"/"+dataVis;
                        		$('#formIndagini')[0].reset();
                        		}
                		}

            		if(stato == '2'){
                		if((tipo == '' || motivo == '') || (Cpp == '') || (idPaz == '' || stato == '') || (centro == ''|| dataVis=='') || (referto == ''|| allegato == '')){
                			alert("Inserire tutti i campi");
                    		}else{

                        		window.location.href = "http://localhost:8000/addIndCompletata/"+tipo+"/"+motivo+"/"+Cpp+"/"+idCpp+"/"+idPaz+"/"+stato+"/"+centro+"/"+dataVis+"/"+referto+"/"+allegato;
                        		$('#formIndagini')[0].reset();
                        		}
                		}
                  		
              	}

              //gestisce le button per la modifica
               $(document).on('click', "button.modifica", function () {
            	    $(this).prop('disabled', true);
            	    $('#'+$(this).attr('id')+'.elimina').prop('disabled', true);
            	    var id = '#form'+$(this).attr('id');
            	    $(id).show(200);
            	});

              //gestisce le button per l'eliminazione
               $(document).on('click', "button.elimina", function () {

                var idInd = $(this).attr('id');

           	    var idUt = {{($current_user->data_patient()->first()->id_utente)}};

           	    var href="http://localhost:8000/delInd/"+idInd+"/"+idUt;

           	    if(confirm("Confermi di voler eliminare l'indagine?")){
           	            window.location.href=href;
           	        }else{
               	        windows.location.reload();
           	        }
               	});

              	

              //gestisce le button per confermare la modifica
               $(document).on('click', "a.conferma", function () {
            		var id = $(this).attr('data-id');
            		var tipo = $('#tipoIndagine'+id).val();
            		var motivo = $('#motivoIndagine_new'+id).val();
            		if(motivo == 0){
                 	   motivo = $('#motivoAltro_new'+id).val();
                 	   }else{
                 		   motivo = $('#motivoIndagine_new'+id).val();
                       }

            		var href;
            		var Cpp; 
               		var idCpp;

               			Cpp = $("#cppIndagine_new"+id).val(); 
               			idCpp = $("#cppIndagine_new"+id).find('option:selected').attr('id');

                 			if(idCpp == ''){
                   			idCpp = 0;
                   		}
               			  if(Cpp == -1){
                       		Cpp = $("#cppAltro_new"+id).val();
                       		idCpp = 0;
                   		}

                		var idPaz = $("#idPaziente"+id).val();
                		var stato = $("#statoIndagine_new"+id).val();

                		var centro = $("#centroIndagine_new"+id).find('option:selected').attr('id');

                		
                		var dataVis = $("#date"+id).val();

                		var referto = $("#refertoIndagine_new"+id).val();
                		var allegato = $("#allegatoIndagine_new"+id).val();

                		if(stato == '0'){
                			href = "http://localhost:8000/ModIndRichiesta/"+id+"/"+tipo+"/"+motivo+"/"+Cpp+"/"+idCpp+"/"+idPaz+"/"+stato;
                    		}

                		if(stato == '1'){

                			href = "http://localhost:8000/ModIndProgrammata/"+id+"/"+tipo+"/"+motivo+"/"+Cpp+"/"+idCpp+"/"+idPaz+"/"+stato+"/"+centro+"/"+dataVis;
                    		}

                		if(stato == '2'){
                      		href = "http://localhost:8000/ModIndCompletata/"+id+"/"+tipo+"/"+motivo+"/"+Cpp+"/"+idCpp+"/"+idPaz+"/"+stato+"/"+centro+"/"+dataVis+"/"+referto+"/"+allegato;
                		} 
              	   window.location.href=href;
            		
           	});

              </script>
                
                <form style="display:none;" id="formIndagini" action="formscripts/indagini.php" method="POST" class="form-horizontal" >
                    <div class="tab-content">
                        <div class="row">
                             <div >
                                <div class="col-lg-12" style="display:none;">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">ID Paziente:</label>
                                        <div class="col-lg-4">
                                            <input id="idPaziente" readonly value="{{$current_user->idPazienteUser()}}" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="display:none;">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">ID CP:</label>
                                        <div class="col-lg-4">
                                            @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
							<input id="cpId" readonly value="$current_user->id_utente" class="form-control"/>
							@else
							<input id="cpId" readonly value="-1" class="form-control"/>
							@endif
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End hidden row -->
                            <div hidden class="col-lg-6 alert alert-danger" id="formAlert_new" role="alert"  style="float: none; margin: 0 auto;">
                                <div style="text-align: center;">
                                    <i class="glyphicon glyphicon-exclamation-sign" ></i>
                                    <strong>Attenzione:</strong> Compilare correttamente i campi bordati in rosso.
                                </div>
                            </div></br>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Tipo indagine *</label>
                                    <div class="col-lg-4">
                                        <input id="tipoIndagine" type="text"  class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Motivo *</label>
                                    <div class="col-lg-4">
                                        <select id="motivoIndagine_new" class="form-control" onchange="altraMotivazione()">
                                            <option selected hidden style='display: none' value="placeholder">Selezionare una motivazione..</option>
                                            <optgroup label="Diagnosi del paziente">
                                            @foreach($current_user->diagnosi() as $d)
                                            <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}" >{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>
                                            @endforeach
                                            </optgroup>
                                            <option value="0">Altra Motivazione..</option>
                                        </select>
                                        <input id="motivoAltro_new" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Care provider *</label>
                                    <div class="col-lg-4">
                              <select id="cppIndagine_new" class="form-control" onchange="altroCpp()">
                                            <option selected hidden style='display: none' value="placeholder">Selezionare un Care Providers..</option>
                                            <optgroup label="Care Providers">
						@foreach($current_user->cppToUserInd() as $ind)
						<?php $in = explode("-", $ind)?>
                           <option id="{{($in[1])}}" value="{{($in[0])}}">{{($in[0])}}</option>
                        @endforeach
                                    </optgroup>
                                    <option value="-1">Nuovo Care Providers..</option>
                   </select>
                                        <input id="cppAltro_new" type="hidden" placeholder="Inserire CareProvider"  class="form-control"/>
                                              </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Stato *</label>
                                    <div class="col-lg-4">
                                        <select id="statoIndagine_new" class="form-control" onchange="stato()">
                                            <option selected value="0">Richiesta</option>
                                            <option value="1">Programmata</option>
                                            <option value="2">Completata</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divCentro_new" style="display:none;">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Centro *</label>
                                    <div class="col-lg-4">
                                        <select id="centroIndagine_new" class="form-control">
                                            <option selected hidden style='display: none' value="placeholder">Selezionare un centro..</option>
                                            <optgroup label="Centri Diagnostici">
                                            @foreach($current_user->centriIndagini() as $centri)
                                            <option id="{{($centri->id_centro)}}" value="{{($centri->centro_nome)}}">{{$centri->centro_nome}}</option>
                                            @endforeach                                            
                                            </optgroup>
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divData_new" style="display:none;">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Data*</label>
                                    <div class="col-lg-4">
                                        {{Form::date('date','', ['id'=>"addIndagineData", 'name'=>"addIndagineData", 'class' => 'form-control col-lg-6'])}}
                                    </div>
                                      
                                </div>
                            </div>
                            <div class="col-lg-12" id="divReferto_new" style="display:none;">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Referto</label>
                                    <div class="col-lg-4" >
                                        <input id="referto_new" type="text"  class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divAllegato_new" style="display:none;">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Allegato</label>
                                    <div class="col-lg-4">
                                        <input id="allegato_new" type="text"  class="form-control"/>
                                    </div>
                                </div>
                                <div class=" col-lg-6 alert alert-info" role="alert" style="float: none; margin: 0 auto;" >
                                    <div style="text-align:center;">
                                        <strong>Attenzione:</strong> Per selezionare un file come referto o allegato è necessario caricarlo
                                        preventivamente nella sezione <strong>Files</strong>.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- FINE FORM NUOVA INDAGINE -->
                <br>
 
                <!-- STRINGA DIAGNOSI SE ACCESSO DA POST -->
                <div id="info_diagnosi" align="center"><h4> </h4></div>
 
                <!-- TABELLA INDAGINI RICHIESTE -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-warning">
                            <div class="panel-heading">Indagini Richieste</div>
                            <div class=" panel-body">
                                <div class="table-responsive" >
                                    <table class="table" id="tableRichieste">
                                        <thead>
                                        <tr>
                                            <th>Indagine</th
                                            ><th>Motivo</th>
                                            <th>Care provider</th>
                                            <th style="text-align:center">Opzioni</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($current_user->indagini() as $ind)
															 @if($ind->indagine_stato === '0')
															 
															 <tr>
															 <td>{{$ind->indagine_tipologia}} </td>
															 <td>{{$ind->indagine_motivo}} </td>
															 <td>{{$ind->careprovider}} </td>
															 <td>
															 <table>
															 <tr>
															 <td><button id="{{($ind->id_indagine)}}" class="modifica btn btn-success" ><i class="icon-pencil icon-white"></i></button></td>
                                                             <td><button id="{{($ind->id_indagine)}}" class="elimina btn btn-danger"><i class="icon-remove icon-white"></i></button></td>
                                                             </tr>
                                                             </table>
                                                             </td>
															 </tr>
															 
															 
															 <tr id="rigaModR" >
															 <td colspan="7">
															 <form style="display:none;" id="form{{($ind->id_indagine)}}" class="form-horizontal" >
                    <div class="tab-content">
                        <div class="row">
                             <div >
                                <div class="col-lg-12" style="display:none;">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">ID Paziente:</label>
                                        <div class="col-lg-4">
                                            <input id="idPaziente{{($ind->id_indagine)}}" readonly value="{{$current_user->idPazienteUser()}}" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="display:none;">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">ID CP:</label>
                                        <div class="col-lg-4">
                                            @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
							<input id="cpIdR" readonly value="$current_user->id_utente" class="form-control"/>
							@else
							<input id="cpIdR" readonly value="-1" class="form-control"/>
							@endif
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End hidden row -->
                            <div hidden class="col-lg-6 alert alert-danger" id="formAlert_new{{($ind->id_indagine)}}" role="alert"  style="float: none; margin: 0 auto;">
                                <div style="text-align: center;">
                                    <i class="glyphicon glyphicon-exclamation-sign" ></i>
                                    <strong>Attenzione:</strong> Compilare correttamente i campi bordati in rosso.
                                </div>
                            </div></br>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Tipo indagine *</label>
                                    <div class="col-lg-4">
                                        <input value="{{($ind->indagine_tipologia)}}"id="tipoIndagine{{($ind->id_indagine)}}" type="text"  class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Motivo *</label>
                                    <div class="col-lg-4">
                                        <select id="motivoIndagine_new{{($ind->id_indagine)}}" class="form-control" >
                                            <option id="{{($ind->indagine_motivo)}}--{{(Carbon\Carbon::parse($ind->indagine_aggiornamento)->format('d-m-Y') )}}" hidden style='display: none' selected value="{{($ind->indagine_motivo)}}--{{(Carbon\Carbon::parse($ind->indagine_aggiornamento)->format('d-m-Y') )}}">{{$ind->indagine_motivo}} del {{Carbon\Carbon::parse($ind->indagine_aggiornamento)->format('d-m-Y')}}</option>
                                            <optgroup label="Diagnosi del paziente">
                                            @foreach($current_user->diagnosi() as $d)
                                            <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}" >{{($d->diagnosi_patologia)}} del {{Carbon\Carbon::parse($d->diagnosi_inserimento_data)->format('d-m-Y') }}</option>
                                            @endforeach
                                            </optgroup>
                                            <option value="0">Altra Motivazione..</option>
                                        </select>
                                        <input id="motivoAltro_new{{($ind->id_indagine)}}" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Care provider *</label>
                                    <div class="col-lg-4">
                              <select id="cppIndagine_new{{($ind->id_indagine)}}" class="form-control" >
                                <?php $i = explode("-", $current_user->cppInd($ind->id_diagnosi))?>            
						<option hidden style='display: none' id="{{($i[1])}}" selected  value="{{($i[0])}}">{{$i[0]}}</option>
                                            <optgroup label="Care Providers">
						@foreach($current_user->cppToUserInd() as $inda)
						<?php $in = explode("-", $inda)?>
                           <option id="{{($in[1])}}" value="{{($in[0])}}">{{($in[0])}}</option>
                        @endforeach
                                    </optgroup>
                                    <option value="-1">Nuovo Care Providers..</option>
                   </select>
                                        <input id="cppAltro_new{{($ind->id_indagine)}}" type="hidden" placeholder="Inserire CareProvider"  class="form-control"/>
                                              </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Stato *</label>
                                    <div class="col-lg-4">
                                        <select id="statoIndagine_new{{($ind->id_indagine)}}" class="form-control" >
                                            <option selected value="0">Richiesta</option>
                                            <option value="1">Programmata</option>
                                            <option value="2">Completata</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divCentro_new{{($ind->id_indagine)}}" style="display:none;">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Centro *</label>
                                    <div class="col-lg-4">
                                        <select id="centroIndagine_new{{($ind->id_indagine)}}" class="form-control">
                                            <option selected hidden style='display: none' value="placeholder">Selezionare un centro..</option>
                                            <optgroup label="Centri Diagnostici">
                                            @foreach($current_user->centriIndagini() as $centri)
                                            <option id="{{($centri->id_centro)}}" value="{{($centri->centro_nome)}}">{{$centri->centro_nome}}</option>
                                            @endforeach 
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divData_new{{($ind->id_indagine)}}" style="display:none;">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Data*</label>
                                    <div class="col-lg-4">
                                       <?php $d = explode(" ", $ind->indagine_data) ?>
                                      <input id="date{{($ind->id_indagine)}}" value="{{($d[0])}}" type="date" class="form-control col-lg-6">
                                   </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divReferto_new{{($ind->id_indagine)}}" style="display:none;">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Referto</label>
                                    <div class="col-lg-4" >
                                        <input id="refertoIndagine_new{{($ind->id_indagine)}}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divAllegato_new{{($ind->id_indagine)}}" style="display:none;">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Allegato</label>
                                    <div class="col-lg-4">
                                        <input id="allegatoIndagine_new{{($ind->id_indagine)}}" class="form-control">
                                    </div>
                                </div>
                                <div class=" col-lg-6 alert alert-info" role="alert" style="float: none; margin: 0 auto;" >
                                    <div style="text-align:center;">
                                        <strong>Attenzione:</strong> Per selezionare un file come referto o allegato è necessario caricarlo
                                        preventivamente nella sezione <strong>Files</strong>.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="text-align:center;">
                    <a href="" onclick="annullaR()" class=annulla id="annullaR"><button class="btn btn-danger"><i class="icon icon-undo"></i> Annulla modifiche</button></a>
                    <a onclick="return false;" class=conferma data-id="{{($ind->id_indagine)}}"><button class="btn btn-success"><i class="icon icon-check"></i> Conferma modifiche</button></a>
                </div>
                    </div>
                </form>
                
                </td>
															 </tr>

									<script>

					   //imposta lo stato del form per la modifica di una indagine richiesta
						$('#form{{($ind->id_indagine)}}').change('statoIndagine_new{{($ind->id_indagine)}}', function(){

							var stato = $('#statoIndagine_new{{($ind->id_indagine)}}').val();

							if(stato == 0){

								$("#divCentro_new{{($ind->id_indagine)}}").hide();
								$("#divData_new{{($ind->id_indagine)}}").hide();
								$("#divReferto_new{{($ind->id_indagine)}}").hide();
								$("#divAllegato_new{{($ind->id_indagine)}}").hide();

								}

							if(stato == 1){

								$("#divCentro_new{{($ind->id_indagine)}}").show();
								$("#divData_new{{($ind->id_indagine)}}").show();
								$("#divReferto_new{{($ind->id_indagine)}}").hide();
								$("#divAllegato_new{{($ind->id_indagine)}}").hide();
							}

							if(stato == 2){

								$("#divCentro_new{{($ind->id_indagine)}}").show();
								$("#divData_new{{($ind->id_indagine)}}").show();
								$("#divReferto_new{{($ind->id_indagine)}}").show();
								$("#divAllegato_new{{($ind->id_indagine)}}").show();
							}

					      });
						//permette di visualizzare l'input text 'altra motivazione' nel form della modifica delle indagini richieste
						$('#form{{($ind->id_indagine)}}').change('motivoIndagine_new{{($ind->id_indagine)}}', function(){
							var motivo = $('#motivoIndagine_new{{($ind->id_indagine)}}').val();

							if(motivo == 0){
								
								document.getElementById("motivoAltro_new{{($ind->id_indagine)}}").type = "text";    
								}else{
									document.getElementById("motivoAltro_new{{($ind->id_indagine)}}").type = "hidden";

								}

							});
						//permette di visualizzare l'input text 'nuovo careprovider' nel form della modifica delle indagini richieste
						$('#form{{($ind->id_indagine)}}').change('cppIndagine_new{{($ind->id_indagine)}}', function(){
							var cpp = $('#cppIndagine_new{{($ind->id_indagine)}}').val();

							if(cpp == -1){
								
								document.getElementById("cppAltro_new{{($ind->id_indagine)}}").type = "text";    
								}else{
									document.getElementById("cppAltro_new{{($ind->id_indagine)}}").type = "hidden";

								}

							});
					
						
						
						</script>						
															 @endif
										                          @endforeach
										                          
							                          
                                        </tbody>
                                    </table>
                                </div>
                            </div>    <!--paneldanger-->
                        </div>    <!--col lg12-->
                    </div>
                </div><br>
                <!-- TABELLA INDAGINI PROGRAMMATE -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-danger">
                            <div class="panel-heading">Indagini Programmate</div>
                            <div class=" panel-body">
                                <div class="table-responsive" >
                                    <table class="table" id="tableProgrammate">
                                        <thead>
                                        <tr>
                                            <th>Indagine</th><th>Motivo</th><th>Care provider</th><th>Data</th>
                                            <th>Centro</th><th style="text-align:center">Opzioni</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($current_user->indagini() as $ind)
															 @if($ind->indagine_stato === '1')
															 
															 <tr>
															 <td>{{$ind->indagine_tipologia}} </td>
															 <td>{{$ind->indagine_motivo}} </td>
															 <td>{{$ind->careprovider}} </td>
															 <td><?php echo date('d/m/y', strtotime($ind->indagine_data)); ?> </td>
															 <td>{{$current_user->nomeCentroInd($ind->id_centro_indagine)}} </td>
															 <td><table>
															 <tr>
															 <td><button id="{{($ind->id_indagine)}}" class="modifica btn btn-success" ><i class="icon-pencil icon-white"></i></button></td>
                                                             <td><button id="{{($ind->id_indagine)}}" class="elimina btn btn-danger"><i class="icon-remove icon-white"></i></button></td>
                                                             </tr>
                                                             </table>
                                                             </td>											 
															 </tr>
															 <tr id="rigaModP" >
															 <td colspan="7">
															 <form style="display:none;" id="form{{($ind->id_indagine)}}" class="form-horizontal" >
                    <div class="tab-content">
                        <div class="row">
                             <div >
                                <div class="col-lg-12" style="display:none;">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">ID Paziente:</label>
                                        <div class="col-lg-4">
                                            <input id="idPaziente{{($ind->id_indagine)}}" readonly value="{{$current_user->idPazienteUser()}}" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="display:none;">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">ID CP:</label>
                                        <div class="col-lg-4">
                                            @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
							<input id="cpIdP" readonly value="$current_user->id_utente" class="form-control"/>
							@else
							<input id="cpIdP" readonly value="-1" class="form-control"/>
							@endif
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End hidden row -->
                            <div hidden class="col-lg-6 alert alert-danger" id="formAlert_new{{($ind->id_indagine)}}" role="alert"  style="float: none; margin: 0 auto;">
                                <div style="text-align: center;">
                                    <i class="glyphicon glyphicon-exclamation-sign" ></i>
                                    <strong>Attenzione:</strong> Compilare correttamente i campi bordati in rosso.
                                </div>
                            </div></br>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Tipo indagine *</label>
                                    <div class="col-lg-4">
                                        <input value="{{($ind->indagine_tipologia)}}"id="tipoIndagine{{($ind->id_indagine)}}" type="text"  class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Motivo *</label>
                                    <div class="col-lg-4">
                                        <select id="motivoIndagine_new{{($ind->id_indagine)}}" class="form-control" >
                                           <option id="{{($ind->indagine_motivo)}}--{{(Carbon\Carbon::parse($ind->indagine_aggiornamento)->format('d-m-Y') )}}" hidden style='display: none' selected value="{{($ind->indagine_motivo)}}--{{(Carbon\Carbon::parse($ind->indagine_aggiornamento)->format('d-m-Y') )}}">{{$ind->indagine_motivo}} del {{Carbon\Carbon::parse($ind->indagine_aggiornamento)->format('d-m-Y')}}</option>
                                            <optgroup label="Diagnosi del paziente">
                                            @foreach($current_user->diagnosi() as $d)
                                            <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}" >{{($d->diagnosi_patologia)}} del {{Carbon\Carbon::parse($d->diagnosi_inserimento_data)->format('d-m-Y') }}</option>
                                            @endforeach
                                            </optgroup>
                                            <option value="0">Altra Motivazione..</option>
                                        </select>
                                        <input id="motivoAltro_new{{($ind->id_indagine)}}" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Care provider *</label>
                                    <div class="col-lg-4">
                              <select id="cppIndagine_new{{($ind->id_indagine)}}" class="form-control" >
                                 <?php $i = explode("-", $current_user->cppInd($ind->id_diagnosi))?>
                                 <option hidden style='display: none' id="{{($i[1])}}" selected value="{{($i[0])}}">{{$i[0]}}</option>
                        <optgroup label="Care Providers">
						@foreach($current_user->cppToUserInd() as $inda)
						<?php $in = explode("-", $inda)?>
                           <option id="{{($in[1])}}" value="{{($in[0])}}">{{($in[0])}}</option>
                        @endforeach
                                    </optgroup>            
                                    <option value="-1">Nuovo Care Providers..</option>
                   </select>
                                        <input id="cppAltro_new{{($ind->id_indagine)}}" type="hidden" placeholder="Inserire CareProvider"  class="form-control"/>
                                              </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Stato *</label>
                                    <div class="col-lg-4">
                                        <select id="statoIndagine_new{{($ind->id_indagine)}}" class="form-control" >
                                            <option value="0">Richiesta</option>
                                            <option selected value="1">Programmata</option>
                                            <option value="2">Completata</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divCentro_new{{($ind->id_indagine)}}" >
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Centro *</label>
                                    <div class="col-lg-4">
                                       <select id="centroIndagine_new{{($ind->id_indagine)}}"  class="form-control">
                                            <option hidden style='display: none' id="{{($ind->id_centro_indagine)}}" selected value="{{($current_user->nomeCentroInd($ind->id_centro_indagine))}}">{{$current_user->nomeCentroInd($ind->id_centro_indagine)}}</option>
                                            <optgroup label="Centri Diagnostici">
                                             @foreach($current_user->centriIndagini() as $centri)
                                            <option id="{{($centri->id_centro)}}" value="{{($centri->centro_nome)}}">{{$centri->centro_nome}}</option>
                                            @endforeach 
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divData_new{{($ind->id_indagine)}}" >
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Data*</label>
                                    <div class="col-lg-4">
                                   <?php $d = explode(" ", $ind->indagine_data) ?>
                                        <input id="date{{($ind->id_indagine)}}" value="{{($d[0])}}" type="date" class="form-control col-lg-6">
                                     </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divReferto_new{{($ind->id_indagine)}}" style="display:none;">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Referto</label>
                                    <div class="col-lg-4" >
                                        <input id="refertoIndagine_new{{($ind->id_indagine)}}" class="form-control">
                                   </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divAllegato_new{{($ind->id_indagine)}}" style="display:none;">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Allegato</label>
                                    <div class="col-lg-4">
                                        <select id="allegatoIndagine_new{{($ind->id_indagine)}}" class="form-control">
                                            <input selected hidden style='display: none' value="" >Selezionare un file..</option>
                                   </div>
                                </div>
                                <div class=" col-lg-6 alert alert-info" role="alert" style="float: none; margin: 0 auto;" >
                                    <div style="text-align:center;">
                                        <strong>Attenzione:</strong> Per selezionare un file come referto o allegato è necessario caricarlo
                                        preventivamente nella sezione <strong>Files</strong>.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="text-align:center;">
                    <a href="" onclick="annullaP()" class=annulla id="annullaP"><button class="btn btn-danger"><i class="icon icon-undo"></i> Annulla modifiche</button></a>
                    <a href="" onclick="return false;" class=conferma data-id="{{($ind->id_indagine)}}"><button class="btn btn-success"><i class="icon icon-check"></i> Conferma modifiche</button></a>
                </div>
                    </div>
                </form>
                </td>
															 </tr>
									<script>

						//imposta lo stato del form per la modifica di una indagine programmata
						$('#form{{($ind->id_indagine)}}').change('statoIndagine_new{{($ind->id_indagine)}}', function(){

							var stato = $('#statoIndagine_new{{($ind->id_indagine)}}').val();

							if(stato == 0){

								$("#divCentro_new{{($ind->id_indagine)}}").hide();
								$("#divData_new{{($ind->id_indagine)}}").hide();
								$("#divReferto_new{{($ind->id_indagine)}}").hide();
								$("#divAllegato_new{{($ind->id_indagine)}}").hide();

								}

							if(stato == 1){

								$("#divCentro_new{{($ind->id_indagine)}}").show();
								$("#divData_new{{($ind->id_indagine)}}").show();
								$("#divReferto_new{{($ind->id_indagine)}}").hide();
								$("#divAllegato_new{{($ind->id_indagine)}}").hide();
							}

							if(stato == 2){

								$("#divCentro_new{{($ind->id_indagine)}}").show();
								$("#divData_new{{($ind->id_indagine)}}").show();
								$("#divReferto_new{{($ind->id_indagine)}}").show();
								$("#divAllegato_new{{($ind->id_indagine)}}").show();
							}

					      });

						//permette di visualizzare l'input text 'altra motivazione' nel form della modifica delle indagini programmate
						$('#form{{($ind->id_indagine)}}').change('motivoIndagine_new{{($ind->id_indagine)}}', function(){
							var motivo = $('#motivoIndagine_new{{($ind->id_indagine)}}').val();

							if(motivo == 0){
								
								document.getElementById("motivoAltro_new{{($ind->id_indagine)}}").type = "text";    
								}else{
									document.getElementById("motivoAltro_new{{($ind->id_indagine)}}").type = "hidden";

								}

							});

						//permette di visualizzare l'input text 'nuovo careprovider' nel form della modifica delle indagini programmate
						$('#form{{($ind->id_indagine)}}').change('cppIndagine_new{{($ind->id_indagine)}}', function(){
							var cpp = $('#cppIndagine_new{{($ind->id_indagine)}}').val();

							if(cpp == -1){
								
								document.getElementById("cppAltro_new{{($ind->id_indagine)}}").type = "text";    
								}else{
									document.getElementById("cppAltro_new{{($ind->id_indagine)}}").type = "hidden";

								}

							});
					
						</script>						
				
															 @endif
										                          @endforeach
															
                                        </tbody>
                                    </table>
                                </div>
                            </div>    <!--paneldanger-->
                        </div>    <!--col lg12-->
                    </div>
                </div><br>
                <!-- TABELLA INDAGINI COMPLETATE -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Indagini completate</div> 
                            <div class=" panel-body">
                                <div class="table-responsive" >
                                    <table class="table" id="tableCompletate">
                                        <thead>
                                        <tr>
                                            <th>Indagine</th><th>Motivo</th><th>Care provider</th><th>Data</th>
                                            <th style="text-align:center">Referto</th><th style="text-align:center">Allegati</th><th style="text-align:center">Opzioni</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($current_user->indagini() as $ind)
															 @if($ind->indagine_stato === '2')
															 
															 <tr>
															 <td>{{$ind->indagine_tipologia}} </td>
															 <td>{{$ind->indagine_motivo}} </td>
															 <td>{{$ind->careprovider}} </td>
															 <td><?php echo date('d/m/y', strtotime($ind->indagine_data)); ?> </td>
															 <td><button class="btn btn-info"  type="button" id="">
                                                                 <i class="icon-file-text"></i></button></a></td>
															 <td><button class="btn"  type="button" id="">
                                                                 <i class="icon-file-text"></i></button></a> </td>
															 <td><table>
															 <tr>
															 <td><button id="{{($ind->id_indagine)}}" class="modifica btn btn-success" ><i class="icon-pencil icon-white"></i></button></td>
                                                             <td><button id="{{($ind->id_indagine)}}" class="elimina btn btn-danger"><i class="icon-remove icon-white"></i></button></td>
                                                             </tr>
                                                             </table>
                                                             </td>
															 
															 </tr>
															 <tr id="rigaModC" >
															 <td colspan="7">
															 <form style="display:none;" id="form{{($ind->id_indagine)}}" class="form-horizontal" >
                    <div class="tab-content">
                        <div class="row">
                             <div >
                                <div class="col-lg-12" style="display:none;">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">ID Paziente:</label>
                                        <div class="col-lg-4">
                                            <input id="idPaziente{{($ind->id_indagine)}}" readonly value="{{$current_user->idPazienteUser()}}" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="display:none;">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">ID CP:</label>
                                        <div class="col-lg-4">
                                            @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
							<input id="cpIdC" readonly value="$current_user->id_utente" class="form-control"/>
							@else
							<input id="cpIdC" readonly value="-1" class="form-control"/>
							@endif
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End hidden row -->
                            <div hidden class="col-lg-6 alert alert-danger" id="formAlert_new{{($ind->id_indagine)}}" role="alert"  style="float: none; margin: 0 auto;">
                                <div style="text-align: center;">
                                    <i class="glyphicon glyphicon-exclamation-sign" ></i>
                                    <strong>Attenzione:</strong> Compilare correttamente i campi bordati in rosso.
                                </div>
                            </div></br>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Tipo indagine *</label>
                                    <div class="col-lg-4">
                                        <input value="{{($ind->indagine_tipologia)}}"id="tipoIndagine{{($ind->id_indagine)}}" type="text"  class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Motivo *</label>
                                    <div class="col-lg-4">
                                        <select id="motivoIndagine_new{{($ind->id_indagine)}}" class="form-control" >
                                            <option id="{{($ind->indagine_motivo)}}--{{(Carbon\Carbon::parse($ind->indagine_aggiornamento)->format('d-m-Y') )}}" hidden style='display: none' selected value="{{($ind->indagine_motivo)}}--{{(Carbon\Carbon::parse($ind->indagine_aggiornamento)->format('d-m-Y') )}}">{{$ind->indagine_motivo}} del {{Carbon\Carbon::parse($ind->indagine_aggiornamento)->format('d-m-Y')}}</option>
                                            <optgroup label="Diagnosi del paziente">
                                            @foreach($current_user->diagnosi() as $d)
                                            <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}" >{{($d->diagnosi_patologia)}} del {{Carbon\Carbon::parse($d->diagnosi_inserimento_data)->format('d-m-Y') }}</option>
                                            @endforeach
                                            </optgroup>
                                            <option value="0">Altra Motivazione..</option>
                                        </select>
                                        <input id="motivoAltro_new{{($ind->id_indagine)}}" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Care provider *</label>
                                    <div class="col-lg-4">
                              <select id="cppIndagine_new{{($ind->id_indagine)}}" class="form-control" >
                                     <?php $i = explode("-", $current_user->cppInd($ind->id_diagnosi))?>
                                     <option hidden style='display: none' id="{{($i[1])}}" selected value="{{($i[0])}}">{{$i[0]}}</option>
                                            <optgroup label="Care Providers">
						@foreach($current_user->cppToUserInd() as $inda)
                        <?php $in = explode("-", $inda)?>
                           <option id="{{($in[1])}}" value="{{($in[0])}}">{{($in[0])}}</option>
                           @endforeach
                                    </optgroup>
                                    <option value="-1">Nuovo Care Providers..</option>
                   </select>
                                        <input id="cppAltro_new{{($ind->id_indagine)}}" type="hidden" placeholder="Inserire CareProvider"  class="form-control"/>
                                              </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Stato *</label>
                                    <div class="col-lg-4">
                                        <select id="statoIndagine_new{{($ind->id_indagine)}}" class="form-control">
                                            <option value="0">Richiesta</option>
                                            <option value="1">Programmata</option>
                                            <option selected value="2">Completata</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divCentro_new{{($ind->id_indagine)}}" >
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Centro *</label>
                                    <div class="col-lg-4">
                                        <select id="centroIndagine_new{{($ind->id_indagine)}}"  class="form-control">
                                            <option hidden style='display: none' id="{{($ind->id_centro_indagine)}}" selected value="{{($current_user->nomeCentroInd($ind->id_centro_indagine))}}">{{$current_user->nomeCentroInd($ind->id_centro_indagine)}}</option>
                                            <optgroup label="Centri Diagnostici">
                                            @foreach($current_user->centriIndagini() as $centri)
                                            <option id="{{($centri->id_centro)}}" value="{{($centri->centro_nome)}}">{{$centri->centro_nome}}</option>
                                            @endforeach 
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divData_new{{($ind->id_indagine)}}" >
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Data*</label>
                                    <div class="col-lg-4">
                                   <?php $d = explode(" ", $ind->indagine_data) ?>
                                        <input id="date{{($ind->id_indagine)}}" value="{{($d[0])}}" type="date" class="form-control col-lg-6">
                                     </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divReferto_new{{($ind->id_indagine)}}">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Referto</label>
                                    <div class="col-lg-4" >
                                        <input id="refertoIndagine_new{{($ind->id_indagine)}}" value="{{($ind->indagine_referto)}}" class="form-control">
                                   </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divAllegato_new{{($ind->id_indagine)}}">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Allegato</label>
                                    <div class="col-lg-4">
                                        <input id="allegatoIndagine_new{{($ind->id_indagine)}}" value="{{($ind->indagine_allegato)}}" class="form-control">
                                    </div>
                                </div>
                                <div class=" col-lg-6 alert alert-info" role="alert" style="float: none; margin: 0 auto;" >
                                    <div style="text-align:center;">
                                        <strong>Attenzione:</strong> Per selezionare un file come referto o allegato è necessario caricarlo
                                        preventivamente nella sezione <strong>Files</strong>.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="text-align:center;">
                    <a href="" onclick="annullaC()" class=annulla id="annullaC"><button class="btn btn-danger"><i class="icon icon-undo"></i> Annulla modifiche</button></a>
                    <a href="" onclick="return false;" class=conferma data-id="{{($ind->id_indagine)}}"><button class="btn btn-success"><i class="icon icon-check"></i> Conferma modifiche</button></a>
                </div>
                    </div>
                </form>
                </td>
															 </tr>
			<script>

                       //imposta lo stato del form per la modifica di una indagine completata
						$('#form{{($ind->id_indagine)}}').change('statoIndagine_new{{($ind->id_indagine)}}', function(){

							var stato = $('#statoIndagine_new{{($ind->id_indagine)}}').val();

							if(stato == 0){

								$("#divCentro_new{{($ind->id_indagine)}}").hide();
								$("#divData_new{{($ind->id_indagine)}}").hide();
								$("#divReferto_new{{($ind->id_indagine)}}").hide();
								$("#divAllegato_new{{($ind->id_indagine)}}").hide();

								}

							if(stato == 1){

								$("#divCentro_new{{($ind->id_indagine)}}").show();
								$("#divData_new{{($ind->id_indagine)}}").show();
								$("#divReferto_new{{($ind->id_indagine)}}").hide();
								$("#divAllegato_new{{($ind->id_indagine)}}").hide();
							}

							if(stato == 2){

								$("#divCentro_new{{($ind->id_indagine)}}").show();
								$("#divData_new{{($ind->id_indagine)}}").show();
								$("#divReferto_new{{($ind->id_indagine)}}").show();
								$("#divAllegato_new{{($ind->id_indagine)}}").show();
							}

					      });

						//permette di visualizzare l'input text 'altra motivazione' nel form della modifica delle indagini completate
						$('#form{{($ind->id_indagine)}}').change('motivoIndagine_new{{($ind->id_indagine)}}', function(){
							var motivo = $('#motivoIndagine_new{{($ind->id_indagine)}}').val();

							if(motivo == 0){
								
								document.getElementById("motivoAltro_new{{($ind->id_indagine)}}").type = "text";    
								}else{
									document.getElementById("motivoAltro_new{{($ind->id_indagine)}}").type = "hidden";

								}

							});

						    //permette di visualizzare l'input text 'nuovo careprovider' nel form della modifica delle indagini completate
							$('#form{{($ind->id_indagine)}}').change('cppIndagine_new{{($ind->id_indagine)}}', function(){
							var cpp = $('#cppIndagine_new{{($ind->id_indagine)}}').val();

							if(cpp == -1){
								
								document.getElementById("cppAltro_new{{($ind->id_indagine)}}").type = "text";    
								}else{
									document.getElementById("cppAltro_new{{($ind->id_indagine)}}").type = "hidden";

								}

							});
					
						</script>						
				
															 @endif
										                          @endforeach
															
                                        </tbody>
                                    </table>
                                </div>
                            </div>    <!--paneldanger-->
                        </div>    <!--col lg12-->
                    </div><br>
        </div>
                </div>
                <!-- FINE COLLAPSE DIARIO INDAGINI DIAGNOSTICHE -->
 <script >

 //permette di aprire il form per l'invio di una mail ad un centro indagini
	$(document).on('click', "a.mail", function () {
		$(this).attr('data-target','#formModal');
		$("#nomeutente").val($(this).attr('data-id'));
		$("#mail").val("{{($current_user->getEmail())}}");

	});
	
	//permette di aprire il form per l'invio di un messaggio privato ad un cpp di un centro indagini
	$(document).on('click', "a.a-messaggio", function () {
		$(this).attr('data-target','#messageModal');
		
	});
	
	
	</script>
                <!-- COLLAPSE CENTRI INDAGINI DIAGNOSTICHE -->
                <div id="collapse2" class="panel-collapse collapse"><hr/>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-warning">
                                    <div class="panel-heading">Studi Specialistici</div>
                                    <div class=" panel-body">
                                        <div class="table-responsive" >
                                            <table class="table" id="tableStudiSpecialistici">
                                                <thead>
                                                <tr>
                                                    <th>Studio</th>
                                                    <th>Sede</th>
                                                    <th>Contatti</th>
                                                    <th>Mail</th>
                                                    <th style="text-align:center">Messaggio FSEM</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($current_user->centriIndagini() as $c)
                                                @if($c->id_tipologia === 1)
                                                <tr>
                                                <td> {{$c->centro_nome}} </td>
                                                <td> {{$c->centro_indirizzo}} </td>
                                                <td> 
                                                @foreach($current_user->contattoCentro($c->id_centro) as $cont)
                                                <i class="material-icons" style="font-size:16px">&#xe0cd;</i><a href="">{{$cont}}</a><br> 
                                                @endforeach
                                                </td>
                                                <td><button class="btn btn-warning"  type="button" id="btnSpec" value="{{($c->centro_mail)}}"  >
                                                    <i class="icon-envelope"></i></button> <!-- data-target="#formModal" -->
                                                    <a class="mail" data-id="{{($c->centro_mail)}}" data-toggle="modal" href="">{{$c->centro_mail}}</a> 
                                                    </td>
                                                <td> <button class="btn-messaggio btn"  type="button" id="" ><i class="material-icons" style="font-size:16px">&#xe0cb;</i></button>
                                                <a  class="a-messaggio" data-id="{{$current_user->cppPersCont($c->id_centro)}}" data-toggle="modal" href="">{{$current_user->cppPersCont($c->id_centro)}} </a>
                                                 </td>
                                                </tr>
                                                @endif
                                                @endforeach
                                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>    <!--paneldanger-->
                            </div>    <!--col lg12-->
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-danger">
                                    <div class="panel-heading">Studi Radiologici</div>
                                    <div class=" panel-body">
                                        <div class="table-responsive" >
                                            <table class="table" id="tableStudiRadiologici">
                                                <thead>
                                                <tr>
                                                    <th>Studio</th><th>Sede</th><th>Contatti</th><th>Mail</th><th style="text-align:center">Messaggio FSEM</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($current_user->centriIndagini() as $c)
                                                @if($c->id_tipologia === 2)
                                                <tr>
                                                <td> {{$c->centro_nome}} </td>
                                                <td> {{$c->centro_indirizzo}} </td>
                                                <td> 
                                                @foreach($current_user->contattoCentro($c->id_centro) as $cont)
                                                <i class="material-icons" style="font-size:16px">&#xe0cd;</i><a href="">{{$cont}}</a><br> 
                                                @endforeach
                                                </td>
                                                <td><button class="btn btn-warning"  type="button" id="btnSpec" value="{{($c->centro_mail)}}"  >
                                                    <i class="icon-envelope"></i></button> <!-- data-target="#formModal" -->
                                                    <a class="mail" data-id="{{($c->centro_mail)}}" data-toggle="modal" >{{$c->centro_mail}}</a> 
                                                    </td>
                                                <td> <button class="btn-messaggio btn"  type="button" id="" ><i class="material-icons" style="font-size:16px">&#xe0cb;</i></button>
                                                <a  class="a-messaggio" data-id="{{$current_user->cppPersCont($c->id_centro)}}" data-toggle="modal" href="">{{$current_user->cppPersCont($c->id_centro)}} </a>
                                                 </td>
                                                </tr>
                                                @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>    <!--paneldanger-->
                            </div>    <!--col lg12-->
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-info">
                                    <div class="panel-heading">Laboratori Analisi</div>
                                    <div class=" panel-body">
                                        <div class="table-responsive" >
                                            <table class="table" id="tableLaboratoriAnalisi">
                                                <thead>
                                                <tr>
                                                    <th>Studio</th><th>Sede</th><th>Contatti</th><th>Mail</th><th style="text-align:center">Messaggio FSEM</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($current_user->centriIndagini() as $c)
                                                @if($c->id_tipologia === 3)
                                                <tr>
                                                <td> {{$c->centro_nome}} </td>
                                                <td> {{$c->centro_indirizzo}} </td>
                                                <td> 
                                                @foreach($current_user->contattoCentro($c->id_centro) as $cont)
                                                <i class="material-icons" style="font-size:16px">&#xe0cd;</i><a href="">{{$cont}}</a><br>
                                                @endforeach 
                                                </td>
                                                <td><button class="btn btn-warning"  type="button" id="btnSpec" value="{{($c->centro_mail)}}"  >
                                                    <i class="icon-envelope"></i></button> <!-- data-target="#formModal" -->
                                                    <a class="mail" data-id="{{($c->centro_mail)}}" data-toggle="modal" >{{$c->centro_mail}}</a> 
                                                    </td>
                                                <td> <button class="btn-messaggio btn"  type="button" id="" ><i class="material-icons" style="font-size:16px">&#xe0cb;</i></button>
                                                <a  class="a-messaggio" data-id="{{$current_user->cppPersCont($c->id_centro)}}" data-toggle="modal" href="">{{$current_user->cppPersCont($c->id_centro)}} </a>
                                                 </td>
                                                </tr>
                                                @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>    <!--paneldanger-->
                            </div>    <!--col lg12-->
                        </div>
                    </div><!--row-->
                </div>
                <!-- FINE COLLAPSE CENTRI INDAGINI DIAGNOSTICHE -->
            </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        <!-- FINE ACCORDION -->
<!--END PAGE CONTENT -->
@endsection