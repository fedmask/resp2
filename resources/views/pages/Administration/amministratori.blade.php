<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
@include('includes.template_head')
@include('pages.Administration.template_header_amm')
</head>

<body>

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
	<div align="center">


		<h1>Ciao funziona</h1>

		<a href="{{ route('logout') }}"
			onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
			class="icon-signout"></i> Logout </a>

		<form id="logout-form" action="{{ route('logout') }}" method="POST"
			style="display: none;">{{ csrf_field() }}</form>
	</div>


	<!--END PAGE CONTENT -->

</body>

</html>
