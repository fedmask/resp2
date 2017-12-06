<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
	@include('auth.layouts.registration_head')
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
	<!-- Include il template dell'header -->
	@include('auth.layouts.registration_header')
	
	<!-- Carica il contenuto delle sezioni principali -->
	@yield('register_content')
	
	
	<!-- Include il template del footer -->
	@include('auth.layouts.registration_footer')
	
</body>

</html>