<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Fascicolo Sanitario Elettronico Multimediale">
	<meta name="author" content="FSEM.EU">
	<title>RESP | Registrazione</title>

	<!-- Bootstrap Core CSS -->
	<link href="/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Datepicker CSS -->
	<link href="/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">

	<!-- Custom Scrollbars -->
	<link href="/plugins/custom_scrollbar/jquery.mCustomScrollbar.css" rel="stylesheet"/>

	<!-- Typeahead plugin -->
	<link href="/css/typeahead.css" rel="stylesheet">

	<!-- File input plugin for uploading -->
	<link href="/plugins/fileInput_kartik/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css"/>

	<!-- Custom CSS -->
	<link href="/css/scrolling-nav.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/yamm.css"/>

	<!-- Custom registration -->
	<link href="/css/registerCustom.css" rel="stylesheet"/>

	<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/plugins/Font-Awesome/css/font-awesome.css"/>



	<!-- PAGE LEVEL STYLES -->
	<link href="/plugins/jquery-steps-master/demo/css/normalize.css" rel="stylesheet"/>
	<link href="/plugins/jquery-steps-master/demo/css/wizardMain.css" rel="stylesheet"/>
	<link href="/plugins/jquery-steps-master/demo/css/jquery.steps.css" rel="stylesheet"/>

	<!-- END PAGE LEVEL  STYLES -->

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>



<!-- The #page-top ID is part of the scrolling feature - the data-spy and data-target are part of the built-in Bootstrap scrollspy function -->



<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

	<!-- Navigation -->
	<nav class="navbar navbar-default navbar-fixed-top yamm" role="navigation">
		<div class="container">
			<div class="navbar-header page-scroll">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
			
				<a class="page-scroll pull-left" href="/home"><img src="/img/logo_icona.png" alt="" /></a>

				<a class="navbar-brand page-scroll" href="/home" style="color:#1d71b8">R E S P</a>

			</div>



			<!-- Collect the nav links, forms, and other content for toggling -->

			<div class="collapse navbar-collapse navbar-ex1-collapse ">

				<ul class="nav navbar-nav">

					<!-- Hidden li included to remove active class from about link when scrolled up past about section -->

					<li class="hidden">

						<a class="page-scroll" href="#page-top"></a>

					</li>

				</ul>

			</div>

			<!-- /.navbar-collapse -->

		</div>

		<!-- /.container -->

	</nav>

	<!--REGISTER SECTION-->

	<section id="register" class="register-section">
		<div class="container">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-6">
						<div class="well">
							<center><img src="/img/IconPatient.png" class="img-responsive"/>
							</center>
							<center>
								<h3>Paziente</h3>
							</center>
							<center>
								<p>Privati cittadini</p>
							</center>
							<a href="/register/patient" class="btn btn-success btn-block">Clicca qui per registrarti</a>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="well">
							<center><img src="/img/IconCareProvider.png" class="img-responsive"/>
							</center>
							<center>
								<h3>CareProvider</h3>
							</center>
							<center>
								<p>Strutture e personale sanitario</p>
							</center>
							<a href="/register/careprovider" class="btn btn-info btn-block">Clicca qui per registrarti</a>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>



	<!--FOOTER-->

	<div id="c">
		<div class="container">
			<p>copyright © RESP 2017</p>
		</div>
	</div>



	<!-- jQuery -->
	<script src="/js/jquery-2.0.3.min.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="/plugins/bootstrap/js/bootstrap.js"></script>


	<!-- Scrolling Nav JavaScript -->
	<script src="/js/jquery.easing.min.js"></script>
	<script src="/js/scrolling-nav.js"></script>



	<!-- Scrolling Nav JavaScript -->
	<script src="/plugins/jquery-validation-1.11.1/dist/jquery.validate.min.js"></script>
	<script src="/plugins/jquery-validation-1.11.1/localization/messages_it.js"></script>
	<script src="/js/formscripts/login.js"></script>



	<!-- Bootstrap Datepicker -->
	<script src="/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.it.min.js"></script>



	<!-- Jquery Autocomplete -->
	<script src="/plugins/autocomplete/typeahead.bundle.js"></script>



	<!-- Jasny input mask -->
	<script src="/plugins/jasny/js/jasny-bootstrap.js"></script>


	<!-- Wizard Scripts -->
	<script src="/plugins/jquery-steps-master/lib/jquery.cookie-1.3.1.js"></script>
	<script src="/plugins/jquery-steps-master/build/jquery.steps.js"></script>
	<script src="/js/formscripts/register.js"></script>


	<!-- File input for uploading -->
	<script src="/plugins/fileInput_kartik/js/fileinput.min.js"></script>
	<script src="/plugins/fileInput_kartik/js/fileinput_locale_it.js"></script>


	<!-- Custom Scrollbars -->
	<!--<script src="assets/plugins/custom_scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>-->
</body>

</html>