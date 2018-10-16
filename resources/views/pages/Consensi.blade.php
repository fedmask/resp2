 @extends('layouts.app') @extends('includes.template_head')


@section('content')


<style>
/* The container */
.container {
	display: block;
	position: relative;
	padding-left: 40px;
	margin-bottom: 12px;
	cursor: pointer;
	font-size: 15px;
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

<!--PAGE CONTENT -->
<div id="content">
	<div class="inner" style="min-height: 1200px;">
		<div class="row">
			<div class="col-lg-12">
				<h2>Trattamenti</h2>
				<hr>

				<br>

				

				<form class="form-horizontal"
					action="{{action('ConsensiPazienteController@update')}}"
					method="post">
					{{ Form::open(array('url' => '/consent/update')) }} {{ csrf_field()
					}} @foreach($listaConsensi as $LC)
					<div class="well">
						<div class="modal-body">
							<h2>{{$LC->getTrattamentoNome()}}</h2>
							<p>{{$LC->getTrattamentoInformativa()}}</p>
							<p>
								L'ultima modifica risulta effettuata il: <b>
									{{$LC->getDataConsenso()}} </b>
							</p>
							<div class="form-group">



								@if($LC['Consenso'] === 0) 
								<label class="container">Nego il
									consenso <input type="radio" checked="checked"
									name="{{'check'.$LC->getID_Trattamento()}}" value="nego"> <span
									class="checkmark"></span>
								</label> <label class="container">Acconsento <input type="radio"
									name="{{'check'.$LC->getID_Trattamento()}}" value="acconsento">
									<span class="checkmark"></span>
								</label> 
								@else 
								<label class="container">Nego il consenso <input
									type="radio" name="{{'check'.$LC->getID_Trattamento()}}"
									value="nego"> <span class="checkmark"></span>
								</label> <label class="container">Acconsento <input type="radio"
									checked="checked" name="{{'check'.$LC->getID_Trattamento()}}"
									value="acconsento"> <span class="checkmark"></span>
								</label> 
								@endif



								<!-- Soluzione alternativa ma senza stile -->
								
								
								<!--  	<div class="col-lg-8">
									<label class="container"> {{Form::radio('check'.$LC->getID_Trattamento(), 'nego',
										$LC['Consenso'] === 0? true :
										false )}} Nego il consenso </label> <label>
										{{Form::radio('check'.$LC->getID_Trattamento(), 'acconsento',
										$LC['Consenso'] === 1 ? true :
										false )}} Acconsento </label>
								</div> 
								
							-->
							</div>
						</div>
					</div>
					@endforeach
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
</div>


<!--END PAGE CONTENT -->

@endsection
