 @extends('pages.Administration.app_Admin') @section('content')

<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
/* The container */
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

/* Hide the browser's default radio button */
.container input {
	position: absolute;
	opacity: 0;
	cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
	position: absolute;
	top: 0;
	left: 20;
	height: 20px;
	width: 20px;
	background-color: #eee;
	border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
	background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
	background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
	content: "";
	position: absolute;
	display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
	display: block;
}

/* Style the indicator (dot/circle) */
.container .checkmark:after {
	top: 7px;
	left: 7px;
	width: 7px;
	height: 7px;
	border-radius: 50%;
	background: white;
}

/* BEGIN CONTENT STYLES */
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

/* Darker background on mouse-over */
.btn1:hover {
	background-color: RoyalBlue;
}
</style>


/* END CONTENT STYLES */
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
			<i class="fa fa-floppy-o"></i> Registra Operazione
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




	</div>
</div>





<!--END PAGE CONTENT -->
@endsection
