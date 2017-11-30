@extends( 'layouts.app' )
@extends( 'includes.template_head' )

@section( 'pageTitle', 'Patient Summary' )
@section( 'content' )

<!--PAGE CONTENT -->
<!-- Jasny input mask -->
<script src="assets/plugins/jasny/js/jasny-bootstrap.js"></script>
<div id="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-8">
				<h2> Patient Summary </h2>
			</div>
			<!-- TODO: A questa pagina devono avere accesso, oltre al paziente stesso, (in modalità di lettura) tutte le persone a cui viene garantito il permesso, come careporivder, operatori d'emergenza, ecc.. -->
			<div class="col-lg-2" style="text-align:right">
				<a class="quick-btn" href="#"><i class="icon-print icon-2x"></i><span>Stampa</span></a>
			</div>
		</div>
		<!--row--->
		<hr/>
		<div class="row">
			<!-- ANAGRAFICA ESTESA -->
			<div class="col-lg-6">
				<div class="panel panel-info">
					<div class="panel-body">
						<ul class="list-unstyled">
							<li><strong>Cognome</strong>:
								<span>
									{{App\User::find(Auth::id())->getSurname()}}
								</span>
							</li>
							<li><strong>Nome</strong>:
								<span>
									{{App\User::find(Auth::id())->getName()}}
								</span>
							</li>
							<li><strong>Codice Fiscale</strong>:
								<span>
									{{App\User::find(Auth::id())->getFiscalCode()}}
								</span>
							</li>
							<li><strong>Data di nascita</strong>:
								<span>
									<?php echo date('d/m/y', strtotime(App\User::find(Auth::id())->getBirthdayDate())); ?>
								</span>
							</li>
							<li><strong>Età</strong>:
								<span>
									{{App\User::find(Auth::id())->getAge(App\User::find(Auth::id())->getBirthdayDate())}}
								</span>
							</li>
							<li><strong>Sesso</strong>:
								<span>
									{{App\User::find(Auth::id())->getGender()}}
								</span>
							</li>
							<li><strong>Città di nascita</strong>:
								<span>
									TODO: Placeholder
								</span>
							</li>
							<li><strong>Residenza</strong>:
								<span>
									TODO: Placeholder
								</span>
								&nbsp;-&nbsp;
								<span>
									TODO: Placeholder
								</span>
							</li>
							</li>
							<li><strong>Telefono</strong>: {{App\User::find(Auth::id())->getTelephone()}}
							</li>
							<!--<li><a  href="#" data-toggle="modal" data-target="#formModal">-->
							<li>
								<a href="#" data-toggle="modal" data-target="">
											<i class="icon-envelope-alt"></i> {{App\User::find(Auth::id())->getEmail()}}
										</a>
							</li>
							<!--Aggiunta dello stato matrimoniale-->
							<li><strong>Stato Civile</strong>: {{App\User::find(Auth::id())->getMaritalStatus()}}
							</li>
						</ul>
					</div>
					<!--bottone che apre il pannello per le modifiche informazioni anagrafiche del paziente-->
					@if(App\User::find(Auth::id())->getRole() === 'Paziente')
					<div class="panel-footer" style="text-align:right">
						<button class="btn btn-primary btn-sm btn-line" data-toggle="modal" data-target="#modpatinfomodal"><i class="icon-pencil icon-white"></i> Modifica Dati</button>
						<button class="btn btn-primary btn-sm btn-line" data-toggle="modal" data-target="#modpatpswmodal"><i class="icon-pencil icon-white"></i> Modifica Password</button>
					</div>
					@endif
				</div>

				<!--GRUPPO SANGUIGNO-->
				<div class="col-lg-6">
					<div class="panel panel-danger">
						<div class="panel-body">
							<ul class="list-unstyled">
								<li><strong>Gruppo sanguigno</strong>:
									<span id="grupposanguigno">
										{{App\User::find(Auth::id())->getFullBloodType()}}
									</span>
								</li>
							</ul>
						</div>
						@if(App\User::find(Auth::id())->getRole() === 'Care Provider')
						<div class="panel-footer" style="text-align:right">
							<button class="btn btn-primary btn-sm btn-line" data-toggle="modal" data-target="#modpatgrsangmodal"><i class="icon-pencil icon-white"></i> Modifica</button>
						</div>
						@endif
					</div>
				</div>
				<!--MODALE MODIFICA GRUPPO SANGUIGNO-->
				<div class="col-lg-12">
					<div class="modal fade" id="modpatgrsangmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="chiudimodpatgrsang">&times;</button>
									<h4 class="modal-title" id="H2">Modifica gruppo sanguigno</h4>
								</div>
								<form class="form-horizontal" id="modpatgrsang">
									<div class="modal-body">
										<div class="form-group">
											<label for="patgrsang" class="control-label col-lg-4">Gruppo Sanguigno:</label>
											<div class="col-lg-8">
												<select type="text" name="patgrsang" id="patgrsang" class="form-control col-lg-6">
													<option value="">Scegli gruppo</option>
													<option value="0+">0+ (gruppo zero Rh positivo)</option>
													<option value="0-">0- (gruppo zero Rh negativo)</option>
													<option value="A+">A+ (gruppo A Rh positivo)</option>
													<option value="A-">A- (gruppo A Rh negativo)</option>
													<option value="B+">B+ (gruppo B Rh positivo)</option>
													<option value="B-">B- (gruppo B Rh negativo)</option>
													<option value="AB+">AB+ (gruppo AB Rh positivo)</option>
													<option value="AB-">AB- (gruppo AB Rh negativo)</option>
												</select>
												<p class="help-block">&nbsp;</p>
												<p class="help-block">&nbsp;</p>
												<p class="help-block">Attenzione! l'inserimento o la modifica del gruppo sanguigno è permesso soltanto ai medici .</p>
												<p class="help-block">Il sistema registra l'autore della modifica.</p>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
										<button type="submit" class="btn btn-primary">Salva</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>


				<!-- MODAL MODIFICA PASSWORD-->
				<div class="col-lg-12">
					<div class="modal fade" id="modpatpswmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="chiudimodpatpsw">&times;</button>
									<h4 class="modal-title" id="H2">Modifica password</h4>
								</div>
								<form class="form-horizontal" action="/user/updatepassword" method="post">
								{{ csrf_field() }}
									<div class="modal-body">
										<div class="form-group">
											<label for="modcurrentpsw" class="control-label col-lg-4">Password attuale:</label>
											<div class="col-lg-8">
												<input type="password" name="current_password" id="current_password" class="form-control col-lg-6" value=""/>
											</div>
										</div>
										<div class="form-group">
											<label for="modnewpsw" class="control-label col-lg-4">Nuova password:</label>
											<div class="col-lg-8">
												<input type="password" name="password" id="password" class="form-control col-lg-6" value=""/>
											</div>
										</div>
										<div class="form-group">
											<label for="modconfirmpsw" class="control-label col-lg-4">Conferma password:</label>
											<div class="col-lg-8">
												<input type="password" name="password_confirmation" id="password_confirmation" class="form-control col-lg-6" value=""/>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
										<button type="submit" class="btn btn-primary">Salva</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!--FINE MODIFICA PASSWORD-->



				<!--DONAZIONE ORGANI-->
				<div class="col-lg-6">
					<div class="panel panel-warning">
						<div class="panel-body">
							<ul class="list-unstyled">
								<li> <strong>Donazione d'organi</strong>:
									<span>
									{{App\User::find(Auth::id())->getOrgansDonor() === false ? 'Nega il consenso' : 'Acconsente alla donazione'}}
									</span>
								</li>
							</ul>
						</div>
						@if(App\User::find(Auth::id())->getRole() === 'Paziente')
						<div class="panel-footer" style="text-align:right">
							<button class="btn btn-primary btn-sm btn-line" data-toggle="modal" data-target="#modpatdonorgmodal"><i class="icon-pencil icon-white"></i> Modifica</button>
						</div>
						@endif
					</div>
				</div>


				<!--MODALE MODIFICA CONSENSO DONAZIONE ORGANI-->
				<div class="col-lg-12">
					<div class="modal fade" id="modpatdonorgmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="chiudimodpatdonorg">&times;</button>
									<h4 class="modal-title" id="H2">Modifica consenso donazione organi</h4>
								</div>
								<form class="form-horizontal" id="modpatdonorg">
									<div class="modal-body">
										<iframe src="/informative/donazioneorgani.html" class="col-lg-12" height="500">
												</iframe>
										<div class="form-group">
											<label class="control-label col-lg-4">Dichiarazione di consenso alla donazione d'organi</label>
											<div class="col-lg-8">
												<label>
															<input type="radio" name="patdonorg" id="negpatdonorg" value="false"
																{{App\User::find(Auth::id())->getOrgansDonor() === false ? 'checked="checked"' : '' }}/> Nego il consenso
														</label>
												<label>
															<input type="radio" name="patdonorg" id="accpatdonorg" value="true" 
																{{App\User::find(Auth::id())->getOrgansDonor() === true ? 'checked="checked"' : '' }}/> Acconsento alla donazione d'organi
														</label>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
										<a id="saveModPatDonOrg" class="btn btn-primary">Salva</a>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--col-lg-6-->


			<!-- CONTATTI DI EMERGENZA-->
			<div class="row">
				<div class="col-lg-6">
					<div class="panel panel-danger">
						<div class="panel-heading">
							<center>
								<h2>Contatti di emergenza</h2> </center>
						</div>
						<input type="hidden" name="delcontemerg_hidden" id="delcontemerg_hidden" class="form-control col-lg-6" value="0"/>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>Nome</th>
											<th>Telefono</th>
											@if(App\User::find(Auth::id())->getRole() === 'Paziente')
											<th>
												<button data-toggle="modal" data-target="#addpatcontemergmodal" id="addContact" type="button" class=" btn btn-default btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" align="right"><i class="icon-plus"></i></button>
											</th>
											@endif
										</tr>
									</thead>
									<tbody>
										<tr>
											<!-- TODO: Ricreare sezione conttatti emergenza -->
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!--<div class="panel-footer" style="text-align:right">
                            	<button class="btn btn-primary btn-sm btn-line" data-toggle="modal" data-target="#modpatcontemergmodal"><i class="icon-pencil icon-white"></i> Modifica</button>
                        	</div>-->
					</div>
				</div>




				<!--PANEL ALTRI CONTATTI-->
				<div class="col-lg-6">
					<div class="panel panel-info">
						<div class="panel-heading">
							<center>
								<h3>Altri Contatti </h3>
							</center>

						</div>
						<input type="hidden" name="delcontemerg_hidden" id="delcontemerg_hidden" class="form-control col-lg-6" value="0"/>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>Nome</th>
											<th>Telefono</th>
											<!--Aggiunto campo tipologia per la tipologia di relazione-->
											<th>Relazione</th>
											@if(App\User::find(Auth::id())->getRole() === 'Paziente')
											<th>
												<button data-toggle="modal" data-target="#addpatcontmodal" id="addContact" type="button" class=" btn btn-default btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" align="right"><i class="icon-plus"></i></button>
											</th>
											@endif
										</tr>
									</thead>
									<tbody>
										<tr>
										<!-- TODO: Rifare sezione e vedere dal vecchio template  -->
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!--<div class="panel-footer" style="text-align:right">
                            	<button class="btn btn-primary btn-sm btn-line" data-toggle="modal" data-target="#modpatcontemergmodal"><i class="icon-pencil icon-white"></i> Modifica</button>
                        	</div>-->
					</div>
				</div>
			</div>
			<!--div row contatti-->
			<!-- MODAL MODIFICA ANAGRAFICA -->
			
			<!-- TODO: Riaggiungere modifica Anagrafica -->
			
			<!--col-lg-12--->
			<!--FINE Modal ANAGRAFICA ESTESA-->


			<!-- MODALE MODIFICA CONTATTI EMERGENZA -->
			
			<!-- TODO: Riaggiungere modifica Contatti Emergenza -->
			
			<!--FINE CONTATTI DI EMERGENZA-->




			<!-- MODALE ADD CONTATTI EMERGENZA -->
			
			<!-- TODO: Riaggiungere ADD CONTATTI EMERGENZA -->
			
			<!--FINE ADD CONTATTI DI EMERGENZA-->

			<!--MODALE CONTATTI-->
			
			<!-- TODO: Riaggiungere MODALE CONTATTI -->
			
			<!--FINE MODALE CONTATTI-->
		</div>
	</div>
</div> <!--content-->
<!--END PAGE CONTENT -->
@endsection