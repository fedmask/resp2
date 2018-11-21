<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<meta name="csrf-token" content="{{ csrf_token() }}">
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

#tableP1 td, #tableP1 th {
	border: 1px solid #ddd;
	padding: 8px;
}

#tableP1 tr:nth-child(even) {
	background-color: #f2f2f2;
}

#tableP1 tr:hover {
	background-color: #ddd;
}

#tableP1 th {
	padding-top: 10px;
	padding-bottom: 10px;
	text-align: left;
	background-color: #cccccc;
	color: #000000;
}

#tableP2 td, #tableP2 th {
	border: 1px solid #ddd;
	padding: 8px;
}

#tableP2 tr:nth-child(even) {
	background-color: #f2f2f2;
}

#tableP2 tr:hover {
	background-color: #ddd;
}

#tableP2 th {
	padding-top: 10px;
	padding-bottom: 10px;
	text-align: left;
	background-color: #cccccc;
	color: #000000;
}




#myInput1 {
	background-image: url('/css/searchicon.png');
	background-position: 10px 10px;
	background-repeat: no-repeat;
	width: 100%;
	font-size: 12px;
	padding: 12px 20px 12px 40px;
	border: 1px solid #ddd;
	margin-bottom: 12px;
}

#myInput2 {
	background-image: url('/css/searchicon.png');
	background-position: 10px 10px;
	background-repeat: no-repeat;
	width: 100%;
	font-size: 12px;
	padding: 12px 20px 12px 40px;
	border: 1px solid #ddd;
	margin-bottom: 12px;
}
</style>


/* END CONTENT STYLES*/
</style>


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


	
		<div class="modal fade" id="myModalRegisterOPA" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">Registra Operazione Amministrativa</div>

					<div class="modal-body">

						<!-- Continuare da qui -->
						{{ Form::open(['url' => '/administration/ActivityCreate']) }}


						<div class="form-group">
							{{ Form::label('DataStart', 'Data Inizio Operazione*')}} <br>
							{{Form::date('date','',['id'=>"dateStart", 'name'=>"dateStart", 'class' => 'form-control col-lg-6'])}}<br> 
							{{ Form::label('DataEnd', 'Data Fine Operazione')}}<br> 
							{{Form::date('date','', ['id'=>"DateEndD",'name'=>"DateEndD", 'class' => 'form-control col-lg-6'])}} <br> <br>
							<h5>
								<b>Tipologia operazione*</b>
							</h5>
							{{ Form::text('Attivita', null, ['class' => 'form-control']) }}
							{{ Form::label('Description', 'Descrizione')}} 
							{{Form::text('Descrizione', null, ['class' => 'form-control']) }}
							{{Form::label('Anomalie', 'Anomalie Riscontrate')}} 
							{{Form::text('AnomalieR', null, ['class' => 'form-control']) }}
						</div>
						<br> <b><p>I campi contrassegnati dal simbolo* sono obbligatori.</p></b>
						
						
						@if ($errors->has('Attivita'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('Attivita') }}</div>
									@endif
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
