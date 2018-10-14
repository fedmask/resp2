@extends('layouts.app') @extends('includes.template_head')


@section('content')
<!--PAGE CONTENT -->
<div id="content">
	<div class="inner" style="min-height: 1200px;">
		<div class="row">
			<div class="col-lg-12">
				<h2>Trattamenti</h2>
				<hr>

				<br>

				<style>
/* The container */
.container {
	display: block;
	position: relative;
	padding-left: 35px;
	margin-bottom: 12px;
	cursor: pointer;
	font-size: 12px;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
	position: absolute;
	opacity: 0;
	cursor: pointer;
	height: 0;
	width: 0;
}

/* Create a custom checkbox */
.checkmark {
	position: absolute;
	top: 0;
	left: 0;
	height: 20px;
	width: 20px;
	background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
	background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
	background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
	content: "";
	position: absolute;
	display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
	display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
	left: 9px;
	top: 5px;
	width: 5px;
	height: 10px;
	border: solid white;
	border-width: 0 3px 3px 0;
	-webkit-transform: rotate(45deg);
	-ms-transform: rotate(45deg);
	transform: rotate(45deg);
}
</style>

				<form class="form-horizontal"
					action="{{action('ConsensiPazienteController@update')}}"
					method="post">
					{{ Form::open(array('url' => '/consent/update')) }} {{
					csrf_field() }}
					@foreach($listaConsensi as $LC)
					<div class="well">
						<div class="modal-body">
							<h2>{{$LC->getTrattamentoNome()}}</h2>
							<p>{{$LC->getTrattamentoInformativa()}}</p>
							<div class="form-group">
								
								<div class="col-lg-8">
									<label> {{Form::radio('check'.$LC->getID_Trattamento(), 'nego',
										$LC['Consenso'] === 0? true :
										false )}} Nego il consenso </label> <label>
										{{Form::radio('check'.$LC->getID_Trattamento(), 'acconsento',
										$LC['Consenso'] === 1 ? true :
										false )}} Acconsento </label>
								</div>
							</div>
						</div>
						</div>
						@endforeach
						<div class="modal-footer">
							<button type="button" class="btn btn-default"
								data-dismiss="modal" onclick = "window.location.reload()";>Annulla</button>
							{{ Form::submit('Salva', ['class' => 'btn btn-primary'])}}
						</div>
						{{ Form::close() }}
				
				</form>

			</div>


		</div>

	</div>
</div>


<!--END PAGE CONTENT -->

@endsection
