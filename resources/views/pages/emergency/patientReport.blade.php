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
									{{$patient_info[0]->getSurname()}}
								</span>
							</li>
							<li><strong>Nome</strong>:
								<span>
									{{$patient_info[0]->getName()}}
								</span>
							</li>
							<li><strong>Codice Fiscale</strong>:
								<span>
									{{$patient_info[0]->user()->first()->getFiscalCode()}}
								</span>
							</li>
							<li><strong>Data di nascita</strong>:
								<span>
									<?php echo date('d/m/y', strtotime($patient_info[0]->user()->first()->getBirthdayDate())); ?>
								</span>
							</li>
							<li><strong>Età</strong>:
								<span>
									{{$patient_info[0]->getAge($patient_info[0]->user()->first()->getBirthdayDate())}}
								</span>
							</li>
							<li><strong>Sesso</strong>:
								<span>
									{{$patient_info[0]->getGender()}}
								</span>
							</li>
							<li><strong>Città di nascita</strong>:
								<span>
								{{$patient_info[0]->user()->first()->getBirthTown()}}
								</span>
							</li>
							<li><strong>Residenza</strong>:
								<span>
									{{$patient_info[0]->user()->first()->getLivingTown()}}
								</span>
								&nbsp;-&nbsp;
								<span>
									{{$patient_info[0]->getAddress()}}
								</span>
							</li>
							</li>
							<li><strong>Telefono</strong>: {{$patient_info[0]->user()->first()->getTelephone()}}
							</li>
							<li>
								<a href="#" data-toggle="modal" data-target="">
											<i class="icon-envelope-alt"></i> {{$patient_info[0]->user()->first()->getEmail()}}
										</a>
							</li>
							<li><strong>Stato Civile</strong>: {{$patient_info[0]->user()->first()->getMaritalStatus()}}
							</li>
						</ul>
					</div>
				</div>

				<!--GRUPPO SANGUIGNO-->
				<div class="col-lg-6">
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




				<!--DONAZIONE ORGANI-->
				<div class="col-lg-6">
					<div class="panel panel-warning">
						<div class="panel-body">
							<ul class="list-unstyled">
								<li> <strong>Donazione d'organi</strong>:
									<span>
									{{$patient_info[0]->user()->first()->getOrgansDonor() === false ? 'Nega il consenso' : 'Acconsente alla donazione'}}
									</span>
								</li>
							</ul>
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
								<h2>Contatti di emergenza</h2>
							</center>
						</div>
						<input type="hidden" name="delcontemerg_hidden" id="delcontemerg_hidden" class="form-control col-lg-6" value="0"/>
						<div class="panel-body">
							<div class="table-responsive">
								<form action="/pazienti/removeContact" method="POST">
									{{ csrf_field() }}
									<table class="table">
										<thead>
											<tr>
												<th>Nome</th>
												<th>Telefono</th>

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



		</div>
	</div>
</div> <!--content-->
<!--END PAGE CONTENT -->
@endsection