<!-- MENU SECTION -->
	<div id="left">
		<div class="media user-media well-small">
			<a class="user-link" href="/home">
				<!-- TODO: Aggiungere controllo se l'immagine del profilo è stata impostata -->
				<img class="media-object img-thumbnail user-img" alt="Immagine Utente" src="/img/user.gif"/>
			</a>
			<br/>
			<div class="media-body">
				<h5 class="media-heading">
				{{$current_user->getName()}}
				</h5>
			
				<h5 class="media-heading">
				{{$current_user->getSurname()}}
				</h5>
			
			</div>
			<br/>
		</div>
		<!--ANAGRAFICA RIDOTTA-->
		<div class="well well-sm">
			<ul class="list-small">
				<li><strong>C.F.</strong>:
					<span>
						{{$current_user->getFiscalCode()}}
					</span>
				
				</li>
				<li><strong>Data di nascita</strong>:
					<span>
						<?php echo date('d/m/y', strtotime($current_user->getBirthdayDate())); ?>

					</span> <strong>Età</strong>:
					<span>
						{{$current_user->getAge($current_user->getBirthdayDate())}}
					</span>
				
				</li>
				<li><strong>Telefono</strong>: {{$current_user->getTelephone()}}
				</li>
				@if($current_user->getRole() === 'Care provider')
				<li><a href="#" data-toggle="modal" data-target="#formModal"><i class="icon-envelope-alt"></i>{{$current_user->getEmail()}}</a>
				</li>
				@endif
			</ul>
		</div>
		<!--FINE ANAGRAFICA RIDOTTA-->
		<!--MODAL EMAIL-->
		<div class="col-lg-12">
			<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="chiudiformmodalmail">&times;</button>
							<h4 class="modal-title" id="H2">Nuova Email</h4>
						</div>
						<form class="form-horizontal" id="patmailform">
							<div class="modal-body">
								<div class="form-group">
									<!--il getvar deve prendere nome e cognome del medico-->
									<label class="control-label col-lg-4">Da COGNOME-CP NOME-CP :</label>
								
									<div class="col-lg-8">
										<input type="text" name="nomeutente" id="nomeutente" value="EMAIL-CP" readonly class="form-control"/>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-4">A PAZ-COGNOME PAZ-NOME:</label>
									<div class="col-lg-8">
										<input type="text" name="mail" id="mail" value="PAZIENTE-EMAIL" readonly class="form-control"/>
									</div>
								</div>
								<div class="form-group">
									<label for="oggettomail" class="control-label col-lg-4">Oggetto:</label>
									<div class="col-lg-8">
										<input type="text" name="oggettomail" id="oggettomail" class="form-control col-lg-6"/>
									</div>
								</div>
								<div class="form-group">
									<label for="contenuto" class="control-label col-lg-4">Testo:</label>
									<div class="col-lg-8">
										<textarea name="contenuto" id="contenuto" class="form-control col-lg-6" rows="6"></textarea>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
								<button type="submit" class="btn btn-primary">Invia</button>
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>
		<!--  FINE MODAL EMAIL-->
		<div class="row">
			<div class="well well-sm">
				<!-- TODO: aggiungere controllo se vi è già una visita in corso -->
				<a href="LINK-VISITA" class="btn btn-primary btn-block" id="btn_menu_nuovavisita"><i class="icon-stethoscope"></i>  Visite</a>
			</div>
		</div>

		<ul id="menu" class="collapse">
			<!-- TODO: AGGIUNGERE CONTROLLI DI VERIFICA PER VEDERE SE IL PANEL È ATTIVO O NO -->
			<li class="panel {{Request::path() === 'patient-summary' ? 'active' : ''}}"> <a href="/patient-summary"> <em class="icon-table"></em> Patient Summary esteso </a>
			</li>

			<!-- ANAMNESI -->

			<li class="panel"> <a href="ANAMNESI-FAM"> <em class="icon-archive"></em> Anamnesi </a>
			</li>


			<!-- VACCINAZIONE -->

			<!-- ALLERGIE / INTOLLERANZE -->

			<li class="panel">
				<a id="diagnosticArrowLink" href="" onClick="return false;" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed" data-target="#form-nav">
                        <i class="icon-search"></i> Indagini Diagnostiche
                        <span class="pull-right">
                            <i id="diagnosticArrow" class="icon-angle-left"></i>
                        </span>
                    </a>
			

				<ul class="collapse" id="form-nav">
					<li class="diagnostic"><a href="LINK-INDAGINI"><i class="icon-angle-right"></i> Diario Indagini Diagnostiche </a>
					</li>
					<li class="diagnostic"><a href="LINK-RICHIESTE"><i class="icon-angle-right"></i> Richiesta Indagini Diagnostiche </a>
					</li>
				</ul>
			</li>
			<li class="panel"> <a href="LINK-DIAGNOSI"> <em class="icon-file-text-alt"></em> Diagnosi </a>
			</li>
			<li class="panel"> <a href="LINK-FILES"> <em class="icon-file"></em> Files </a>
			</li>
			<li class="panel  {{Request::path() === 'taccuino' ? 'active' : ''}}"> <a href="{{ url('taccuino') }}"> <em class="icon-book"></em> Taccuino Paziente </a>
			</li>
			<!--diario visite deve diventare diario paziente-->
			<li class="panel {{Request::path() === 'careproviders' ? 'active' : ''}}"> <a href="{{ url('careproviders') }}"> <em class="icon-user-md"></em> Care Providers </a>
			</li>
			<li class="panel {{Request::path() === 'calcolatrice-medica' ? 'active' : ''}}"> <a href="{{ url('calcolatrice-medica') }}"> <em class="icon-keyboard"></em> Calcolatrice Medica </a>
			</li>
			<li class="panel {{Request::path() === 'links' ? 'active' : ''}}"> <a href="{{ url('utility') }}"> <em class="icon-tag"></em> Utility </a>
			</li>
		</ul>

	</div>
<!--END MENU SECTION -->
<script>
	window.onload = function () {
		//var anamnesiArrowLink = document.getElementById('anamnesiArrowLink');
		var anamnesiArrow = document.getElementById( 'anamnesiArrow' );

		var anamnesiUl = document.getElementById( 'component-nav' );

		var diagnosticUl = document.getElementById( 'form-nav' );


		if ( anamnesiUl.className == "in" ) {
			anamnesiArrow.className = "";
			anamnesiArrow.className = "icon-angle-down";
		}

		if ( diagnosticUl.className == "in" ) {
			diagnosticArrow.className = "";
			diagnosticArrow.className = "icon-angle-down";
		}
	};


	var anamnesiArrow = document.getElementById( 'anamnesiArrow' );
	var anamnesiArrowLink = document.getElementById( 'anamnesiArrowLink' );

	anamnesiArrowLink.addEventListener( 'click', function () {
		diagnosticArrowLink.className = "";
		diagnosticArrowLink.className = "accordion-toggle collapsed";
		diagnosticArrow.className = "";
		diagnosticArrow.className = "icon-angle-left";

		if ( anamnesiArrow.className == "icon-angle-left" ) {
			anamnesiArrow.className = "";
			anamnesiArrow.className = "icon-angle-down";
		} else {
			anamnesiArrow.className = "";
			anamnesiArrow.className = "icon-angle-left";
		}
	} );

	var diagnosticArrow = document.getElementById( 'diagnosticArrow' );
	var diagnosticArrowLink = document.getElementById( 'diagnosticArrowLink' );

	diagnosticArrowLink.addEventListener( 'click', function () {
		anamnesiArrowLink.className = "";
		anamnesiArrowLink.className = "accordion-toggle collapsed";
		anamnesiArrow.className = "";
		anamnesiArrow.className = "icon-angle-left";

		if ( diagnosticArrow.className == "icon-angle-left" ) {
			diagnosticArrow.className = "";
			diagnosticArrow.className = "icon-angle-down";
		} else {
			diagnosticArrow.className = "";
			diagnosticArrow.className = "icon-angle-left";
		}
	} );

	var anamnesi = document.getElementsByClassName( "anamnesi" );

	for ( var i = 0; i < anamnesi.length; i++ ) {
		anamnesi[ i ].addEventListener( 'click', function () {
			anamnesiArrow.className = "";
			anamnesiArrow.className = "icon-angle-down";
		}, false );
	}

	var diagnostic = document.getElementsByClassName( "anamnesi" );

	for ( var i = 0; i < diagnostic.length; i++ ) {
		diagnostic[ i ].addEventListener( 'click', function () {
			diagnosticArrow.className = "";
			diagnosticArrow.className = "icon-angle-down";
		}, false );
	}
</script>