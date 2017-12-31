<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
	@include('includes.template_head')
</head>

<body>
	<!-- Include il template dell'header -->
	@include('includes.template_header')

	<!-- Include il template del menu laterale sinistro -->
	@include('includes.template_menu')
	
	<!-- Carica il contenuto delle sezioni principali -->
	@yield('content')
	
	<!-- Include la sidebar destra -->
	@include('includes.template_sidebar')
	
	<!-- Include il template del footer -->
	@include('includes.template_footer')
	
</body>

</html>