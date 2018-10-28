 @extends('pages.Administration.app_Admin') @section('content')

<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
/* The container*/
.container {
	display: block;
	position: relative;
	padding-left: 30px;
	margin-bottom: 14px;
	cursor: pointer;
	font-size: 10px;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
}

/* Hide the browser's default radio button*/
.container input {
	position: absolute;
	opacity: 0;
	cursor: pointer;
}

/* Create a custom radio button*/
.checkmark {
	position: absolute;
	top: 0;
	left: 20;
	height: 20px;
	width: 20px;
	background-color: #eee;
	border-radius: 50%;
}

/* On mouse-over, add a grey background color*/
.container:hover input ~ .checkmark {
	background-color: #ccc;
}

/* When the radio button is checked, add a blue background*/
.container input:checked ~ .checkmark {
	background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked)*/
.checkmark:after {
	content: "";
	position: absolute;
	display: none;
}

/* Show the indicator (dot/circle) when checked*/
.container input:checked ~ .checkmark:after {
	display: block;
}

/* Style the indicator (dot/circle)*/
.container .checkmark:after {
	top: 7px;
	left: 7px;
	width: 7px;
	height: 7px;
	border-radius: 50%;
	background: white;
}

/* BEGIN CONTENT STYLES*/
#content {
	-webkit-transition: margin 0.4s;
	transition: margin 0.4s;
}

.outer {
	padding: 10px;
	background-color: #6e6e6e;
}

.outer:before, .outer:after {
	display: table;
	content: " ";
}

.outer:after {
	clear: both;
}

.inner {
	position: relative;
	min-height: 1px;
	/*padding-right: 10px;*/
	padding-right: 15px;
	padding-left: 10px;
	background: #fff;
	border: 0px solid #e4e4e4;
	min-height: 1200px;
}

@media ( min-width : 768px) {
	.inner {
		float: left;
		width: 145%;
	}
}

.inner .row {
	margin-right: 0px;
	margin-left: -15px;
}

p.round2 {
	border: 2px solid blue;
	border-radius: 8px;
}

<
style>* {
	box-sizing: border-box;
}

.btn1 {
	background-color: DodgerBlue;
	border: none;
	color: white;
	padding: 12px 30px;
	cursor: pointer;
	font-size: 20px;
}

/* Darker background on mouse-over*/
.btn1:hover {
	background-color: RoyalBlue;
}

.btn2 {
	background-color: #66bb66;
	border: none;
	color: white;
	padding: 12px 30px;
	cursor: pointer;
	font-size: 20px;
}

/* Darker background on mouse-over*/
.btn2:hover {
	background-color: #599c59;
}

.btn3 {
	background-color: #f50606;
	border: none;
	color: white;
	padding: 12px 30px;
	cursor: pointer;
	font-size: 20px;
}

/* Darker background on mouse-over*/
.btn3:hover {
	background-color: #d80606;
}

</style>


/* END CONTENT STYLES*/
</style>
<!-- Use scripts for Modal -->
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!--PAGE CONTENT -->





<div id="content">
	<div class="inner" style="min-height: 1200px;">
		<br>
		<h2>Gestione amministrazione</h2>
		<button class="btn1" style="width: 100%" data-toggle="modal"
			data-target="#myModalRegisterOP">
			<i class="fa fa-floppy-o"></i> Registra Operazione su un Utente
		</button>


		<div class="modal fade" id="myModalRegisterOP" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">Registra Operazione</div>

					<div class="modal-body">


						{{ Form::open(['url' => '/administration/SA']) }}


						<div class="form-group">{{ Form::label('Descrizione', 'Descrizione
							Operazione')}} {{ Form::text('Descrizione', null, ['class' =>
							'form-control']) }} {{ Form::label('Utente','ID Utente
							Coinvolto') }} {{ Form::text('Utente', null, ['class'
							=>'form-control']) }} {{ Form::label('Data', 'Data Operazione')}}
							{{Form::date('date','', ['id'=>"add_data", 'name'=>"add_data",
							'class' => 'form-control col-lg-6'])}}</div>


					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"
							onclick="window.location.reload()";>Annulla</button>
						{{ Form::submit('Salva', ['class' => 'btn btn-primary'])}}
					</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>


		<br>
		<hr>
		<button class="btn1" style="width: 100%" data-toggle="modal"
			data-target="#myModalRegisterOPA">
			<i class="fa fa-floppy-o"></i> Registra Operazione Amministrativa
		</button>


		<div class="modal fade" id="myModalRegisterOPA" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">Registra Operazione Amministrativa</div>

					<div class="modal-body">

						<!-- Continuare da qui -->
						{{ Form::open(['url' => '/administration/ActivityCreate']) }}


						<div class="form-group">
							{{ Form::label('DataStart', 'Data Inizio Operazione*')}} <br>{{Form::date('dateStart','',
							['id'=>"add_data", 'name'=>"add_data", 'class' => 'form-control
							col-lg-6'])}}<br> {{ Form::label('DataEnd', 'Data Fine
							Operazione')}}<br> {{Form::date('DateEndD','', ['id'=>"add_data",
							'name'=>"add_data", 'class' => 'form-control col-lg-6'])}} <br> <br>
							<h5>
								<b>Tipologia operazione*</b>
							</h5>
							{{ Form::text('Attivita', null, ['class' => 'form-control']) }}
							{{ Form::label('Description', 'Descrizione')}} {{
							Form::text('Descrizione', null, ['class' => 'form-control']) }}
							{{Form::label('Anomalie', 'Anomalie Riscontrate')}} {{
							Form::text('AnomalieR', null, ['class' => 'form-control']) }}
						</div>
						<br> <b><p>I campi contrassegnati dal simbolo* sono obbligatori.</p></b>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"
							onclick="window.location.reload()";>Annulla</button>
						{{ Form::submit('Salva', ['class' => 'btn btn-primary'])}}
					</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>








<hr>
		<button class="btn2" style="width: 100%" data-toggle="modal"
			data-target="#myModalRegisterAdmin">
			<i class="fa fa-floppy-o"></i> Registra Nuovo Amministratore
		</button>


		<div class="modal fade" id="myModalRegisterAdmin" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"><h3>Registra nuovo Amministratore</h3></div>

					<div class="modal-body">

						
						{{ Form::open(['url' => '/administration/AdminCreate']) }}

						{{ csrf_field() }}	
						<div class="form-group">
							
						
						
								<label for="userName" class="control-label col-lg-3">Username*</label>
								<input id="userName" name="username" type="text" class="form-control">
								@if ($errors->has('username'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('username') }}</div>
									@endif
								
							<br>

							
								<label for="email" class="control-label col-lg-3">Email*</label>
								<input id="email" name="email" type="email" class="form-control">
									@if ($errors->has('email'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('email') }}</div>
									@endif
								<br>
								<label for="confirmEmail" class="control-label col-lg-5">Conferma Email*</label>
								 <input id="confirmEmail" name="confirmEmail" type="email" class="form-control">
									@if ($errors->has('confirmEmail'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('confirmEmail') }}</div>
									@endif
								
							<br>

							
								<label for="password" class="control-label col-lg-5">Password*</label>
								 <input id="password" name="password" type="password" class="form-control" placeholder="almeno 8 caratteri tra cui una cifra">
									@if ($errors->has('password'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('password') }}</div>
									@endif
								<br>
								<label for="confirmPassword" class="control-label col-lg-5">Conferma Password*</label>
								 
									<input id="confirmPassword" name="confirmPassword" type="password" class="form-control">
									@if ($errors->has('confirmPassword'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('confirmPassword') }}</div>
									@endif
								<br>
							

						
								<label for="surname" class="control-label col-lg-3">Cognome*</label>
								 <input id="surname" name="surname" type="text" class="form-control">
									@if ($errors->has('surname'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('surname') }}</div>
									@endif
								<br>
								<label for="name" class="control-label col-lg-3">Nome*</label>
								 <input id="name" name="name" type="text" class="form-control">
									@if ($errors->has('name'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('name') }}</div>
									@endif
								
							<br>
<div>
							
								<label for="gender" class="control-label col-lg-3">Sesso*</label>
								 
									<label class="radio-inline">
										<input  type="radio"  name="gender" id="genderM" value="M">M
									</label>
									<label class="radio-inline">
										<input  type="radio"  name="gender" id="genderF" value="F">F
                                    </label>
                                    @if ($errors->has('gender'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('gender') }}</div>
									@endif
						</div>			
									<br>
						
	
								<label for="birthCity" class="control-label col-lg-5">Comune di nascita*</label>
								 <input id="birthCity" name="birthCity" type="text" class="typeahead form-control">
									@if ($errors->has('birthCity'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('birthCity') }}</div>
									@endif
								<br>
								<label for="birthDate" class="control-label col-lg-5">Data di nascita*</label>
								 <input id="birthDate" name="birthDate" type="text" class="form-control" placeholder="Inserisci  gg-mm-aaaa ">
									@if ($errors->has('birthDate'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('birthDate') }}</div>
									@endif
								
						<br>

						
								<label for="livingCity" class="control-label col-lg-5">Comune di residenza*</label>
								 <input id="livingCity" name="livingCity" type="text" class="typeahead form-control">
									@if ($errors->has('livingCity'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('livingCity') }}</div>
									@endif
								<br>
								<label for="address" class="control-label col-lg-5">Via/Corso/Piazza*</label>
								 <input id="address" name="address" type="text" class="form-control">
									@if ($errors->has('address'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('address') }}</div>
									@endif
								
							
<br>
							
								<label for="telephone" class="control-label col-lg-5">Recapito telefonico*</label>
								 
									<input id="telephone" name="telephone" type="tel" class="form-control">
									@if ($errors->has('telephone'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('telephone') }}</div>
									@endif
								<br>
<label for="telephone" class="control-label col-lg-5">Ruolo Amministratore*</label>

<div allign="left">
{{ Form::select('Ruolo', array('DPO' => 'DPO', 'Responsabile al Trattamento' => 'Responsabile al Trattamento','Personale di Supporto' => 'Personale di Supporto','Amministratore_di_sistema' =>
								'Amministratore_di_sistema'))}}
</div>

							
<br>
							
								<label for="tipodati" class="control-label col-lg-5">Tipo di dati trattati*</label> <input id="TypeData" name="TypeData" type="tel"
								class="form-control"> @if ($errors->has('telephone'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('TypeData') }}</div>
									@endif
								<br>



							
								</div>
								
							<p class="pull-right">(*) Campi obbligatori</p>
				
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"
							onclick="window.location.reload()";>Annulla</button>
						{{ Form::submit('Salva', ['class' => 'btn btn-primary'])}}
					</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>


<hr>


<div align="center">

				<button type="button" style="width: 100%" class="btn3" data-toggle="modal"
					style="font-size: 16" data-target="#myModalCancel">
					<i class="fa fa-check-square-o"></i> Cancella Account Amministrativo
				</button>
			</div>

			<div class="modal fade" id="myModalCancel" role="dialog">
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">Elimina Account Amministrativo</div>

						<div class="modal-body">

							{{ Form::open(['url' => '/administration/AdminDelete'])
							}}
							<div class="form-group">{{ Form::label('Id_Utente', 'ID Amministratore') }} {{ Form::text('Id_Admin2', null, ['class' =>
								'form-control']) }}</div>


							{{ Form::submit('Cancella', ['class' => 'btn btn-success']) }} {{
							Form::close() }}
						</div>
					</div>
				</div>
			</div>



	</div>
</div>





<!--END PAGE CONTENT -->
@endsection
