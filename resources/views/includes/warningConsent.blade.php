@extends('layouts.app') @extends('includes.template_head')
@section('content')
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<div id="content">
	<div class="inner" style="min-height: 1200px;">
		<div class="row">
			<div class="col-lg-12">
				<br> <br> <br>

				<div class="w3-container">
					<div class="alert alert-warning">
						 <strong style="font-size: 16">Attenzione!</strong>
						Dovresti acconsentire al trattamento prima di poter accedere alla sezione<b> {{$trattamento}}</b>! <a href="/consent" class="alert-link">Clicca Qui</a> per
						accedere alla sezione Consensi.
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection
