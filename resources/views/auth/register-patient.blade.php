<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Fascicolo Sanitario Elettronico Multimediale">
	<meta name="author" content="FSEM.EU">
	<title>RESP | Registrazione Paziente</title>

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

			<div class="row">

				<div class="col-lg-12">



					<center>

						<section id="head">

							<img src="/img/IconPatient.png" alt="pzicon"></img>

						</section>
						<br>

						<h1>Registrazione paziente</h1>

					</center>

					<br>

					<br>
					<form id="" action="/register/patient" method="POST" class="form-horizontal">
					{{ csrf_field() }}
						<h3>Account</h3>
						<fieldset>
							<div class="form-group">
								<label for="userName" class="control-label col-lg-3">Username *</label>
								<div class="col-lg-3"><input id="userName" name="username" type="text" class="form-control">
								</div>
								<input id="role" name="role"></input>
							</div>



							<div class="form-group">

								<label for="email" class="control-label col-lg-3">Email *</label>

								<div class="col-lg-3"><input id="email" name="email" type="email" class="form-control">
								</div>

								<label for="confirmEmail" class="control-label col-lg-3">Conferma Email *</label>

								<div class="col-lg-3"><input id="confirmEmail" name="confirmEmail" type="email" class="form-control">
								</div>

							</div>



							<div class="form-group">

								<label for="password" class="control-label col-lg-3">Password *</label>

								<div class="col-lg-3"><input id="password" name="password" type="password" class="form-control" placeholder="almeno 8 caratteri tra cui una cifra">
								</div>

								<label for="confirmPassword" class="control-label col-lg-3">Conferma Password *</label>

								<div class="col-lg-3">
									<input id="confirmPassword" name="confirmPassword" type="password" class="form-control">
								</div>
							</div>
							<div class="form-group">

								<label for="surname" class="control-label col-lg-3">Cognome *</label>

								<div class="col-lg-3"><input id="surname" name="surname" type="text" class="form-control">
								</div>

								<label for="name" class="control-label col-lg-3">Nome *</label>

								<div class="col-lg-3"><input id="name" name="name" type="text" class="form-control">
								</div>

							</div>

							<div class="form-group">

								<label for="gender" class="control-label col-lg-3">Sesso *</label>

								<div class="col-lg-3">

									<label class="radio-inline">
												
													<input  type="radio"  name="gender" id="genderM" value="M">M
													
                                                </label>

								

									<label class="radio-inline">

                                                    <input  type="radio"  name="gender" id="genderF" value="F">F

                                                </label>

								

								</div>
								<label for="CF" class="control-label col-lg-3">Codice Fiscale *</label>

								<div class="col-lg-3"><input id="CF" name="CF" type="text" data-mask="wwww-wwww-wwww-wwww" class="form-control">
								</div>


							</div>


							<div class="form-group">

								<label for="birthCity" class="control-label col-lg-3">Comune di nascita *</label>

								<div class="col-lg-3"><input id="birthCity" name="birthCity" type="text" class="typeahead form-control">
								</div>

								<label for="birthDate" class="control-label col-lg-3">Data di nascita *</label>

								<div class="col-lg-3"><input id="birthDate" name="birthDate" type="text" class="form-control" placeholder="Inserisci  gg-mm-aaaa ">
								</div>

							</div>


							<div class="form-group">

								<label for="livingCity" class="control-label col-lg-3">Comune di residenza *</label>
								<div class="col-lg-3"><input id="livingCity" name="livingCity" type="text" class="typeahead form-control">
								</div>

								<label for="address" class="control-label col-lg-3">Via/Corso/Piazza *</label>

								<div class="col-lg-3"><input id="address" name="address" type="text" class="form-control">
								</div>

							</div>

							<div class="form-group">

								<label for="telephone" class="control-label col-lg-3">Recapito telefonico *</label>

								<div class="col-lg-3">

									<input id="telephone" name="telephone" type="tel" class="form-control">
						
								</div>



							</div>
							<div class="form-group dropup">

								<label for="bloodType" class="control-label col-lg-3">Gruppo sanguigno </label>

								<div class="col-lg-3">

									<button name="bloodTypeDrop" class="btn btn-default dropdown-toggle" type="button" id="bloodTypeDrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										<span class="caret"></span>
										</button>
								

									<ul id="dropupMenu" class="dropdown-menu" role="menu" aria-labelledby="bloodTypeDrop">
										<li role="presentation"><a id="0-" role="menuitem" tabindex="-1">0 negativo</a>
										</li>
										<li role="presentation"><a id="0+" role="menuitem" tabindex="-1">0 positivo</a>
										</li>
										<li role="presentation"><a id="A-" role="menuitem" tabindex="-1">A negativo</a>
										</li>
										<li role="presentation"><a id="A+" role="menuitem" tabindex="-1">A positivo</a>
										</li>
										<li role="presentation"><a id="B-" role="menuitem" tabindex="-1">B negativo</a>
										</li>
										<li role="presentation"><a id="B+" role="menuitem" tabindex="-1">B positivo</a>
										</li>
										<li role="presentation"><a id="AB-" role="menuitem" tabindex="-1">AB negativo</a>
										</li>
										<li role="presentation"><a id="AB+" role="menuitem" tabindex="-1">AB positivo</a>
										</li>
									</ul>

									<input id="bloodType" name="bloodType" class="form-control" value="-1">

								</div>


								<label for="maritalStatus" class="control-label col-lg-3">Stato Matrimoniale </label>

								<div class="col-lg-3">

									<select class="form-control" name="maritalStatus" id="maritalStatus">
										<option value="A">Annullato</option>
										<option value="D">Divorziato</option>
										<option value="I">Interlocutorio</option>
										<option value="L">Legalmente Separato</option>
										<option value="M">Sposato</option>
										<option value="P">Poligamo</option>
										<option value="S">Mai Sposato</option>
										<option value="T">Convivente</option>
										<option value="W">Vedovo</option>
									</select>
								</div>
							</div>
							<div class="form-group">

								<label for="shareData" class="control-label col-lg-3">Condividere i dati con i medici</label>

								<div class="col-lg-3">

									<label class="radio-inline">
												
													<input  type="radio"  name="shareData" id="shareY" value="Y">Si
													
                                                </label>

								

									<label class="radio-inline">

                                                    <input  type="radio"  name="shareData" id="shareN" value="N" checked>No

                                                </label>

								

								</div>


							</div>



							<div class="form-group">
								<div class="col-lg-4">
									</br>
									</br>
									</br>
									</br>
									</br>
									<label for="profilePic" class="control-label">Carica una immagine per il tuo profilo.(Opzionale)</label>
								</div>

								<div class="col-lg-4">
									</br>
									</br>

									<input id="profilePic" type="file" class="file" data-preview-file-type="text" accept="image/*" name="profilePic" value="null">
									<input id="profilePicHidden" name="profilePicHidden" class="form-control" value="null">

								</div>
							</div>
							<p class="pull-right">(*) Campi obbligatori</p>
							<button type="submit">Registrazione</button>
						</fieldset>



						<h3>Termini e condizioni</h3>

						<fieldset>

							<article>

								<center id="consensus">

								</center>

							</article>

							<div class="form-group">
								<div class="col-lg-4">
									<label for="acceptTerms">Accetto i termini e le condizioni.</label>
									<input id="acceptTerms" name="acceptTerms" type="checkbox">
								</div>
							</div>

						</fieldset>

					</form>

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