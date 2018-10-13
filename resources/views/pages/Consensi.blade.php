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

				<form data-toggle="validator" data-disable="false" role="form">
					<div class="container">

						<div class="well">

							@foreach($listaTrattamenti as $Tr)
							<h2>{{$Tr['Nome_T']}}</h2>
							<p>{{$Tr['Informativa']}}</p>

							<label class="container">Acconsento <input type="checkbox"
								name="check" .{{$Tr['Id_Trattamento']}} value=1 >
								<span class="checkmark"></span> @endforeach
							</label>



						</div>
						<div align="center" onclick="refresh()">
							<button class="btn btn-info" onclick="window.location.href='/'"">Salva</button>
						</div>
					</div>

				</form>
			
{!! Form::open(array('url' => 'foo/bar')) !!} 

{!! Form::label('Test-1') !!} {!! Form::checkbox('ch[]', 'value-1', false); !!} 

{!! Form::label('Test-2') !!} {!! Form::checkbox('ch[]', 'value-2', false); !!} 

{!! Form::submit('Click Me!') !!}
{!! Form::close() !!}
				
			</div>


		</div>




	</div>
</div>

<!--END PAGE CONTENT -->

@endsection
