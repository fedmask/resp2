<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Fascicolo Sanitario Elettronico Multimediale">
	<meta name="author" content="FSEM.EU">

    <title>RESP | Registrazione Care Provider</title>

    <!-- Bootstrap Core CSS -->
    <link href="/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Datepicker CSS -->
	<link  href="/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
	
	<!-- Custom Scrollbars -->
	<link  href="/plugins/custom_scrollbar/jquery.mCustomScrollbar.css"	rel="stylesheet"  />

	<!-- Typeahead plugin -->
	<link href="/css/typeahead.css" rel="stylesheet">
		
	<!-- File input plugin for uploading -->
	<link href="/plugins/fileInput_kartik/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
		
    <!-- Custom CSS -->
    <link href="/css/scrolling-nav.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/yamm.css" />
	
	<!-- Custom registration -->
	<link  href="/css/registerCustom.css"	rel="stylesheet"  />

     

    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>

    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="/plugins/Font-Awesome/css/font-awesome.css" />


	<!-- PAGE LEVEL STYLES -->
    <link href="/plugins/jquery-steps-master/demo/css/normalize.css" rel="stylesheet" />
    <link href="/plugins/jquery-steps-master/demo/css/wizardMain.css" rel="stylesheet" />
    <link href="/plugins/jquery-steps-master/demo/css/jquery.steps.css" rel="stylesheet" />    

    <style type="text/css">

		#register-form .content {

			min-height: 100px;

		}

		#register-form .content > .body {

			width: 100%;

			height: auto;

			padding: 15px;

			position: relative;

		}

	</style>   
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
			</div> <!-- navbar-header page- scroll-->
			
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
	</nav><!--navbar navbar-default navbar-fixed-top yamm -->
	
	<!--REGISTER SECTION-->

	<section id="register" class="register-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
						
					<center>
					<section id = "head">
						<img src = "/img/IconCareProvider.png" alt = "CPPicon"></img>  
					</section>	
                        <br>   
							<h1>Registrazione Care Provider</h1>
                    </center>
                        <br><br>           
						<!--TO DO-->
						<!--register1 è modificato rispetto a register, funzionante al 5/7/2015-->
						<form id="example-advanced-form" action="formscripts/submitRegister1.php" method="POST" class="form-horizontal">

                            <h3>Account</h3>
                            <fieldset>
									<!--username-->
                                    <div class="form-group">
                                        <label for="userName" class="control-label col-lg-2">User name *
										</label>
                                        <div class="col-lg-3"><input id="userName" name="userName" type="text"  class="form-control">
										</div>
									</div>
                                   
									<!--e-mail-->
                                    <div class="form-group">
										<label for="email" class="control-label col-lg-2">Email-(PEC) *
										</label>
                                        <div class="col-lg-3"><input id="email" name="email" type="email" class="form-control">
										</div>
										<label for="confirmEmail" class="control-label col-lg-3">Conferma Email *
										</label>
                                        <div class="col-lg-3"><input id="confirmEmail" name="confirmEmail" type="email"  class="form-control">
										</div>
                                    </div>

                                    
									<!--password-->
                                    <div class="form-group">
                                        <label for="password" class="control-label col-lg-2">Password *
										</label>
										<div class="col-lg-3">
											<input id="password" name="password" type="password" class="form-control" placeholder = "almeno 8 caratteri tra cui una cifra">
										</div>
										 <label for="confirmPassword" class="control-label col-lg-3">Conferma Password *
										 </label>
										<div class="col-lg-3">
											<input id="confirmPassword" name="confirmPassword" type="password" class="form-control">
										</div>
                                    </div>
									
									<!--ordine--da rendere obbligatori>-->
                                    <div class="form-group">
                                        <label for="NumOrdine" class="control-label col-lg-2">N°  iscrizione  *
										</label>
                                        <div class="col-lg-3"><input id="N_Ordine" name="n_ordine" type="text" class="form-control" placeholder = "numero di iscrizione ordine">
										</div>
										 <label for="provOrdine" class="control-label col-lg-3">Provincia / Regione*
										 </label>
										<div class="col-lg-3">
											<input id="ProvOrdine" name="provordine" type="text" class="form-control" placeholder = "provincia ordine di iscrizione">
										</div>
                                    </div>
										<br>
									
									<div class="form-group">
										<label for="tipoSpecializz" class="control-label col-lg-2">Attivit&agrave svolta *
										</label>
                                        <div class="col-lg-4">
                                       		<select name="tipoSpecializz" id="tipoSpecializz" class="form-control" >
                                                <option value="">Scegli la tua attivit&agrave </option>
											</select>
										</div>
									</div>
									<br>
									<!--
									 <div class="form-group">
                                         <label class="control-label col-lg-4">Tipo registrazione *
										 </label>
										<div class="col-lg-4">
											<label class="radio-inline">
												<input type="radio"  name="tiporegistrazione" id="PersonaF" value="Persona Fisica" >Persona Fisica
											</label>
											<label class="radio-inline">
												<input type="radio"  name="tiporegistrazione" id="PersonaG" value="Persona Giuridica" >Persona Giuridica
											</label>
										</div>
                                    </div>
										per permettere la registraione di strutture	-->										
											
									<!--<p class="pull-right">(*) Campi obbligatori</p>-->

                          
							
							 <!-- FORM CARE PROVIDER PERSONA GIURIDICA -->
							<!--
                         <div id="profiloDitta" hidden> 
							<center><h3>Profilo ditta</h3></center>
							<fieldset>
                            	<div class="form-group">
                                    <label for="ragioneSociale" class="control-label col-lg-4">Ragione Sociale *
									</label>
									 <div class="col-lg-4"><input id="ragioneSociale" name="ragioneSociale" type="text"  class="form-control" disabled>
									 </div>
								</div>

                                <div class="form-group">
									<label for="tipoDitta" class="control-label col-lg-4">Tipologia Struttura *
									</label>
									<div class="col-lg-4">
										<select name="tipoDitta" id="tipoDitta" class="form-control" disabled>
											 <option value="">Scegli una tipologia</option>
										</select>
									</div>
                                </div>

                                <div class="form-group">

                                        <label class="control-label col-lg-4">Sede Legale *</label>

                                        <div class="col-lg-4"><input id="viaSedeLegale" name="viaSedeLegale" type="text"  class="form-control" placeholder="Via" disabled></div>

                                </div>

                                <div class="form-group">
									<label class="control-label col-lg-4">
									</label>
									 <div class="col-lg-4"><input id="cittaSedeLegale" name="cittaSedeLegale" type="text"  class="form-control" placeholder="Città" disabled>
									 </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">
									</label>
                                    <div class="col-lg-4"><input id="capSedeLegale" name="capSedeLegale" type="text"  class="form-control" placeholder="CAP" disabled>
									</div>
                                </div>

                                <div class="form-group">
                                        <label for="CFditta" class="control-label col-lg-4">Codice Fiscale *
										</label>
                                        <div class="col-lg-4"><input id="CFditta" name="CFditta" type="text"  class="form-control" disabled>
										</div>
                                </div>

                                <div class="form-group">
                                    <label for="pIVAditta" class="control-label col-lg-4">Partita IVA *
									</label>
                                    <div class="col-lg-4"><input id="pIVAditta" name="pIVAditta" type="text"  class="form-control" disabled>
									</div>
                                </div>

                                <div class="form-group">
                                    <label for="PECditta" class="control-label col-lg-4">PEC&nbsp;&nbsp;
									</label>
                                    <div class="col-lg-4"><input id="PECditta" name="PECditta" type="email"  class="form-control" disabled>
									</div>
                                </div>

                                <div class="form-group">
                                    <label for="TELditta" class="control-label col-lg-4">Telefono&nbsp;&nbsp;
									</label>
                                    <div class="col-lg-4"><input id="TELditta" name="TELditta" type="text"  class="form-control" disabled>
									</div>
                                </div>

                                <div class="form-group">
                                    <label for="FAXditta" class="control-label col-lg-4">Fax&nbsp;&nbsp;
									</label>
                                    <div class="col-lg-4"><input id="FAXditta" name="FAXditta" type="text"  class="form-control" disabled>
									</div>
                                </div> 
								<br><br>

								<center><h3>Profilo Legale Rappresentante / Responsabile</h3></center>
                            	<div class="form-group">
                                    <label for="respCognome" class="control-label col-lg-4">Cognome *
									</label>
                                        <div class="col-lg-4"><input id="respCognome" name="respCognome" type="text"  class="form-control" disabled>
										</div>
                                </div>

                                <div class="form-group">
                                    <label for="respNome" class="control-label col-lg-4">Nome *
									</label>
                                    <div class="col-lg-4"><input id="respNome" name="respNome" type="text"  class="form-control" disabled>
									</div>
                                </div>

                            	<div class="form-group">
                                    <label for="respCF" class="control-label col-lg-4">Codice Fiscale *
									</label>
									<div class="col-lg-4"><input id="respCF" name="respCF" type="text"  class="form-control" disabled>
									</div>
                                </div>

                            

                            </fieldset>
							</div>
							<!---->
                         
                            							
								<div class="form-group" >
                                    <label for="surname" class="control-label col-lg-2">Cognome *
									</label>
                                    <div class="col-lg-3"><input  id="surname" name="surname" type="text"  class="form-control">
									</div>									
									<label for="name" class="control-label col-lg-3">Nome *
									</label>
                                    <div class="col-lg-3"><input  id="name" name="name" type="text"  class="form-control">
									</div>
								</div>
								
								<div class="form-group">
                                    <label for="gender" class="control-label col-lg-2">Sesso *
									</label>	
									<div class="col-lg-3">
                                        <label class="radio-inline">												
											<input  type="radio"  name="gender" id="genderM" value="M">M													
                                        </label>
                                        <label class="radio-inline">
                                            <input  type="radio"  name="gender" id="genderF" value="F">F
                                        </label>
								    </div>
									 <label for="CF" class="control-label col-lg-3">Codice Fiscale *
									 </label>
									 <div class="col-lg-3"><input  id="CF" name="CF" type="text" data-mask="wwww-wwww-wwww-wwww"  class="form-control">
									 </div>
                                </div>
								
								<div class="form-group">
                                    <label for="birthCity" class="control-label col-lg-2">Comune di nascita *
									</label>
                                    <div class="col-lg-3"><input   id="birthCity" name="birthCity" type="text"  class="typeahead form-control">
									</div>
									<label for="birthDate" class="control-label col-lg-3">Data di nascita *
									</label>
									<div class="col-lg-3"><input  id="birthDate" name="birthDate" type="text" class="form-control" placeholder="Inserisci gg-mm-aaaa" >
									</div>
                                </div>							
								
								<div class="form-group">
                                        <label for="livingCity" class="control-label col-lg-2">Comune di residenza *
										</label>
										<div class="col-lg-3"><input  id="livingCity" name="livingCity" type="text"  class="typeahead form-control">
										</div>
										<label for="address" class="control-label col-lg-3">Via/Corso/Piazza *
										</label>
                                        <div class="col-lg-3"><input  id="address" name="address" type="text"  class="form-control">
										</div>							
								</div>
								
							
								<div class="form-group">	
                                    <label class="control-label col-lg-2">CAP
									</label>
                                    <div class="col-lg-3"><input id="capSedePF" name="capSedePF" type="text"  placeholder="CAP" class="form-control" >
									</div>
									<label for="telephone" class="control-label col-lg-3">Recapito telefonico *
									</label>
                                    <div class="col-lg-3"><input  id="telephone" name="telephone" type="tel" class="form-control">
									</div>								
								</div>
								<br>
								<div class="form-group">
									<label class="control-label col-lg-2" >Altre informazioni
									</label>
									<textarea id="reperibilita" name="reperibilita"  cols = "50" rows = "4"  placeholder="ulteriori informazioni relative alla propria attivit&agrave ">
									</textarea>
								</div>

							<!--	<div class="form-group">-->
								<div class="col-lg-3">
									<br><br><br><br>
									<label for="profilePic" class="control-label">Carica una immagine per il tuo profilo.(Opzionale)
									</label>
								</div>								
								<div class="col-lg-4">									
									</br></br>
									<input id="profilePic"  type="file" class="file" data-preview-file-type="text" accept="image/*" name="profilePic" value="null">
									<input id="profilePicHidden" name="profilePicHidden" class="form-control" value="null">
								</div>
								<p class="pull-right">(*) Campi obbligatori</p>
                            </fieldset>

                            <h3>Termini e condizioni</h3>
							<fieldset>
                            	<div class="col-lg-10 col-lg-offset-1">
                                    <iframe src="/informative/consensoInformatoFsem.euCP.html" class="col-lg-12" height="1000">
									</iframe>
                                </div>
                            	<div class="form-group">
                                    <div class="col-lg-8 centered">
                                        <input type="checkbox"  name="accettaTermini" id="accettaTermini" >
                                        <label class="control-label" for="accettaTermini"><h3>&nbsp;&nbsp; Accetto i termini e le condizioni *</h3>
										</label>
									</div>
								</div>

                                  <p class="pull-right">(*) Campi obbligatori</p>
							</fieldset>
                        </form>
                </div>
            </div>
        </div> <!--container outer-->
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
    <script src="/js/formscripts/registerCP_fg.js"></script>
	
		<!-- File input for uploading -->
	<script src="/plugins/fileInput_kartik/js/fileinput.min.js"></script>
	<script src="/plugins/fileInput_kartik/js/fileinput_locale_it.js"></script>
	
	<!-- Custom Scrollbars -->
	<!--<script src="assets/plugins/custom_scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>-->

</body>

</html>

