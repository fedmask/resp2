@extends('layouts.app')
@extends('includes.template_head')

@section('pageTitle', 'Vaccinazioni')
@section('content')
<!--PAGE CONTENT -->

<div id="content">
            <div class="inner" style="min-height:1200px;">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Elenco Vaccinazioni</h2>
						<hr>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="formscripts/jquery.js"></script>
<script src="formscripts/jquery-ui.js"></script>



<div class="row">
					<div class="col-lg-12" >
						<div class="btn-group">
<button class="btn btn-primary" id="nuovaV" ><i class="icon-stethoscope"></i> Nuova vaccinazione</button>
<button class="btn btn-primary" id="concludiV" onclick="nuovaVaccinazione()"><i class="icon-ok-sign"></i> Concludi vaccinazione</button>
<button class="btn btn-primary" id="annullaV"><i class="icon-trash"></i> Annulla vaccinazione</button>

</div></div></div><br>

<script>

$('#concludiV').prop('disabled',true);
$('#annullaV').prop('disabled',true);

//permette di mostrare il form per l'inserimento di una nuova vaccinazione
$("#nuovaV").click(function(){
	
    $("#formV").show(200);
	$('#nuovaV').prop('disabled',true);
	$('#concludiV').prop('disabled',false);
	$('#annullaV').prop('disabled',false);
});

//permette di annullare l'inserimento di una nuova 
$("#annullaV").click(function(){
    $("#formV").hide(200);
	$('#nuovaV').prop('disabled',false);
	$('#concludiV').prop('disabled',true);
	$('#annullaV').prop('disabled',true);
	$('#formV')[0].reset();
});

//permette di salvare una nuova vaccinazione
function nuovaVaccinazione(){

	var vacc = document.getElementById("vaccini").value;
	var data = document.getElementById("add_vaccino_data").value;
	var reazione = document.getElementById("add_vaccino_reazioni").value;
	var richiamo = document.getElementById("richiamo").value;
    var confidenz = document.getElementById("confD").value;
	var idPaz = document.getElementById("pzId").value;
	var cpp = document.getElementById("cpId").value;
	if(data == '' || reazione == ''){
		alert("Compilare tutti i campi");

	}else{
		window.location.href="http://localhost:8000/addVacc/"+vacc+"/"+data+"/"+reazione+"/"+richiamo+"/"+confidenz+"/"+idPaz+"/"+cpp;
		$('#formV')[0].reset();

	}
	

}

//permette di aprire il form per la modifica di una vaccinazione
$(document).on('click', "button.modifica", function () {
    $(this).prop('disabled', true);
    $('#'+$(this).attr('id')+'.elimina').prop('disabled', true);
    var idForm = '#form'+$(this).attr('id');
    var conf = '#conf'+$(this).attr('id');
    
    $(idForm).show(200);
});

//permette di chiudere e resettare il form per la modifica di una vaccinazione
$(document).on('click', "button.nascondi", function () {
	var idVacc = $(this).attr('nasc-id');
	$("#form"+idVacc).hide(200);
	$("button#"+idVacc+".modifica").prop('disabled', false);
    $("button#"+idVacc+".elimina").prop('disabled', false);
});

//gestisce la conferma dei dati per la modifica di una vaccinazione
$(document).on('click', "a.conferma", function () {
	var idVacc = $(this).attr('data-id');
	var vacc = $('#modvaccini'+idVacc).val();
	var data = $('#mod_add_vaccino_data'+idVacc).val();
	var reazione = $('#mod_add_vaccino_reazioni'+idVacc).val();
	var richiamo = $('#modrichiamo'+idVacc).val();
    var confidenz = $('#modconfD'+idVacc).val();
    window.location.href="http://localhost:8000/modVacc/"+vacc+"/"+data+"/"+reazione+"/"+richiamo+"/"+confidenz+"/"+idVacc;
	$('#formV')[0].reset(); 
});

//gestisce l'eliminazione di una vaccinazione
$(document).on('click', "button.elimina", function () {

        var idVacc = $(this).attr('id');

	    if(confirm("Confermi di voler eliminare la vaccinazione?")){
	        window.location.href="http://localhost:8000/delVacc/"+idVacc;
	    }else{
			windows.location.reload();
	    }
});

</script>

		<form id="formV" style="display:none" class="form-horizontal" >
			<div class="tab-content">
				<div class="row">
				
					<div class="col-lg-12">				
						<div class="form-group">
							<label class="control-label col-lg-4">Vaccinazione: </label>
								<div class="col-lg-4" >
									<?php $vaccini = App\Models\Vaccine\Vaccini::pluck('vaccino_nome')->toArray() ?>
									
										{{Form::select('vaccini', $vaccini, null, ['id'=>'vaccini','class'=>'form-control'])}}
									
								</div>
						</div>
					</div>
					
					<div class="col-lg-12">
						<div class="form-group">
							<label class="control-label col-lg-4" for="add_vaccino_data">Data: </label>
								<div class="col-lg-4">
									{{Form::date('date','', ['id'=>"add_vaccino_data", 'name'=>"add_vaccino_data", 'class' => 'form-control col-lg-6'])}}
								</div>
						</div>
					</div>
					
					<div class="col-lg-12">
						<div class="form-group">
							<label class="control-label col-lg-4" for="add_vaccino_reazioni">Reazioni: </label>
								<div class="col-lg-4">
									{{Form::text('reazioni','', ['id'=>"add_vaccino_reazioni", 'name'=>"add_vaccino_reazioni", 'class'=>'form-control col-lg-6'])}}
								</div>
						</div>
					</div>
					
					<div class="col-lg-12">
						<div class="form-group">	
							<label class="control-label col-lg-4">Richiamo: </label>
								<div class="col-lg-4">
									<select id="richiamo" class="form-control">
										<option selected = "selected" value = "1">1</option>
										<option value = "2">2</option>
										<option value = "3">3</option>
									</select>
								</div>
						</div>
					</div>		
					

						<div class="col-lg-12">
						<div class="form-group">	
							<label class="control-label col-lg-4">Confidenzialità: </label>
								<div class="col-lg-4">
									<select id="confD" class="form-control">
										<option value = "1">Nessuna Restrizione</option>
										<option value = "2">Basso</option>
										<option value = "3">Moderato</option>
										<option value = "4">Normale</option>
										<option selected = "selected" value = "5">Riservato</option>
										<option value = "6">Strettamente Riservato</option>
									</select>
								</div>
						</div>
					</div>				
				</div>
			</div>
			        
					<div class="col-lg-12" style="display:none;">
						<div class="form-group">
						<label class="control-label col-lg-4">cpId:</label>
						<div class="col-lg-4">
							@if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
							<input id="cpId" readonly value="$current_user->id_utente" class="form-control"/>
							@else
							<input id="cpId" readonly value="-1" class="form-control"/>
							@endif

						</div>
						</div>
						</div>
						<div class="col-lg-12" style="display:none;">
						<div class="form-group">
						<label class="control-label col-lg-4">pzId:</label>
						<div class="col-lg-4">
						
						<input id="pzId" readonly value="{{$current_user->idPazienteUser()}}" class="form-control"/>
						</div>
						</div>
						</div>                    
            
		</form>
 		<br>

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-warning">
					<div class="panel-heading">Vaccinazioni</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table" id="tableVaccinazione">
									<thead>
										<tr>
                                            <th>Vaccino</th>
                                            <th>Descrizione<br/></th>
                                            <th>Data</th> 
											<th>Data fine copertura</th>
											<th>Reazioni</th>
											<th>Richiamo</th>
											<th>Opzioni</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<!-- Per ogni vaccinazione dell'utente attuale -->
                                        @foreach($current_user->vaccinazioni() as $ind)
										
										<tr>
										<!-- Stampo il nome del vaccino -->
										<td>{{Vaccini::where('id_vaccino', $ind->id_vaccino)->first()->vaccino_nome}}</td>
										<!-- Stampo la descrizione del vaccino -->
										<td>{{Vaccini::where('id_vaccino', $ind->id_vaccino)->first()->vaccino_descrizione}}</td>
										<!-- Stampo la data di somministrazione vaccino -->
										<td><?php echo date('d/m/y', strtotime($ind->vaccinazione_data)); ?></td>
										<!-- Calcolo e stampo la data di fine copertura della vaccinazione -->
										<td><?php echo date('d/m/y', strtotime($ind->vaccinazione_data->addMonths(Vaccini::where('id_vaccino', $ind->id_vaccino)->first()->vaccino_durata))); ?></td>
										<!-- Stampo la reazione alla somministrazione del vaccino -->
										<td>
										<!-- Se l'utente è un care provider mostro il tasto info -->
										{{$ind->vaccinazione_reazioni}}
										@if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
											<br><button id="infoSosp" class="indagini btn btn-primary"><i class="icon-search icon-white"></i></button>
										@endif
										</td>
										<!-- Stampo il numero di richiami del vaccino -->
										<td>{{$ind->vaccinazione_richiamo}}</td>
										<td>
										<!-- Mostro il tasto modifica vaccinazione -->
										<button id="{{($ind->id_vaccinazione)}}" class="modifica btn btn-success "><i class="icon-pencil icon-white"></i></button>
										<!-- Mostro il tasto elimina vaccinazione -->
										<button id="{{($ind->id_vaccinazione)}}" class="elimina btn btn-danger"><i class="icon-remove icon-white"></i></button>
										</td>
										</tr>
										
										<!-- Inizio sezione di modifica vaccinazione-->										
											<tr id="rigaModS">
				<td colspan="7">
						<form id="form{{($ind->id_vaccinazione)}}" style="display:none" class="form-horizontal" >
							<div class="tab-content">
							<div class="row">
				
					<div class="col-lg-12">				
						<div class="form-group">
							<label class="control-label col-lg-4">Vaccinazione: </label>
								<div class="col-lg-4" >
									<?php $vaccini = Vaccini::pluck('vaccino_nome')->toArray() ?>
									
										{{Form::select('vaccini', $vaccini, $ind->id_vaccino-1, ['id'=>'modvaccini'.$ind->id_vaccinazione,'class'=>'form-control'])}}
									
								</div>
						</div>
					</div>
					
					<div class="col-lg-12">
						<div class="form-group">
							<label class="control-label col-lg-4" for="add_vaccino_data">Data: </label>
								<div class="col-lg-4">
									{{Form::date('date', $ind->vaccinazione_data, ['id'=>"mod_add_vaccino_data".$ind->id_vaccinazione, 'name'=>"mod_add_vaccino_data", 'class' => 'form-control col-lg-6'])}}
								</div>
						</div>
					</div>
					
					<div class="col-lg-12">
						<div class="form-group">
							<label class="control-label col-lg-4" for="add_vaccino_reazioni">Reazioni: </label>
								<div class="col-lg-4">
									{{Form::text('reazioni', $ind->vaccinazione_reazioni, ['id'=>"mod_add_vaccino_reazioni".$ind->id_vaccinazione, 'name'=>"mod_add_vaccino_reazioni", 'class'=>'form-control col-lg-6'])}}
								</div>
						</div>
					</div>
					
					<div class="col-lg-12">
						<div class="form-group">	
							<label class="control-label col-lg-4">Richiamo: </label>
								<div class="col-lg-4">
									<select id="modrichiamo{{($ind->id_vaccinazione)}}" class="form-control">
										<?php switch ($ind->vaccinazione_richiamo) {
												case 1:
													echo('<option selected = "selected" value = "1">1</option>
													<option value = "2">2</option>
													<option value = "3">3</option>');
													break;
												case 2:
													echo('<option value = "1">1</option>
													<option selected = "selected" value = "2">2</option>
													<option value = "3">3</option>');
													break;
												case 3:
													echo('<option value = "1">1</option>
													<option value = "2">2</option>
													<option selected = "selected" value = "3">3</option>');
													break;
											}	?>
										
									</select>
								</div>
						</div>
					</div>		
					

						<div class="col-lg-12">
						<div class="form-group">	
							<label class="control-label col-lg-4">Confidenzialità: </label>
								<div class="col-lg-4">
									<select id="modconfD{{($ind->id_vaccinazione)}}" class="form-control">
										<?php switch ($ind->vaccinazione_confidenzialita) {
												case 1:
													echo('<option selected = "selected" value = "1">Nessuna Restrizione</option>
													<option value = "2">Basso</option>
													<option value = "3">Moderato</option>
													<option value = "4">Normale</option>
													<option value = "5">Riservato</option>
													<option value = "6">Strettamente Riservato</option>');
													break;
												case 2:
													echo('<option value = "1">Nessuna Restrizione</option>
													<option selected = "selected" value = "2">Basso</option>
													<option value = "3">Moderato</option>
													<option value = "4">Normale</option>
													<option value = "5">Riservato</option>
													<option value = "6">Strettamente Riservato</option>');
													break;
												case 3:
													echo('<option value = "1">Nessuna Restrizione</option>
													<option value = "2">Basso</option>
													<option selected = "selected" value = "3">Moderato</option>
													<option value = "4">Normale</option>
													<option value = "5">Riservato</option>
													<option value = "6">Strettamente Riservato</option>');
													break;
												case 4:
													echo('<option value = "1">Nessuna Restrizione</option>
													<option value = "2">Basso</option>
													<option value = "3">Moderato</option>
													<option selected = "selected" value = "4">Normale</option>
													<option value = "5">Riservato</option>
													<option value = "6">Strettamente Riservato</option>');
													break;
												case 5:
													echo('<option value = "1">Nessuna Restrizione</option>
													<option value = "2">Basso</option>
													<option value = "3">Moderato</option>
													<option value = "4">Normale</option>
													<option selected = "selected" value = "5">Riservato</option>
													<option value = "6">Strettamente Riservato</option>');
													break;
												case 6:
													echo('<option value = "1">Nessuna Restrizione</option>
													<option value = "2">Basso</option>
													<option value = "3">Moderato</option>
													<option value = "4">Normale</option>
													<option value = "5">Riservato</option>
													<option selected = "selected" value = "6">Strettamente Riservato</option>');
													break;
											}	?>
									</select>
								</div>
						</div>
					</div>
				<div style="text-align:center;">
				<button class="nascondi btn btn-danger" type="reset" nasc-id="{{($ind->id_vaccinazione)}}"><i class="icon icon-undo"></i> Annulla modifiche</button>
				<a href="" onclick="return false;" class=conferma data-id="{{($ind->id_vaccinazione)}}"><button class="btn btn-success"><i class="icon icon-check"></i> Conferma modifiche</button></a>
				</div>
			</div>
						
						</form>
				</td>
</tr>  
										
											@endforeach
				
										   </tbody>
								</table>
							</div>
						</div>
					</div>	<!--panelwarning-->	
			</div>	<!--col lg12-->
		</div> 
			
						

                    </div>
                </div>
				<div class="row">
                    <div class="col-lg-12">
                        <h2>Pagine Utili</h2>
						<hr>
						<div class="row">
							<div class="col-lg-12">
								<h4>
									<a href="http://www.salute.gov.it/portale/temi/p2_6.jsp?lingua=italiano&id=648&area=Malattie%20infettive&menu=vaccinazioni">➔ Calendario Vaccinale</a>
									<br>
									<a href="http://www.salute.gov.it/portale/temi/p2_6.jsp?lingua=italiano&id=655&area=Malattie%20infettive&menu=viaggiatori">➔ Vaccinazioni per chi viaggia</a>
								</h4>
							</div>
						</div>
					</div>
				</div>
            </div>
			
			
        </div>


<!--END PAGE CONTENT -->

@endsection
