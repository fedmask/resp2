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

#myInput {
	background-image: url('/css/searchicon.png');
	background-position: 10px 10px;
	background-repeat: no-repeat;
	width: 100%;
	font-size: 12px;
	padding: 12px 20px 12px 40px;
	border: 1px solid #ddd;
	margin-bottom: 12px;
}

#customers {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	border-collapse: collapse;
	width: 100%;
}

#tableP td, #tableP th {
	border: 1px solid #ddd;
	padding: 8px;
}

#tableP tr:nth-child(even) {
	background-color: #f2f2f2;
}

#tableP tr:hover {
	background-color: #ddd;
}

#tableP th {
	padding-top: 10px;
	padding-bottom: 10px;
	text-align: left;
	background-color: #cccccc;
	color: #000000;
}

#tableP18 td, #tableP18 th {
	border: 1px solid #ddd;
	padding: 8px;
}

#tableP18 tr:nth-child(even) {
	background-color: #f2f2f2;
}

#tableP18 tr:hover {
	background-color: #ddd;
}

#tableP18 th {
	padding-top: 10px;
	padding-bottom: 10px;
	text-align: left;
	background-color: #cccccc;
	color: #000000;
}

.icon-bar {
	position: fixed;
	top: 50%;
	-webkit-transform: translateY(-50%);
	-ms-transform: translateY(-50%);
	transform: translateY(-50%);
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
		<h2>Pazienti</h2>
		<br> <input type="text" id="myInput" onkeyup="myFunction()"
			placeholder="Ricerca per Cognome..." title="Inserisci un cognome">

		<table id="tableP"
			style="overflow-x: auto;>
			<tr   

			
			
			  
			
			
			
			
			class="header">
			<th>#ID</th>
			<th>Cognome</th>
			<th>Nome</th>
			<th>Codice Fiscale</th>
			<th>Data di nascita</th>
			<th>Sesso</th>
			<th>Città di nascita</th>

			<th>Indirizzo</th>
			<th>Telefono</th>
			<th>E-mail</th>
			<th>Gruppo_Sanguigno</th>


			</tr>

			@foreach($Patients as $current_user)


			<tr>


				<td allign="center">{{$current_user->getID_Paziente()}}</td>
				<td>{{$current_user->getSurname()}}</td>
				<td>{{$current_user->getName()}}</td>

				<td>{{$current_user->getFiscalCode()}}</td>


				<td>{{date('d/m/y', strtotime($current_user->getBirthdayDate()))}}</td>
				<td>{{$current_user->getGender()}}</td>
				<td>{{$current_user->getCountryName()}}</td>
				<td>{{$current_user->getAddress()}}</td>
				<td>{{$current_user->getPhone()}}</td>
				<td>{{$current_user->getMail()}}</td>
				<td align="center"><button type="button" class="btn btn-info btn-lg"
						data-toggle="modal" style="font-size: 12"
						data-target="{{'#myModal'.$current_user->getID_Paziente()}}">Visualizza</button></td>



				<!-- Modal -->
				<div class="modal fade"
					id="{{'myModal'.$current_user->getID_Paziente()}}" role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Gruppo Sanguigno</h4>
							</div>
							<div class="modal-body">

								<h5>
									Paziente <b>{{$current_user->getFullName()}}</b>
								</h5>
								@if(($current_user->paziente_gruppo)!=null)


								<hr>
								<i class='fa fa-heart' style='font-size: 18px; color: red'></i>
								Il gruppo Sanguigno del Paziente e': <b>{{$current_user->paziente_gruppo}}.
								</b> Il Gruppo rh e': <b>{{$current_user->paziente_rh}}</b>

								<hr>
								<!-- Se non possiede risultati visualizza un messaggio -->
								@if(count($current_user->moduli__gruppo__sanguignos()))


								@foreach($current_user->moduli__gruppo__sanguignos() as $Modulo)
								<b>Id_Modulo: </b>{{$Modulo->Id_Modulo}} <br> <b>Data_convalida:
								</b>{{$Modulo->data_convalida}} <br> <b>Note: </b>{{$Modulo->note}}

								<hr>
								@endforeach @else

								<h6>Nessuna documentazione diponibile</h6>
								@endif @else
								<h6>Non sono diponibili informazioni</h6>

								@endif
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-default"
									data-dismiss="modal">Close</button>
							</div>

						</div>

					</div>
				</div>

			</tr>
			@endforeach
		</table>

		<hr>





		<h2>Pazienti Minori</h2>
		@if(!empty($Patient18)){



		<table>
			<table id="tableP18"
				style="overflow-x: auto;>
			<tr   
				class="header">
				<th>#ID</th>
				<th>Nome</th>
				<th>Cognome</th>
				<th>Anno di nascita</th>
				<th>Tutore Legale</th>
				<th>Documentazione</th>

				</tr>




				@foreach($patients18 as $Patient18)

				<tr>

					<td>{{$Patient18->getID_Paziente()}}</td>
					<td>{{$Patient18->getName()}}</td>
					<td>{{$Patient18->getSurname()}}</td>
					<td>{{date('d/m/y', strtotime($current_user->getBirthdayDate()))}}</td>
					<td>{{$Patient18->patient_contacts()->where('id_contatto_tipologia',
						1)->first()}}</td>




					<td>@foreach($Patient18->tbl_files() as $Files)
						<button type="button" class="btn btn-link"
							onclick="{{'window.location.href='.AdministratorController::getFile($Files->id_file,
								$Patient18->getID_Paziente())}}">{{$Files->file_nome}}</button>
						@endforeach
					</td>
				</tr>
				@endforeach


			</table>
			@else
			<p>Non ci sono Pazienti minorenni</p>
			@endif

			<hr>

			<!-- INIZIO MODAL ACTIVE USER -->
			<div align="center">

				<button type="button" class="btn btn-primary" data-toggle="modal"
					style="font-size: 16" data-target="#myModalActive">
					<i class="fa fa-check-square-o"></i> Attiva Account
				</button>
			</div>

			<div class="modal fade" id="myModalActive" role="dialog">
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">Attiva account paziente minore</div>

						<div class="modal-body">

							{{ Form::open(['url' => '/administration/PatientsList/Active'])
							}}
							<div class="form-group">{{ Form::label('Id_Paziente', 'ID del
								Paziente') }} {{ Form::text('Id_Paziente', null, ['class' =>
								'form-control']) }}</div>


							{{ Form::submit('Attiva', ['class' => 'btn btn-success']) }} {{
							Form::close() }}
						</div>
					</div>
				</div>
			</div>


			</div>

			</div>





			<script>


function myFunction() {
	  var input, filter, table, tr, td, i;
	  input = document.getElementById("myInput");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("tableP");
	  tr = table.getElementsByTagName("tr");
	  for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[1];
	    if (td) {
	      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    }       
	  }
	}


</script>








			<!--END PAGE CONTENT -->
			@endsection