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

#tableCP td, #tableP th {
	border: 1px solid #ddd;
	padding: 8px;
}

#tableCP tr:nth-child(even) {
	background-color: #f2f2f2;
}

#tableCP tr:hover {
	background-color: #ddd;
}

#tableCP th {
	padding-top: 10px;
	padding-bottom: 10px;
	text-align: left;
	background-color: #cccccc;
	color: #000000;
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
		<h2>Trattamenti Pazienti</h2>
		<br> <input type="text" id="myInput" onkeyup="myFunction()"
			placeholder="Ricerca per Nome Trattamento..."
			title="Inserisci un Nome Trattamento">

		<table id="tableP" width="100%">

			<tr style="font-size: 14">
				<th>#ID</th>
				<th>Nome_Trattamento,</th>
				<th align="center">Informativa</th>
				<th>Aggiorna</th>
			</tr>

			<!-- Ciclo sui Consensi -->
			@foreach($TrattamentiP as $LC)
			<tr>
				<td align="center">{{$LC->getId()}}</td>
				<td><b>{{$LC->Nome_T}}</b></td>

				<!-- Button per il Modal referenziato tramite #myModal più l'ID del trattamento -->
				<td align="center"><button type="button" class="btn btn-info "
						data-toggle="modal" data-target="{{'#myModal'.$LC->getId()}}">Show</button></td>

				<td align="center"><button type="button" class="btn btn-info "
						data-toggle="modal" data-target="{{'#myModalUp'.$LC->getId()}}">Update</button></td>



				<div class="modal fade" id="{{'myModal'.$LC->getId()}}"
					role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">Informativa trattamento {{$LC->Nome_T}}</div>

							<div class="modal-body">
								<h4>
									<b>Finalita:</b>
								</h4>
								<p>{{$LC->Finalita_T}}</p>
								<br>
								<h4>
									<b>Informativa:</b>
								</h4>


								@if($LC->getId()==6)
								<iframe src="/informative/donazioneorgani.html"
									class="col-lg-12" height="500"> </iframe>
								@else
								<p>{{$LC->Informativa}}</p>
								@endif
							</div>
						</div>
					</div>
				</div>




				<div class="modal fade" id="{{'myModalUp'.$LC->getId()}}"
					role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							{{ Form::open(array('url' =>
							'/administration/updateTrattamentiP')) }} {{ csrf_field() }}
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Aggiorna trattamento {{$LC->Nome_T}}</h4>
							</div>
							<div class="modal-body">
							
										
									<h4><b>Nome:</b></h4>
									{{Form::text('Nome_T'.$LC->getId(), $LC->Nome_T)}}	
								
									{{Form::hidden('TrattamentoID'.$LC->getId(), $LC->getId())}} <h4><b>Finalita:</b></h4>

									{{Form::textarea('Finalita_T'.$LC->getId(), $LC->Finalita_T)}} <br><h4> <b>Informativa:</b></h4>

 <br>

									@if($LC->getId()==6)
									<iframe src="/informative/donazioneorgani.html"
										class="col-lg-12" height="500"> </iframe>
									@else {{Form::textarea('Informativa_T'.$LC->getId(), $LC->Informativa)}}
									@endif
								
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default"
									data-dismiss="modal">Chiudi</button>
								{{ Form::submit('Salva', ['class' => 'btn btn-primary'])}}
							</div>
							{{ Form::close() }}
						</div>

					</div>
				</div>



			</tr>
			@endforeach
		</table>

		<hr>






		<br>
		<h2>Trattamenti Care Provider</h2>
		<br> <input type="text" id="myInput1" onkeyup="myFunction1()"
			placeholder="Ricerca per Nome Trattamento..."
			title="Inserisci un Nome Trattamento">

		<table id="tableCP" width="100%">

			<tr style="font-size: 14">
				<th>#ID</th>
				<th>Nome_Trattamento,</th>
				<th align="center">Informativa</th>
				<th>Aggiorna</th>
			</tr>

			<!-- Ciclo sui Consensi -->
			@foreach($TrattamentiCP as $LC)
			<tr>
				<td align="center">{{$LC->getId()}}</td>
				<td><b>{{$LC->Nome_T}}</b></td>

				<!-- Button per il Modal referenziato tramite #myModal più l'ID del trattamento -->
				<td align="center"><button type="button" class="btn btn-info "
						data-toggle="modal" data-target="{{'#myModalCP'.$LC->getId()}}">Show</button></td>

				<td align="center"><button type="button" class="btn btn-info "
						data-toggle="modal" data-target="{{'#myModalUpCP'.$LC->getId()}}">Update</button></td>



				<div class="modal fade" id="{{'myModalCP'.$LC->getId()}}"
					role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">Update</div>

							<div class="modal-body">
								<h4>
									<b>Finalita:</b>
								</h4>
								<p>{{$LC->Finalita_T}}</p>
								<br>
								<h4>
									<b>Informativa:</b>
								</h4>


								<p>{{$LC->Informativa}}</p>

							</div>
						</div>
					</div>
				</div>




				<div class="modal fade" id="{{'myModalUpCP'.$LC->getId()}}"
					role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							{{ Form::open(array('url' =>
							'/administration/updateTrattamentiCP')) }} {{ csrf_field() }}
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Aggiorna trattamento {{$LC->Nome_T}}</h4>
							</div>
							<div class="modal-body">
							
										
									<h4><b>Nome:</b></h4>
									{{Form::text('Nome_TCP'.$LC->getId(), $LC->Nome_T)}}	
								
									{{Form::hidden('TrattamentoIDCP'.$LC->getId(), $LC->getId())}} <h4><b>Finalita:</b></h4>

									{{Form::textarea('Finalita_TCP'.$LC->getId(), $LC->Finalita_T)}} <br><h4> <b>Informativa:</b></h4>

 <br>

									{{Form::textarea('Informativa_TCP'.$LC->getId(), $LC->Informativa)}}
									
								
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default"
									data-dismiss="modal">Chiudi</button>
								{{ Form::submit('Salva', ['class' => 'btn btn-primary'])}}
							</div>
							{{ Form::close() }}
							
						</div>

					</div>
				</div>



			</tr>
			@endforeach
		</table>

		<hr>








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

function myFunction1() {
	  var input, filter, table, tr, td, i;
	  input = document.getElementById("myInput1");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("tableCP");
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
