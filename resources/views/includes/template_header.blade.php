<?php
if (!empty($current_user->data_patient()->first()->id_paziente)) {
    $id_paz = $current_user->data_patient()->first()->id_paziente;
}
?>

<link href="/css/icon_chat.css" rel="stylesheet">
<link href="/css/chat_style.css" rel="stylesheet">
<!-- Typeahead plugin -->
<link href="/css/typeahead.css" rel="stylesheet">

<!-- BEGIN BODY-->
<script src="{{ asset('js/jquery-2.0.3.min.js') }}"></script>
<body class="padTop53 ">
	<audio id="notification_audio">
		<source src="/audio/incoming_mex.mp3" type="audio/mpeg"></source>
	</audio>
	<!-- MAIN WRAPPER -->
	<div id="wrap">
		<!--MESSAGES MODAL -->
		<div class="col-lg-12">
			<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-chat">
					<div class="modal-content">
						<div class="modal-body">
							<div class="row">
								<div id="messagesList" class="col-lg-4 col-md-6">
									<!--Alt messages list-->
									<div class="panel widget-messages-alt">
										<div class="panel-heading">
											<span class="panel-title"><i class="panel-title-icon fa fa-envelope"></i>Lista messaggi</span>
										</div>
										<!-- / .panel-heading -->
										<div class="panel-body padding-sm">
											<div id="messages_list" class="messages-list">
											</div>
											<!-- / .messages-list -->
										</div>
										<!-- / .panel-body -->
									</div>
									<!-- / .panel -->
									<!-- Fine MESSAGES_LIST_ALT -->
								</div>

								<div id="messagesChat" class="col-lg-8 col-md-6">

									<!--Chat-->
									<div class="panel widget-chat">
										<div class="panel-heading">
											<span class="panel-title"><i class="panel-title-icon fa icon_custom-chat"></i>Messaggi privati</span>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="closeMessageModal">&times;</button>
										</div>
										<!-- / .panel-heading -->
										<div id="messages_chat" class="panel-body">
										</div>
										<!-- / .panel-body -->
										<form class="panel-footer panel-footer-chat chat-controls" id="send_private_message">
											<div class="chat-controls-input">
												<textarea id="send_private_message_textarea" rows="1" class="form-control"></textarea>
												<input id="idsorgente" value="{{ Auth::id() }}" class="submission"></input>
												<input id="iddestinatario" value="-1" class="submission"></input>
												<input id="idconversazione" value="-1" class="submission"></input>
											</div>
											<button id="send_private_message_btn" class="btn btn-primary chat-controls-btn">Invia</button>
										</form>
										<!-- / .panel-footer -->
									</div>
									<!-- / .panel -->
									<!-- Fine chat -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<!--END MESSAGES MODAL -->

		<!-- HEADER SECTION -->
		<div id="top">

			<nav class="navbar navbar-inverse navbar-fixed-top " style="padding-top: 10px;">
				<a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
                    <i class="icon-align-justify"></i>
                </a>
			

				<!-- LOGO SECTION -->
				<header class="navbar-header">
				<a href="/home" class="navbar-brand" style="color:#1d71b8; font-size:22px"><img src="/img/logo_icona.png" alt="">&nbsp;
				   R<span style="color:#36a9e1">egistro</span>
				   E<span style="color:#36a9e1">lettronico</span>
				   S<span style="color:#36a9e1">anitario</span>
				   P<span style="color:#36a9e1">ersonale</span>
				   M<span style="color:#36a9e1">ultimediale</span>
				</a>
				</header>
				<!-- END LOGO SECTION -->
				@if($current_user->getRole() == Auth::user()::EMERGENCY_ID)
					<span class="navbar-text">
					  <strong>{{$current_user->getName()}} {{$current_user->getSurname()}}</strong> - {{$current_user->getFiscalCode()}} (<?php echo date('d/m/y', strtotime($current_user->getBirthdayDate())); ?> - {{$current_user->getAge($current_user->getBirthdayDate())}} anni)
					</span>
				@endif

				<ul class="nav navbar-top-links navbar-right">
					<!-- HOME SECTION -->
					@if( $current_user->getDescription() == User::PATIENT_DESCRIPTION)
					<li><a href="/home">Home <em class="icon-home"></em> </a>
					</li>
					@else
					<li><a href="/home">Home <em class="icon-home"></em> </a>
					</li>
					@endif
					<!-- END HOME SECTION -->

					<!--USER SETTINGS SECTIONS -->
					<!--rispetto alla versione originale si è tolta la classe dropdown  e si sono lasciate la modifica				
					delle impostazioni di sicurezza ed il logout nella lista della navbar-->
					<!--Modifica impostazioni sicurezza  -->
					@if( $current_user->getDescription() == User::PATIENT_DESCRIPTION)
					<li>
						<a href="/impostazioniSicurezza"><i class="icon-lock"></i>Impostazioni di sicurezza</a>
					</li>
					<li><a href="http://fsem.di.uniba.it/modello%20PBAC/createPDF.php"><i class="icon-book"></i> Report</a>
					</li>					
					@endif

					<!-- se l'utente e' un paziente visualizzo il pulsante per l'esportazione del profilo -->
					@if( $current_user->getDescription() != User::PATIENT_DESCRIPTION)

				<!--  	<li>
				    <a href="http://localhost:8000/fhir/Patient/{{$id_paz}}" download="RESP-PATIENT-{{$id_paz}}.xml">
                    <i class="glyphicon glyphicon-cloud-download"></i> Esporta profilo</a>
					</li>-->
				<li>
				    <a href="/fhirPatient" target="_blank">
                    <i class="glyphicon glyphicon-fire"></i> FHIR</a>

					</li>
					
					@endif
					
               <!-- se l'utente e' un careprovider visualizzo il pulsante per la gestione delle risorse FHIR -->
					@if( $current_user->getDescription() == User::PATIENT_DESCRIPTION)

				<!--  	<li>
				    <a href="http://localhost:8000/fhir/Patient/{{$id_paz}}" download="RESP-PATIENT-{{$id_paz}}.xml">
                    <i class="glyphicon glyphicon-cloud-download"></i> Esporta profilo</a>
					</li>-->
				<li>
				    <a href="/fhirPatientIndex/{{$id_paz}}" target="_blank">
                    <i class="glyphicon glyphicon-fire"></i> FHIR</a>

					</li>
					
					@endif
					
					<!--Logout  -->
					<li>
						<a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="icon-signout"></i>
                                            Logout
                                        </a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
					</li>
					<!--END ADMIN SETTINGS -->
				</ul>
			</nav>
		</div>
		
		
		<!-- END HEADER SECTION -->