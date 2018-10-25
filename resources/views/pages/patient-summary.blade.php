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
		<!--row-->
		<hr/>
		<div class="row">
			<!-- ANAGRAFICA ESTESA -->
			<div class="col-lg-6">
				<div class="panel panel-info">
					<div class="panel-body">
						<ul class="list-unstyled">
							<li><strong>Cognome</strong>:
								<span>
									{{$current_user->getSurname()}}
								</span>
							</li>
							<li><strong>Nome</strong>:
								<span>
									{{$current_user->getName()}}
								</span>
							</li>
							<li><strong>Codice Fiscale</strong>:
								<span>
									{{$current_user->getFiscalCode()}}
								</span>
							</li>
							<li><strong>Data di nascita</strong>:
								<span>
									<?php echo date('d/m/y', strtotime($current_user->getBirthdayDate())); ?>
								</span>
							</li>
							<li><strong>Età</strong>:
								<span>
									{{$current_user->getAge($current_user->getBirthdayDate())}}
								</span>
							</li>
							<li><strong>Sesso</strong>:
								<span>
									{{$current_user->getGender()}}
								</span>
							</li>
							<li><strong>Città di nascita</strong>:
								<span>
								{{$current_user->getBirthTown()}}
								</span>
							</li>
							<li><strong>Residenza</strong>:
								<span>
									{{$current_user->getLivingTown()}}
								</span>
								&nbsp;-&nbsp;
								<span>
									{{$current_user->getAddress()}}
								</span>
							</li>
							</li>
							<li><strong>Telefono</strong>: {{$current_user->getTelephone()}}
							</li>
							<li>
								<a href="#" data-toggle="modal" data-target="">
											<i class="icon-envelope-alt"></i> {{$current_user->getEmail()}}
										</a>
							</li>
							<li><strong>Stato Civile</strong>: {{$current_user->getMaritalStatus()}}
							</li>
						</ul>
					</div>
					@if ($errors->any())
					<div class="alert alert-danger" role="alert">
						@if(Session::has('FailEditPassword'))
	                		{{ Session::get('FailEditPassword') }}
	                	@endif
						@foreach ($errors->all() as $error)
	    					<li>{{ $error}}</li> 
	            		@endforeach
	            	</div>
					@endif

					@if(Session::has('SuccessEditPassword'))
				         <div class="alert alert-success" role="alert">
				             {{ Session::get('SuccessEditPassword') }}
				         </div>
					@endif
					<!--bottone che apre il pannello per le modifiche informazioni anagrafiche del paziente-->
					@if($current_user->getDescription() == User::PATIENT_DESCRIPTION)
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
										{{$current_user->getFullBloodType()}}
									</span>
								</li>
							</ul>
						</div>
						@if($current_user->getDescription() === 'Care Provider')
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


</div>


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
								<form action="/pazienti/removeContact"" method="POST">
									{{ csrf_field() }}
									<table class="table">
										<thead>
											<tr>
												<th>Nome</th>
												<th>Telefono</th>
												@if($current_user->getDescription() == User::PATIENT_DESCRIPTION)
												<th>
													<button data-toggle="modal" data-target="#addpatcontemergmodal" id="addContact" type="button" class=" btn btn-default btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" align="right"><i class="icon-plus"></i></button>
												</th>
												@endif
											</tr>
										</thead>
										<tbody>
											<tr>
												@foreach ($contacts as $contact)
												@if($contact->id_contatto_tipologia == 10)
		                            			<tr>
			                            			<td>{{ $contact->contatto_nominativo }}</td>
			                            			<td>{{ $contact->contatto_telefono }}</td>
			                            			<td>
			                            				<input type="hidden" name="id_contact" id="id_contact" value="{{$contact->id_contatto}}">
														<button type="submit" class="removeContact buttonDelete btn btn-default btn-danger" ><i class="icon-remove"></i></button>
													</td>
		                            			<tr>
	                            				@endif
											@endforeach
											</tr>
										</tbody>
									</table>
								</form>
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
								<form action="/pazienti/removeContact"" method="POST">
									{{ csrf_field() }}
								<table class="table">
									<thead>
										<tr>
											<th>Nome</th>
											<th>Telefono</th>
											<!--Aggiunto campo tipologia per la tipologia di relazione-->
											<th>Relazione</th>
											@if($current_user->getDescription() == User::PATIENT_DESCRIPTION)
											<th>
												<button data-toggle="modal" data-target="#addpatcontmodal" id="addContact" type="button" class=" btn btn-default btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" align="right"><i class="icon-plus"></i></button>
											</th>
											@endif
										</tr>
									</thead>
									<tbody>
										@foreach ($contacts as $contact)
										@if($contact->id_contatto_tipologia != 10)
										<tr>
	                            			<td>{{ $contact->contatto_nominativo }}</td>
	                            			<td>{{ $contact->contatto_telefono }}</td>
	                            			<td>{{ $contact->contacts_type->tipologia_nome }}</td>
	                            			<td>
	                            				<input type="hidden" name="id_contact" id="id_contact" value="{{$contact->id_contatto}}">
												<button type="submit" class="removeContact buttonDelete btn btn-default btn-danger" ><i class="icon-remove"></i></button>
											</td>
                            			<tr>
										@endif
										@endforeach
									</tbody>
								</table>
								</form>
							</div>
						</div>
						<!--<div class="panel-footer" style="text-align:right">
                            	<button class="btn btn-primary btn-sm btn-line" data-toggle="modal" data-target="#modpatcontemergmodal"><i class="icon-pencil icon-white"></i> Modifica</button>
                        	</div>-->
					</div>
				</div>
			</div>
			<!--div row contatti-->
			<!-- Modale Contatti -->
			<div class="col-lg-12">
				<div class="modal fade" id="addpatcontmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="chiudiaddpatcontemerg">&times;</button>
									<h4 class="modal-title" id="H2">Contatti</h4>
								</div>
								<form class="form-horizontal" action="/pazienti/addContact" method="POST">
									{{ csrf_field() }}
								<div class="modal-body">
									<div class="form-group">
										<label for="modcontemerg_add" class="control-label col-lg-4">Nome contatto:</label>
										<div class="col-lg-8">
										<input type="text" name="modcontemerg_add2" id="modcontemerg_add2" class="form-control col-lg-6" value=""/>
										</div>
									</div>
									<div class="form-group">
										<label for="modtelcontemerg_add" class="control-label col-lg-4">Telefono:</label>
										<div class="col-lg-8">
										<input type="text" name="modtelcontemerg_add2" id="modtelcontemerg_add2" class="form-control col-lg-6" value=""/>
										</div>
									</div>
                                    <div class="form-group">
										<label for="modtipcontemerg_add" class="control-label col-lg-4">Tipologia Contatto:</label>
										<div class="col-lg-8">
                                        <select class="form-control col-lg-6" name="modtipcontemerg_add2" id="modtipcontemerg_add2">
                                            <option value="Familiare">Familiare</option>
                                            <option value="Tutore">Tutore</option>
                                            <option value="Amico">Amico</option>
                                            <option value="Compagno">Compagno</option>
                                            <option value="Lavorativo">Lavorativo</option>
                                            <option value="Badante">Badante</option>
                                            <option value="Delegato">Delegato</option>
                                            <option value="Garante">Garante</option>
                                            <option value="Padrone">Padrone (nel caso di animale domestico)</option>
                                            <option value="Genitore">Genitore</option>
                                        </select>
										</div>
									</div>
									<!--Non è specificata la id della table contatti che deve essere modificato-->
									<hr>
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
                <!--FINE MODALE CONTATTI-->




			<!-- MODAL MODIFICA ANAGRAFICA -->
			
			<div class="col-lg-12">
                        <div class="modal fade" id="modpatinfomodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="chiudimodpatinfo">&times;</button>
										<h4 class="modal-title" id="H2">Modifica informazioni utente</h4>
									</div>
									<form class="form-horizontal"  id="modpatinfo" action="{{action('PazienteController@updateAnagraphic')}}" method="post">
									{{ Form::open(array('url' => '/pazienti/updateAnagraphic')) }}
									{{ csrf_field() }}
									<div class="modal-body">
										<div class="form-group">
											<label for="modcognome" class="control-label col-lg-4">Cognome:</label>
											<div class="col-lg-8">
											{{Form::text('editSurname', $current_user->getSurname(), ['class' => 'form-control col-lg-6'])}}
											</div>
										</div>
										<div class="form-group">
											<label for="modnome" class="control-label col-lg-4">Nome:</label>
											<div class="col-lg-8">
											{{Form::text('editName', $current_user->getName(), ['class' => 'form-control col-lg-6'])}}
											</div>
										</div>
										<div class="form-group">
											<label for="modcf" class="control-label col-lg-4">Codice Fiscale:</label>
											<div class="col-lg-8">
											{{Form::text('editFiscalCode', $current_user->getFiscalCode(), ['class' => 'form-control col-lg-6'])}}
											</div>
										</div>
										<div class="form-group">
											<label for="moddatanascita" class="control-label col-lg-4">Data di nascita:</label>
											<div class="col-lg-8">
											{{Form::date('editBirthdayDate', $current_user->getBirthdayDate(), ['class' => 'form-control col-lg-6'])}}
											</div>
										</div>
										<div class="form-group">
											<label for="modsesso" class="control-label col-lg-4">Sesso:</label>
											<div class="col-lg-8">
											{{Form::select('editGender', ['M' => 'M', 'F' => 'F'], $current_user->getGender(), ['class' => 'form-control col-lg-6'] )}}
											</div>
										</div>
										<div class="form-group">
											<label for="modcittanascita" class="control-label col-lg-4">Città di nascita:</label>
											<div class="col-lg-8">
											{{Form::text('editBirthTown', $current_user->getBirthTown(), ['class' => 'form-control col-lg-6'])}}
											</div>
										</div>
										<div class="form-group">
											<label for="modcittaresidenza" class="control-label col-lg-4">Città residenza:</label>
											<div class="col-lg-8">
											{{Form::text('editLivingTown', $current_user->getLivingTown(), ['class' => 'form-control col-lg-6'])}}
											</div>
										</div>
										<div class="form-group">
											<label for="modviaresidenza" class="control-label col-lg-4">Via residenza:</label>
											<div class="col-lg-8">
											{{Form::text('editAddress', $current_user->getAddress(), ['class' => 'form-control col-lg-6'])}}
											</div>
										</div>
										<div class="form-group">
											<label for="modemail" class="control-label col-lg-4">Email:</label>
											<div class="col-lg-8">
											{{Form::text('editEmail', $current_user->utente_email, ['class' => 'form-control col-lg-6'])}}
											</div>
										</div>
										<div class="form-group">
											<label for="modtel" class="control-label col-lg-4">Telefono:</label>
											<div class="col-lg-8">
											{{Form::text('editTelephone', $current_user->getTelephone(), ['class' => 'form-control col-lg-6'])}}
											</div>
										</div>
										<!--Modifica dello stato matrimoniale-->
                                        <div class="form-group">
											<label for="modmaritalStatus" class="control-label col-lg-4">Stato Civile:</label>
											<div class="col-lg-8">
											{{Form::select('editMaritalStatus', ['0' => 'Sposato', '1' => 'Annullato', '2' => 'Divorziato', '3' => 'Interlocutorio', '4' => 'Legalmente Separato', '5' => 'Poligamo', '6' => 'Mai Sposato', '7' => 'Convivente', '8' => 'Vedovo',], $current_user->getMaritalStatus(), ['class' => 'form-control col-lg-6'])}}
											</div>
										</div>
									 
										
									 </div> <!--modal-body -->
									 <div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
											{{ Form::submit('Salva', ['class' => 'btn btn-primary'])}} 
									 </div>
									 {{ Form::close() }}
									 </form>
								</div>
							</div>
						</div>
					</div>
			
			<!--col-lg-12--->
			<!--FINE Modal ANAGRAFICA ESTESA-->

			<!-- MODALE ADD CONTATTI EMERGENZA -->                                                     
			<div class="col-lg-12">
				<div class="modal fade" id="addpatcontemergmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<form class="form-horizontal" action="/pazienti/addEmergencyContact" method="POST">
					{{ csrf_field() }}
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="chiudiaddpatcontemerg">&times;</button>
									<h4 class="modal-title" id="H2">Contatti di emergenza</h4>
								</div>
								<form class="form-horizontal"  id="addpatcontemerg">
								<div class="modal-body">
									<div class="form-group">
										<label for="modcontemerg_add" class="control-label col-lg-4">Nome contatto:</label>
										<div class="col-lg-8">
										<input type="text" name="modcontemerg_add" id="modcontemerg_add" class="form-control col-lg-6" value=""/>
										</div>
									</div>
									<div class="form-group">
										<label for="modtelcontemerg_add" class="control-label col-lg-4">Telefono:</label>
										<div class="col-lg-8">
										<input type="text" name="modtelcontemerg_add" id="modtelcontemerg_add" class="form-control col-lg-6" value=""/>
										</div>
										<input name="modtipcontemerg_add" id="modtipcontemerg_add" type="hidden" value="10" />
									</div>
									<hr>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
									<button type="submit" class="btn btn-primary">Salva</button> 
								</div>
								 </form>
							</div>
						</div>
					</form>
					</div>
				</div> 
                <!--FINE ADD CONTATTI DI EMERGENZA-->




			<!-- MODALE ADD CONTATTI EMERGENZA -->
			
			<!-- TODO: Riaggiungere ADD CONTATTI EMERGENZA -->
			
			<!--FINE ADD CONTATTI DI EMERGENZA-->

		</div>
	</div>
</div> <!--content-->
<!--END PAGE CONTENT -->
@endsection