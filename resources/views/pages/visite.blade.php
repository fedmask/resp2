@extends('layouts.app') @extends('includes.template_head')

@section('pageTitle', 'Visite') @section('content')
<!--PAGE CONTENT -->


<div id="content">
	<div class="inner" style="min-height: 1200px;">
		<div class="row">
			<div class="col-lg-12">
				<h2>Visite</h2>
				<br>
			</div>
		</div>

		<hr />
		<div class="row">
			<div class="col-lg-12">
				<div class="btn-group">
					<!--bottoni per la gestione della visita-->
					<button class="btn btn-primary" id="btn_nuovavisita" onclick="onClickNuovaVisita()">
						<i class="icon-stethoscope"></i> Inizia Nuova Visita
					</button>
					<button class="btn btn-primary" id="btn_concludivisita" disabled onclick="onClickConcludiVisita()">
						<i class="icon-ok-sign"></i> Concludi visita
					</button>
					<!--<button class="btn btn-primary" id="btn_salvavisita" disabled><i class="icon-save"></i> Salva visita</button>-->
					<button class="btn btn-primary" id="btn_annullavisita" disabled onclick="onClickAnnullaVisita()">
						<i class="icon-trash"></i> Annulla visita
					</button>
				</div>
			</div>
		</div>
		
		<!-- FUNZIONI PER GESTIRE I BUTTON "INIZIA NUOVA VISITA", "CONCLUDI VISITA" E "ANNULLA VISITA" -->
					<script>
                        function onClickNuovaVisita() {
                            	document.getElementById("btn_nuovavisita").innerHTML = "Visita in corso...";
                            	document.getElementById("avviso_no_visite").hidden = true;
                            	document.getElementById("display_visita").hidden = false;
                            	document.getElementById("form_visita").hidden = false;
                            	document.getElementById("tabs_nuovavisita").hidden = false;
                            	document.getElementById("btn_nuovavisita").disabled = true;
                  
                            	document.getElementById("btn_concludivisita").disabled = false;
                            	document.getElementById("btn_concludivisita").style.backgroundColor = "green";
                            	
                            	document.getElementById("btn_annullavisita").disabled = false;
                            	document.getElementById("btn_annullavisita").style.backgroundColor = "red"; 
                         }

                        function onClickAnnullaVisita() {
                        	document.getElementById("btn_nuovavisita").innerHTML = "Inizia Nuova Visita";
                        	document.getElementById("avviso_no_visite").hidden = false;
                        	document.getElementById("btn_nuovavisita").disabled = false;                        	
                        	                        	
                        	document.getElementById("btn_concludivisita").disabled = true;
                        	document.getElementById("btn_concludivisita").style.backgroundColor = "";
                        	
                        	document.getElementById("btn_annullavisita").disabled = true;
                        	document.getElementById("btn_annullavisita").style.backgroundColor = ""; 

                        	document.getElementById("form_visita").hidden = true;
                        	document.getElementById("tabs_nuovavisita").hidden = true;

                     }
                        function onClickConcludiVisita(){
                        	//window.open("http://www.html.it", "myWindow");
                        	
                        	alert("VISITA CONCLUSA CON SUCCESSO");
                        	document.getElementById("btn_concludivisita").action('VisiteController@addVisita');
                        	
                        	document.getElementById("btn_nuovavisita").innerHTML = "Inizia Nuova Visita";
                        	document.getElementById("avviso_no_visite").hidden = false;
                        	document.getElementById("btn_nuovavisita").disabled = false;
              
                        	document.getElementById("btn_concludivisita").disabled = true;
                        	document.getElementById("btn_concludivisita").style.backgroundColor = "";
                        	
                        	document.getElementById("btn_annullavisita").disabled = true;
                        	document.getElementById("btn_annullavisita").style.backgroundColor = ""; 

                        	document.getElementById("form_visita").hidden = true;
                        	document.getElementById("tabs_nuovavisita").hidden = true;
                        }                
                        </script>
		
		<br />
		<div class="row">
			<div class="col-lg-12">
				<div class="btn-group">
					<!--bottoni per la gestione della visita-->
					<button class="btn btn-warning" id="btn_avviaAlgo"
					data-toggle="modal" data-target="#modCodeAlgo">
						<i class="icon-list"></i> Avvia algoritmo diagnostico
					</button>
					<button class="btn btn-warning" id="btn_annullaAlgo" disabled>
						<i class="icon-trash"></i> Annulla algoritmo
					</button>
				</div>
			</div>
		</div>
		<hr />
		<div class="row" id="avviso_no_visite">
			<div class="col-lg-12">
				<h3>Non ci sono visite in corso.</h3>
			</div>
		</div>
		<div class="row" id="display_visita" hidden>
			<div class="col-lg-12">
				<ul class="nav nav-tabs" id="tabs_nuovavisita">
					<li class="active"><a href="#tab_info" data-toggle="tab">Info
							generali</a></li>
					<li><a href="#tab_rilevazioni" data-toggle="tab">Rilevazioni</a></li>
				</ul>

				<!-- INIZIO CONTENUTO TAB -->

				<form class="form-horizontal" id="form_visita"
					action="formscripts/modvisita.php" method="POST">
					<div class="tab-content">
						<!--TAB INFO GENERALI-->
						<div class="tab-pane fade in active" id="tab_info">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="control-label col-lg-4" for="datavisita">Data:</label>
										<div class="col-lg-4">
											<input type="date" id="datavisita" name="datavisita"
												class="form-control" value="  ">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4" for="motivovisita">Motivo
											visita:</label>
										<div class="col-lg-8">
											<input type="text" name="motivovisita" id="motivovisita"
												class="form-control col-lg-6" />
										</div>
									</div>
									<div class="form-group">
										<label for="visita_osservazioni"
											class="control-label col-lg-4">Osservazioni:</label>
										<div class="col-lg-8">
											<textarea id="visita_osservazioni" name="visita_osservazioni"
												class="form-control"></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="visita_osservazioni"
											class="control-label col-lg-4">Conclusioni:</label>
										<div class="col-lg-8">
											<textarea id="visita_conclusioni" name="visita_conclusioni"
												class="form-control"></textarea>
										</div>
									</div>
									<!--
									<div class="form-group">
										<label for="visita_fileupl" class="control-label col-lg-4">Allegati:</label>
										<div class="col-lg-8">
											<input id="visita_fileupl" name="visita_fileupl[]" class="file" type="file" multiple=true data-preview-file-type="any"/>
										</div>
									</div>
									-->

								</div>
							</div>
						</div>

						<!--TAB MISURAZIONI-->
						<div class="tab-pane fade" id="tab_rilevazioni">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="control-label col-lg-4" for="visita_altezza">Altezza:</label>
										<div class="input-group col-lg-8">
											<span class="input-group-addon">cm</span> <input
												type="number" name="visita_altezza" id="visita_altezza"
												class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4" for="visita_peso">Peso:</label>
										<div class="input-group col-lg-8">
											<span class="input-group-addon">kg</span> <input
												type="number" name="visita_peso" id="visita_peso"
												class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4" for="visita_PAmax">Pressione
											sistolica:</label>
										<div class="input-group col-lg-8">
											<span class="input-group-addon">mmHg</span> <input
												type="number" name="visita_PAmax" id="visita_PAmax"
												class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4" for="visita_PAmin">Pressione
											diastolica:</label>
										<div class="input-group col-lg-8">
											<span class="input-group-addon">mmHg</span> <input
												type="number" name="visita_PAmin" id="visita_PAmin"
												class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4" for="visita_FC">Frequenza
											cardiaca:</label>
										<div class="input-group col-lg-8">
											<span class="input-group-addon">bpm</span> <input
												type="number" name="visita_FC" id="visita_FC"
												class="form-control" />
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--fineTAB MISURAZIONI-->
					</div>
				</form>
				<!-- FINE CONTENUTO TAB -->
			</div>
		</div>


		<div class="row" id="display_algoritmo" hidden>
			<div class="form-group">
				<label class="control-label col-lg-3" for="patologie">Numero di
					patologie:</label>
				<div class="col-lg-2">
					<select class="form-control" name="patologie" id="patologie"
						onchange="cambiaNumPatologie(this.selectedIndex);">
						<option>5</option>
						<option>10</option>
						<option>All</option>
					</select>
				</div>
				</label> <label class="control-label col-lg-12"></label>
			</div>

			<div class="col-lg-12">
				<ul class="nav nav-tabs" id="tabs_nuovavisita">
					<li class="active"><a href="#tab_algoritmo" data-toggle="tab">Algoritmo
							Diagnostico</a></li>
				</ul>

				<!-- INIZIO CONTENUTO TAB -->
				<form class="form-horizontal" id="form_visita">
					<div class="tab-content">
						<!--TAB INFO GENERALI-->
						<div class="tab-pane fade in active" id="tab_info">
							<div class="row">
								<div class="col-lg-12">
									<div class="table-responsive">
										<table class="table" id="tableConfermate">
											<thead>
												<tr>
													<th></th>
													<th></th>
													<th>Diagnosi</th>
													<th></th>
													<th></th>
													<th></th>
													<th>Anamnesi</th>
													<th></th>
													<th>Obiettivit&#224;</th>
													<th>Indagini</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
									<!--table responsive-->
								</div>
							</div>
						</div>
					</div>
				</form>
				<!-- FINE CONTENUTO TAB -->
			</div>
		</div>


		<div class="accordion ac" id="accordionVisite">
			<div class="accordion-group">
				<div class="row">
					<div class="accordion-heading centered">
						<div class="col-lg-12">
							<div class="col-lg-4">
								<a class="accordion-toggle" data-toggle="collapse"
									data-parent="#accordionVisite" href="#Info">
									<h3>
										Informazioni Visite <span> <i class="icon-angle-down"></i>
										</span>
									</h3>
								</a>
							</div>
							<div class="col-lg-4">
								<a class="accordion-toggle" data-toggle="collapse"
									data-parent="#accordionVisite" href="#Rilievi">
									<h3>
										Precedenti Rilievi <span> <i class="icon-angle-down"></i>
										</span>
									</h3>
								</a>
							</div>
						</div>
						<!--col-lg-12-->
					</div>
					<!--accordion heading centered-->
				</div>
				<!--row-->
			</div>
			<!--accordion group-->

			<!-- TAB INFORMAZIONI VISITE PRECEDENTI -->
			<div id="Info" class="accordion-body collapse">
				<div class="row">
					<!--info-->
					<div class="col-lg-12">
						<h2>Informazioni Visite Precedenti</h2>
						<hr>
@foreach($current_user->visiteUser() as $visita)

						<!-- INSERIRE FOR PER TABELLE GIALLEEE -->
						<div class="panel-body">
							<div class="panel panel-warning">
								<div class="panel-heading">Visita del
									<?php echo date('d/m/y', strtotime($visita->visita_data)); ?></div>
								<div class="table-responsive">
									<table class="table">
										<thead>
										</thead>
										<tbody>
											<form class="form-horizontal" id="modpatinfo" method="post">
												<div class="modal-body">
													<div class="form-group">
														<label class="control-label col-lg-4">Motivo:</label>
														<div class="col-lg-8">
															{{Form::label($visita->visita_motivazione)}}</div>
													</div>


													<div class="form-group">
														<label class="control-label col-lg-4">Osservazioni:</label>
														<div class="col-lg-8">
															{{Form::label($visita->visita_osservazioni)}}</div>
													</div>

													<div class="form-group">
														<label class="control-label col-lg-4">Conclusioni:</label>
														<div class="col-lg-8">
															{{Form::label($visita->visita_conclusioni)}}</div>
													</div>
											
											</form>

										</tbody>
									</table>
								</div>
							</div>
							<!-- panel body -->
						</div>
						<!-- col lg 12 -->
						<!-- FINE FORR -->
						@endforeach
					</div>

				</div>
			</div>
			<!--FINE TAB INFORMAZIONI VISITE PRECEDENTI -->

			<div id="Rilievi" class="accordion-body collapse">
				<div class="row">
					<!--rilievi-->
					<div class="col-lg-12">
						<h2>Rilievi Visite Precedenti</h2>
						<hr>
						<div class="panel panel-warning">
							<div class="panel-heading">Rilievi Visite Precedenti</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>Data</th>
												<th>Altezza</th>
												<th>Peso</th>
												<th>P.A. Max</th>
												<th>P.A. Min</th>
												<th>Freq. card.</th>
												<th>Rilevatore</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
								<!--table responsive-->
							</div>
						</div>
					</div>
				</div>
				<!--row-->
			</div>
			<!--accordion body collapse-->
		</div>
		<!--accordion visite-->

		<!--MODAL DIAGNOSI -->
		<div class="col-lg-12">
			<div class="modal fade" id="diagnosiModal" tabindex="-1"
				role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"
								aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="titolo_moddiagnosi"></h4>
						</div>
						<form class="form-horizontal" id="form_moddiagnosi">
							<div class="modal-body">
								<ul class="nav nav-tabs" id="tabs_diagnosi">
									<li class="active"><a href="#tab_moddiagnosi" data-toggle="tab">Dati
											diagnosi</a></li>
									<li><a href="#tab_terapiefarmacologiche" data-toggle="tab">Terapie
											farmacologiche</a></li>
								</ul>

								<div class="tab-content">
									<!--TAB MODDIAGNOSI-->
									<div class="tab-pane active" id="tab_moddiagnosi">
										<div class="form-group">
											<label class="control-label col-lg-4">Patologia</label>
											<div class="col-lg-8">
												<input class="form-control" type="text" id="diag_patologia">
												<span class="help-block" id="diag_patologia_helpblock"></span>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4" for="diag_status">Status:</label>
											<div class="col-lg-8">
												<select name="diag_status" id="diag_status"
													class="form-control">
													<option value="Sospetta">Sospetta</option>
													<option value="Confermata">Confermata</option>
													<option value="Esclusa">Esclusa</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4" for="diag_datainizio">Data
												inizio:</label>
											<div class="col-lg-8">
												<input type="date" id="diag_datainizio"
													name="diag_datainizio" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4" for="diag_datafine">Data
												fine:</label>
											<div class="col-lg-8">
												<input id="diag_datafine" name="diag_datafine"
													class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label for="diagnosi_osservazioni"
												class="control-label col-lg-4">Osservazioni:</label>
											<div class="col-lg-8">
												<textarea id="diagnosi_osservazioni"
													name="diagnosi_osservazioni" class="form-control"></textarea>
											</div>
										</div>
									</div>
									<!--FINE TAB MODDIAGNOSI-->

									<!--TAB TERAPIE FARMACOLOGICHE-->
									<div class="tab-pane fade" id="tab_terapiefarmacologiche">
										<div class="row">
											<div class="col-lg-12">
												<div class="box dark">
													<header>
														<h5>Seleziona terapia farmacologica</h5>
														<div class="toolbar">
															<ul class="nav">
																<li><a id="btn_nuovaterfarm"><i
																		class="icon-plus-sign icon-white"></i> Nuova</a></li>
															</ul>
														</div>
													</header>
													<div class="body">
														<div class="table-responsive">
															<table class="table table-hover tooltip_terfarm">
																<thead>
																	<tr>
																		<th>Farmaco</th>
																		<th>Status</th>
																		<th>Data inizio<br />
																		<small class="text-muted">(aaaa-mm-gg)</small></th>
																		<th>Data fine<br />
																		<small class="text-muted">(aaaa-mm-gg)</small></th>
																		<th>Forma Farm.</th>
																		<th>Sommin.</th>
																		<th>Freq.</th>
																	</tr>
																</thead>
																<tbody id="tabella_terfarm">

																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-12" id="box_dettagliterfarm"></div>
										</div>
									</div>
									<!--FINE TAB TERAPIE FARMACOLOGICHE-->
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default"
									data-dismiss="modal">Annulla</button>
								<button type="submit" class="btn btn-primary">Salva e Chiudi</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- FINE MODAL DIAGNOSI-->
	</div>

	<!--MODAL ALGORITMO DIAGNOSTICO-->
	<div class="col-md-4">
		<div class="modal fade" id="modCodeAlgo" tabindex="-1" role="dialog"
			aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"
							aria-hidden="true" id="chiudimodpatinfo">&times;</button>
						<h4 class="modal-title" id="H2">Algoritmo Diagnostico</h4>
					</div>
					<form method="post">
						<div class="modal-body">
							<label style="font: bold;" id="lblDescrizione"></label>
							<div id="lblJsonCodeAlgo">
								<!--In questo DIV vengono aggiunte dalla funziona apriICD9 le checkbox con i relativi nomi-->
							</div>
							<!--modal-body-->
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default"
								data-dismiss="modal">Annulla</button>
							<button type="button" class="btn btn-success"
								data-dismiss="modal" onclick="salvaCheckAlgoDiag()">Salva</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>


<!--END PAGE CONTENT -->
@endsection
