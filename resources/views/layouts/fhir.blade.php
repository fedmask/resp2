<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
	@include('includes.template_head')
</head>

<body>
	<!-- Include il template dell'header -->
	@include('includes.fhir.template_header')

    @include('includes.fhir.template_menu')
    
    @yield('content')

    @include('includes.fhir.template_sidebar')


	
</body>

</html>