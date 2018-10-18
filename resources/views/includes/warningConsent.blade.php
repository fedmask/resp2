@extends('layouts.app') @extends('includes.template_head')

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<div class="container">

<div class="alert alert-warning">
    <strong>Attenzione!</strong> Questa pagina non è accesibile previa accettazione trattamento: {{$trattamento}}.
  </div>



</div>


@endsection
