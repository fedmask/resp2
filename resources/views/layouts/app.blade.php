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
	
	@include('includes.template_sidebar')
	
	<!-- Include il template del footer -->
	@include('includes.template_footer')
	
	
	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/jquery-2.0.3.min.js') }}"></script>
	<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
	<script src="{{ asset('plugins/validationengine/js/jquery.validationEngine.js') }}"></script>
	<script src="{{ asset('plugins/validationengine/js/languages/jquery.validationEngine-it.js') }}"></script>
	<script src="{{ asset('plugins/jquery-validation-1.11.1/dist/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('plugins/jquery-validation-1.11.1/localization/messages_it.js') }}"></script>
	<script src="{{ asset('plugins/balloon/jquery.balloon.min.js') }}"></script>
	<script src="{{ asset('js/validationInit.js') }}"></script>
	<script src="{{ asset('js/formscripts/sendpatmail.js') }}"></script>
	<script src="{{ asset('js/formscripts/modRemindPw.js') }}"></script>
	<!-- <script src="{{ asset('js/formscripts/modpatinfo.js') }}"></script> -->
	<script src="{{ asset('js/formscripts/modpatpsw.js') }}"></script>
	<script src="{{ asset('js/formscripts/modpatgrsang.js') }}"></script>
	<!-- <script src="{{ asset('js/formscripts/modpatdonorg.js') }}"></script> -->
	<script src="{{ asset('js/formscripts/modpatcontemerg.js') }}"></script>
	<script src="{{ asset('js/notifications.js') }}"></script>
	<script src="{{ asset('plugins/autosize/jquery.autosize.min.js') }}"></script>
	<script src="{{ asset('js/formscripts/modanamnesifis.js') }}"></script>
	<script src="{{ asset('js/formscripts/modsicurezza.js') }}"></script>
	<script src="{{ asset('plugins/dataTables/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('plugins/dataTables/dataTables.bootstrap.js') }}"></script>
	<script src="{{ asset('js/formscripts/modanamnesipat.js') }}"></script>
	<script src="{{ asset('js/formscripts/modvaccinazioni.js') }}"></script>
	<script src="{{ asset('js/formscripts/modallergie.js') }}"></script>
	<script src="{{ asset('plugins/autocomplete/typeahead.bundle.js') }}"></script>
	<!-- TODO: dal footer del vecchio RESP imporatare gli script in base alla pagina caricata -->
</body>

</html>