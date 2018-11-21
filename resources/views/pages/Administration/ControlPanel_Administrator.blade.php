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
<h1>Pannello di Controllo</h1>
<!-- @TODO Bisogna completare questa sezione  -->
<br><br>


		<div class="col-lg-12">
			<br> <br> 
<h3>Accessi Log</h3>
<div class="panel panel-warning">
					<div class="panel-body">
						
			<table style="font-size: 12"
				; class="table table-striped table-bordered table-hover">
				<tr style="font-size: 14">
					<th>#ID_Audit</th>
					<th>Nome Attivita'</th>
					<th align="center">Indirizzo IP</th>
					<th>#ID_Visitante</th>
					<th>Nome_Utente</th>
					<th>Data</th>
				</tr>

				<!-- Ciclo sui Consensi -->
				@foreach($LogsArray as $Log)
				<tr>
					<td align="center">{{$Log[0]}}</td>
					<td><b>{{$Log[1]}}</b></td>
					<td>{{$Log[2]}}</td>
					<td>{{$Log[3]}}</td>
					<td>{{$Log[4]}}</td>
					<td>{{$Log[5]}}</td>
				</tr>
				@endforeach
			</table>
		</div>
</div>
</div>

	</div>
</div>




<!--END PAGE CONTENT -->
@endsection
