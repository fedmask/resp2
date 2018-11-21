<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
@include('includes.template_head')
<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



</head>

<body>
	<!-- Include il template dell'header -->
	@include('pages.Administration.template_header_Amm')


	<!-- Include il template del menu laterale sinistro -->
	@include('pages.Administration.template_menu_Amm')

	<!-- Carica il contenuto delle sezioni principali -->
	@yield('content')


</body>

</html>