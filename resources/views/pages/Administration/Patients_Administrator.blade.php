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

		<table id="tableP" style="overflow-x: auto;>
			<tr   
			
			
			class="header">
			<th>Cognome</th>
			<th>Nome</th>
			<th>Codice Fiscale</th>
			<th>Data di nascita</th>
			<th>Sesso</th>
			<th>Città di nascita</th>

			<th>Indirizzo</th>
			<th>Telefono</th>
			<th>E-mail</th>


			</tr>

			@foreach($Patients as $current_user)


			<tr>



				<td>{{$current_user->getSurname()}}</td>
				<td>{{$current_user->getName()}}</td>

				<td>{{$current_user->getFiscalCode()}}</td>


				<td>{{date('d/m/y', strtotime($current_user->getBirthdayDate()))}}</td>
				<td>{{$current_user->getGender()}}</td>
				<td>{{$current_user->getCountryName()}}</td>
				<td>{{$current_user->getAddress()}}</td>
				<td>{{$current_user->getPhone()}}</td>
				<td>{{$current_user->getMail()}}</td>





			</tr>
			@endforeach
		</table>




	</div>
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








<!--END PAGE CONTENT -->
@endsection
