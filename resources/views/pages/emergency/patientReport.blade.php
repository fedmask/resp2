@extends( 'layouts.app' )
@extends( 'includes.template_head' )

@section( 'pageTitle', 'Patient Summary' )
@section( 'content' )

<!--PAGE CONTENT -->
<!-- Jasny input mask -->
<script src="assets/plugins/jasny/js/jasny-bootstrap.js"></script>
<div class="container-fluid">
	<div class="inner">
		<div class="row">
			<div class="col-lg-8">
				<h2> Report emergenza </h2>
			</div>
			<div class="col-lg-2" style="text-align:right">
				<a class="quick-btn" href="#"><i class="icon-print icon-2x"></i><span>Stampa</span></a>
			</div>
		</div>
		<hr/>

		<div class="row">
			<!-- ANAGRAFICA -->
			<div class="col-lg-3">
				<div class="panel panel-info">
					<div class="panel-body">
						<div class="media user-media well-small">
							<a class="user-link" href="#">
								<!-- TODO: Aggiungere controllo se l'immagine del profilo è stata impostata -->
								<img class="media-object img-thumbnail user-img" alt="Immagine Utente" src="/img/user.gif"/>
							</a>
							<br/>
							<div class="media-body">
								<h5 class="media-heading">
									{{$patient_info[0]->getSurname()}} {{$patient_info[0]->getName()}}
								</h5>

								<h5 class="media-heading">
										<?php echo date('d/m/y', strtotime($patient_info[0]->user()->first()->getBirthdayDate())); ?>
								</h5>
							</div>
							<br/>
						</div>

					</div>
				</div>
			</div>

			<!--GRUPPO SANGUIGNO-->
			<div class="col-lg-2">
				<div class="panel panel-danger">
					<div class="panel-body">
						<ul class="list-unstyled">
							<li><strong>Gruppo sanguigno</strong>:
								<span id="grupposanguigno">
									{{$patient_info[0]->user()->first()->getFullBloodType()}}
								</span>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<!--TERAPIA FARMACOLOGIA-->
			<div class="col-lg-4">
				<div class="panel panel-danger">
					<div class="panel-heading">Terapie farmacologiche</div>
					<div class="panel-body">
						<div class="table-responsive">
							<small>
								<table class="table">
									<thead>
									<tr>
										<th>Farmaco</th>
										<th>Data Principio</th>
										<th>Data Fine</th>
									</tr>
									</thead>
									<tbody>
									<!-- TODO: implementare query nel controller -->
									</tbody>
								</table>
							</small>
						</div>
					</div>
				</div>
			</div>

			<!--FARMACI DA NON SOMMINISTRATE-->
			<div class="col-lg-3">
				<div class="panel panel-danger">
					<div class="panel-heading">
						Farmaci da non somministrare
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<small>
								<table class="table">
									<thead>
									<tr>
										<th>Farmaco</th>
										<th>Motivo</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<!-- TODO: implementare query nel controller -->
									</tr>
									</tbody>
								</table>
							</small>
						</div>
					</div>
				</div>
			</div>

		</div>

		<div class="row">
			<!--UTLIME DIAGNOSI CONFERMATE-->
			<div class="col-lg-6">
				<div class="panel panel-info">
					<div class="panel-heading">Ultime diagnosi confermate</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table" id="tableConfermate">
								<thead>
								<tr>
									<th>Diagnosi</th>
									<th>Ultimo aggiornamento</th>
									<th>Confidenzialità</th>
									<th>Care provider</th>

								</tr>
								</thead>
								<tbody>
								@foreach($patient_info[0]->user()->first()->diagnosi() as $ind)
									@if($ind->diagnosi_stato === 2)
										<tr>
											<td>{{$ind->diagnosi_patologia}}</td>
											<td><?php echo date('d/m/y', strtotime($ind->diagnosi_aggiornamento_data)); ?></td>
											<td>{{$ind->diagnosi_confidenzialita}}</td>
                                            <?php $cpp =  $patient_info[0]->getCppDiagnosi($ind->id_diagnosi)->careprovider?>
                                            <?php $cpp = explode("-",$cpp)?>
                                            <?php $cpp = str_replace('/', '', $cpp)?>
											<td>
												@foreach($cpp as $c)
													{{$c}}<br>
												@endforeach
											</td>
											<td>
												<table>
													<tr>
														<td><button id="infoConf" class="indagini btn btn-primary"><i class="icon-search icon-white"></i></button></td>
														<td><button id="{{($ind->id_diagnosi)}}" class="modifica btn btn-success "><i class="icon-pencil icon-white"></i></button></td>
														<td><button id="{{($ind->id_diagnosi)}}" class="elimina btn btn-danger"><i class="icon-remove icon-white"></i></button>
														</td>
													</tr>
												</table>
											</td>

										<tr id="rigaModC">
											<td colspan="7">
												<form id="form{{($ind->id_diagnosi)}}" style="display:none" class="form-horizontal" >
													<div class="tab-content">
														<div class="row">
															<div class="col-lg-12">
																<div class="form-group">
																	<label class="control-label col-lg-4">Care provider:</label>
																	<div class="col-lg-4">
																		@if(UtentiTipologie::where('id_tipologia', $patient_info[0]->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
																			<input id="nomeCpC" value="{{$patient_info[0]->getName()}} {{$patient_info[0]->getSurname()}}" readonly class="form-control"/>
																		@else
																			<input id="cpp{{($ind->id_diagnosi)}}" value="{{($patient_info[0]->lastCppDiagnosi($ind->id_diagnosi))}}"  class="form-control"/>
																		@endif
																	</div>
																</div>
															</div>

															<div class="col-lg-12" style="display:none;">
																<div class="form-group">
																	<label class="control-label col-lg-4">cpId:</label>
																	<div class="col-lg-4">
																		@if(UtentiTipologie::where('id_tipologia', $patient_info[0]->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
																			<input id="cpIdC" readonly value="$current_user->id_utente" class="form-control"/>
																		@else
																			<input id="cpIdC" readonly value="-1" class="form-control"/>
																		@endif

																	</div>
																</div>
															</div>
															<div class="col-lg-12" style="display:none;">
																<div class="form-group">
																	<label class="control-label col-lg-4">pzId:</label>
																	<div class="col-lg-4">

																		<input id="pzIdC" readonly value="{{$patient_info[0]->idPazienteUser()}}" class="form-control"/>
																	</div>
																</div>
															</div>

															<div class="col-lg-12">
																<div class="form-group">
																	<label class="control-label col-lg-4">Stato:</label>
																	<div class="col-lg-4">
																		<select id="stato{{($ind->id_diagnosi)}}" class="form-control">
																			<option value="1">Sospetta</option>
																			<option selected value="2">Confermata</option>
																			<option value="3">Esclusa</option>
																		</select>
																	</div>
																</div>
															</div>
															<div class="col-lg-12">
																<div class="form-group">
																	<label class="control-label col-lg-4">Confidenzialit�:</label>
																	<div class="col-lg-4">
																		<select id="conf{{($ind->id_diagnosi)}}" class="form-control">
																			<option value = "1">Nessuna Restrizione</option>
																			<option value = "2">Basso</option>
																			<option value = "3">Moderato</option>
																			<option value = "4">Normale</option>
																			<option value = "5">Riservato</option>
																			<option value = "6">Strettamente Riservato</option>
																		</select>
																	</div>
																</div>
															</div>
															<div style="text-align:center;">
																<button class="btn btn-danger" onclick="annullaC()"><i class="icon icon-undo"></i> Annulla modifiche</button>
																<a href="" onclick="return false;" class=conferma data-id="{{($ind->id_diagnosi)}}"><button class="btn btn-success"><i class="icon icon-check"></i> Conferma modifiche</button></a>
															</div>
														</div>
													</div>
												</form>
											</td>
										</tr>
									@endif
								@endforeach
								</tbody>
							</table>
						</div><!--table responsive-->
					</div>
				</div>
			</div>

			<!--INDAGINI COMPLETATE-->
			<div class="col-lg-6">
				<div class="panel panel-info">
					<div class="panel-heading">Indagini completate</div>
					<div class=" panel-body">
						<div class="table-responsive" >
							<table class="table" id="tableCompletate">
								<thead>
								<tr>
									<th>Indagine</th><th>Motivo</th><th>Care provider</th><th>Data</th>
									<th style="text-align:center">Referto</th><th style="text-align:center">Allegati</th>
								</tr>
								</thead>
								<tbody>
								@foreach($patient_info[0]->user()->first()->indagini() as $ind)
									@if($ind->indagine_stato === '2')

										<tr>
											<td>{{$ind->indagine_tipologia}} </td>
											<td>{{$ind->indagine_motivo}} </td>
											<td>{{$ind->careprovider}} </td>
											<td><?php echo date('d/m/y', strtotime($ind->indagine_data)); ?> </td>
											<td>
                                                <button class="btn btn-info"  type="button" id="">
													<i class="icon-file-text"></i>
                                                </button>
                                            </td>
											<td>
                                                <button class="btn"  type="button" id="">
													<i class="icon-file-text"></i
                                                </button>
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
																			<input id="idPaziente{{($ind->id_indagine)}}" readonly value="{{$patient_info[0]->user()->first()->idPazienteUser()}}" class="form-control"/>
																		</div>
																	</div>
																</div>
																<div class="col-lg-12" style="display:none;">
																	<div class="form-group">
																		<label class="control-label col-lg-4">ID CP:</label>
																		<div class="col-lg-4">
																			@if(UtentiTipologie::where('id_tipologia', $patient_info[0]->user()->first()->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
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
																				@foreach($patient_info[0]->user()->first()->diagnosi() as $d)
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
                                                                            <?php $i = explode("-", $patient_info[0]->user()->first()->cppInd($ind->id_diagnosi))?>
																			<option hidden style='display: none' id="{{($i[1])}}" selected value="{{($i[0])}}">{{$i[0]}}</option>
																			<optgroup label="Care Providers">
																				@foreach($patient_info[0]->user()->first()->cppToUserInd() as $inda)
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
																			<option hidden style='display: none' id="{{($ind->id_centro_indagine)}}" selected value="{{($patient_info[0]->user()->first()->nomeCentroInd($ind->id_centro_indagine))}}">{{$current_user->nomeCentroInd($ind->id_centro_indagine)}}</option>
																			<optgroup label="Centri Diagnostici">
																				@foreach($patient_info[0]->user()->first()->centriIndagini() as $centri)
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
																		<strong>Attenzione:</strong> Per selezionare un file come referto o allegato � necessario caricarlo
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
				</div>
			</div>
		</div>

		<hr>

		<div class="row">
			<div class="col-lg-6">

			</div>
			<div class="col-lg-6">

			</div>
		</div>
	</div>
</div> <!--content-->
<!--END PAGE CONTENT -->
@endsection