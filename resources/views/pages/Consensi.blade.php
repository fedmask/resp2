@extends('layouts.app') @extends('includes.template_head')


@section('content')


<style>
/* The container */
.container {
	display: block;
	position: relative;
	padding-left: 50px;
	margin-bottom: 12px;
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
</style>

<!-- Use scripts for Modal -->
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!--PAGE CONTENT -->
<div id="content">
	<div class="inner" style="min-height: 1200px;">
		<div class="row">
			<div class="col-lg-12">
				<h2>Trattamenti</h2>

				<br>

				<!-- Apro il form per la gestione delle checkbox -->
				<form class="form-horizontal"
					action="{{action('ConsensiPazienteController@update')}}"
					method="post">
					{{ Form::open(array('url' => '/consent/update')) }} {{ csrf_field()
					}}
					<table style="font-size: 12"
						; class="table table-striped table-bordered table-hover">
						<tr>
							<th>#ID</th>
							<th>Trattamento</th>
							<th align="center">Informativa</th>
							<th>Ultima Modifica</th>
							<th>Stato</th>
						</tr>

						<!-- Ciclo sui Consensi -->
						@foreach($listaConsensi as $LC)
						<tr>
							<td align="center">{{$LC->getID_Trattamento()}}</td>
							<td><b>{{$LC->getTrattamentoNome()}}</b></td>

							<!-- Button per il Modal referenziato tramite #myModal più l'ID del trattamento -->
							<td align="center"><button type="button" class="btn btn-info "
									data-toggle="modal"
									data-target="{{'#myModal'.$LC->getID_Trattamento()}}">Mostra</button></td>

							<td>{{$LC->getDataConsenso()}}</td>

							<!-- Verifico lo stato del consenso e visualizzo le check nel modo più opportuno -->
							@if($LC['Consenso'] === 0)
							<td><label class="container">Nego il consenso <input type="radio"
									checked="checked" name="{{'check'.$LC->getID_Trattamento()}}"
									value="nego"> <span class="checkmark"></span>
							</label> <label class="container">Acconsento <input type="radio"
									name="{{'check'.$LC->getID_Trattamento()}}" value="acconsento">
									<span class="checkmark"></span>
							</label></td> 
							@else
							<td><label class="container">Nego il consenso <input type="radio"
									name="{{'check'.$LC->getID_Trattamento()}}" value="nego"> <span
									class="checkmark"></span>
							</label> <label class="container">Acconsento <input type="radio"
									checked="checked" name="{{'check'.$LC->getID_Trattamento()}}"
									value="acconsento"> <span class="checkmark"></span>
							</label></td> 
							@endif



						</tr>

						<!-- Modal -->
						<div class="modal fade"
							id="{{'myModal'.$LC->getID_Trattamento()}}" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Informativa trattamento
											{{$LC->getTrattamentoNome()}}</h4>
									</div>
									<div class="modal-body">
										<h4><b>Finalita:</b></h4>
										<p>{{$LC->getTrattamentoFinalita()}}</p><br>
										<h4><b>Informativa:</b></h4>
										<p>{{$LC->getTrattamentoInformativa()}}</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default"
											data-dismiss="modal">Chiudi</button>
									</div>
								</div>

							</div>
						</div>


						@endforeach
					</table>
			
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"
					onclick="window.location.reload()";>Annulla</button>
				{{ Form::submit('Salva', ['class' => 'btn btn-primary'])}}
			</div>
			{{ Form::close() }}

			</form>

		</div>


	</div>
</div>


<!--END PAGE CONTENT -->

@endsection
