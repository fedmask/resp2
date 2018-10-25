 @extends('pages.Administration.app_Admin') @section('content')



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
		width: 140%;
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


</style>


/* END CONTENT STYLES */
</style>
<!-- Use scripts for Modal -->
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!--PAGE CONTENT -->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">




<div id="content">
	<div class="inner" style="min-height: 1200px;">
		<br>
		<h1>Gestione Care Providers</h1>

		<br> <input type="text" id="myInput" onkeyup="myFunction()"
			placeholder="Ricerca per Nome..." title="Inserisci un nome">
		<div style="overflow-x: auto;">
			<table id="myTable">
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

					<td>{{$Cpp[7]}}</td>
					<td>{{$Cpp[8]}}</td>
					<td>{{$Cpp[9]}}</td>
					<td>{{$Cpp[10]}}</td>
				

				</tr>
				@endforeach
			</table>
		</div>
		<script>
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



	</div>
</div>




<!--END PAGE CONTENT -->
@endsection
