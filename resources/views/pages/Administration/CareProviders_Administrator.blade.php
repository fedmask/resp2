 @extends('pages.Administration.app_Admin') @section('content')



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

#myTable {
	border-collapse: collapse;
	width: 50%;
	border: 1px solid #ddd;
	font-size: 12px;
}

#myTable th, #myTable td {
	text-align: left;
	padding: 12px;
}

#myTable tr {
	border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
	background-color: #f1f1f1;
}

th, td {
	text-align: left;
	padding: 8px;
}

#myTable1 {
	border-collapse: collapse;
	width: 50%;
	border: 1px solid #ddd;
	font-size: 12px;
}

#myTable1 th, #myTable1 td {
	text-align: left;
	padding: 12px;
}

#myTable1 tr {
	border-bottom: 1px solid #ddd;
}

#myTable1 tr.header, #myTable1 tr:hover {
	background-color: #f1f1f1;
}

#myTable1 th.header {
	background-color: #f1f1f1;
}

th, td {
	text-align: left;
	padding: 8px;
}

#myInput1 {
	background-image: url('/css/searchicon.png');
	background-position: 10px 10px;
	background-repeat: no-repeat;
	width: 50%;
	font-size: 12px;
	padding: 12px 20px 12px 40px;
	border: 1px solid #ddd;
	margin-bottom: 12px;
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


		<form class="form-horizontal"
			action="{{action('AdministratorController@updateCppStatus')}}"
			method="post">
			{{ Form::open(array('url' => '/administration/CareProviders/Update'))
			}} {{ csrf_field() }}
			<h1>Gestione Care Providers</h1>

			<br> <input type="text" id="myInput" onkeyup="myFunction()"
				placeholder="Ricerca per Nome..." title="Inserisci un nome">
			<div style="overflow-x: auto;">
				<table id="myTable" style="width: 100%;">
					<tr style="font-size: 12" ; class="header">
						<th style="width: 40%;">#ID</th>
						<th style="width: 40%;">Nome e Cognome</th>
						<th style="width: 40%;">E-Mail</th>

						<th>Data Nascita</th>
						<th>Codice Fiscale</th>
						<th>Sesso</th>
						<th>Specializzazioni</th>

						<th>N. iscrizione albo</th>
						<th>Localita' iscrizione</th>
						<th>Lingua</th>

						<th>Stato</th>

					</tr>
					@foreach($CppArray as $Cpp)

					<tr>
						<td>{{$Cpp[0]}}</td>
						<td>{{$Cpp[1]}}</td>
						<td>{{$Cpp[2]}}</td>
						<td>{{$Cpp[3]}}</td>
						<td>{{$Cpp[4]}}</td>
						<td>{{$Cpp[5]}}</td>
						<td>{{$Cpp[6]}}</td>
						<td>{{$Cpp[8]}}</td>
						<td>{{$Cpp[9]}}</td>
						<td>{{$Cpp[10]}}</td> @if($Cpp[11] == 'true')
						<td><label class="container">Non Convalidato <input type="radio"
								checked="checked" name="{{'check'.$Cpp[0]}}" value="Disattivo">
								<span class="checkmark"></span>
						</label> <label class="container">Convalidato <input type="radio"
								name="{{'check'.$Cpp[0]}}" value="Attivo"> <span
								class="checkmark"></span>
						</label></td> @else
						<td><label class="container">Non Convalidato <input type="radio"
								name="{{'check'.$Cpp[0]}}" value="Disattivo"> <span
								class="checkmark"></span>
						</label> <label class="container">Convalidato <input type="radio"
								checked="checked" name="{{'check'.$Cpp[0]}}" value="Attivo"> <span
								class="checkmark"></span>
						</label></td> @endif



					</tr>
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

		<hr>

		<br>

		<h2>Specializzazioni Care Provider</h2>
		<input type="text" id="myInput1" onkeyup="myFunction1()" style="width: 100%;"
			placeholder="Ricerca per Nome..." title="Inserisci un nome">


		<table id="myTable1" style="width: 100%;">
			<tr  class="header">
			<th ">#ID</th>
			<th >Nome e Cognome</th>
			<th >Codice Specializzazione</th>
			<th >Descrizione Specializzazione</th>

			</tr>

			@foreach($CppArray as $Cpp)


			<tr>

				@for($i =0; $i < count($Cpp[7]); $i++)


				<td>{{$Cpp[0]}}</td>
				<td>{{$Cpp[1]}}</td>

				<td>{{($Cpp[7])[$i]['Code']}}</td>


				<td>{{($Cpp[7])[$i]['Descrption']}}</td>

				</th> @endfor


			</tr>
			@endforeach
		</table>
	</div>
</div>
</div>
</div>
<script>
function myFunction1() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput1");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable1");
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

function myFunction() {
	  var input, filter, table, tr, td, i;
	  input = document.getElementById("myInput");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("myTable");
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
