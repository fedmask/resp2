@extends('layouts.app') @extends('includes.template_head')


@section('pageTitle', 'Diagnosi') @section('content')
<!--PAGE CONTENT -->
<div id="content">
	<div class="inner" style="min-height: 1200px;">
		<div class="row">
			<div class="col-lg-12">
				<h2>Trattamenti</h2>
				<hr>
				<script
					src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
				<script src="formscripts/jquery.js"></script>
				<script src="formscripts/jquery-ui.js"></script>
				<script src="formscripts/diagnosi.js"></script>

				<br>

				<style>
/* The container */
.container {
	display: block;
	position: relative;
	padding-left: 35px;
	margin-bottom: 12px;
	cursor: pointer;
	font-size: 22px;
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
	left: 0;
	height: 25px;
	width: 25px;
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
	top: 9px;
	left: 9px;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: white;
}
</style>

				<div class="container">
					
					<div class="well">
					<h2>
					Trattamento 1
					</h2>
					<p>{!! Form::label('nome', 'Il tuo nome:') !!}</p>
					<p>Ciao questa è una prova</p>
					<label class="container">One <input type="radio" checked="checked"
						name="radio"> <span class="checkmark"></span>
					</div>
				</div>
			</div>


		</div>







	</div>
</div>

<script>

//gestisce la conferma dei dati per la modifica di una diagnosi 
$(document).on('click', "a.conferma", function () {
	var id = $(this).attr('data-id');
	var stato = $('#stato'+id).val();
	var cpp = $('#cpp'+id).val();
	var conf = $('#conf'+id).val();
    window.location.href="http://localhost:8000/modDiagn/"+id+"/"+stato+"/"+cpp+"/"+conf;
	$('#formD')[0].reset(); 
});



<!--END PAGE CONTENT -->

@endsection


