<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Fascicolo Sanitario Elettronico Multimediale">
	<meta name="author" content="FSEM.EU">
	<!--tag per Norton safeweb-->
	<meta name="norton-safeweb-site-verification" content="968cfkk7w10gz46o40uds-pcd3ycz6eb9pwfxvjrdyb20jhdn2rqzvjt-52lriqobfa56j0k34oa7ftdrw5ar2zg6gawwlnpvemqsnqliv3zee16nrdjyo0agyu3bdr2"/>
	<link rel="shortcut icon" href="faviconFSEM.ico">

	<title>Registro Elettronico Sanitario Personale</title>

	<!-- Bootstrap Core CSS -->
	<link href="/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="/css/scrolling-nav.css" rel="stylesheet">
	<link href="/css/yamm.css" rel="stylesheet"/>

	<link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Raleway:400,300,700" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="/plugins/Font-Awesome/css/font-awesome.css"/>
	<link rel="stylesheet" href="/css/spin.css"/>

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
			
				<a class="page-scroll pull-left" href="#page-top"><img src="/img/logo_icona.png" alt="" />&nbsp;&nbsp;</a>
				<a class="navbar-brand page-scroll" href="#page-top" style="color:#1d71b8">R E S P</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse ">
				<ul class="nav navbar-nav">
					<!-- Hidden li included to remove active class from about link when scrolled up past about section -->
					<li class="hidden">
						<a class="page-scroll" href="#page-top"></a>
					</li>
					<li>
						<a class="page-scroll" href="#progetto">Il Progetto</a>
					</li>
					<li>
						<a class="page-scroll" href="#chisiamo">Chi Siamo</a>
					</li>
					<li>
						<a class="page-scroll" href="#contact">Contattaci</a>
					</li>
					<li>
						<a class="page-scroll" href="#link">Link</a>
					</li>
				</ul>
				<!-- LOGIN -->
				@auth
					<ul class="nav navbar-nav navbar-right">
						<li><a href="/home">Ciao, {{ Auth::user()->utente_nome }}</a></li>
					</ul>
				@else
				<ul class="nav navbar-nav navbar-right">

					<li class="page-scroll">
						<a href="#" data-toggle="modal" data-target="#registerModal"><i class="icon-edit"></i> Registrati</a>
					</li>

					<li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-user "></i> &nbsp;Accedi&nbsp; <i class="icon-chevron-down "></i></a>
						<ul class="dropdown-menu">
							<li>
								<div class="yamm-content">
									{{ Form::open(array('url' => 'login')) }}
									<form id="form_login">
										{{ Html::ul($errors->all(), array('class'=>'alert alert-danger errors')) }}
										<div class="form-group">
											{{ Form::text('utente_nome', Input::old('email'), array('placeholder' => 'Username', 'class'=>'form-control')) }}
										</div>
										<div class="form-group">
											{{ Form::password('utente_password', array('placeholder' => 'Password', 'class'=>'form-control')) }}
										</div>
										<div class="form-group">
											<label><input id="remember" nome="remember" type="checkbox">&nbsp;Ricordami</label>
										</div>
										<div class="form-group">
											{{ Form::submit('Login' , array('class' => 'btn btn-success btn-block')) }}
										</div>
										<div class="divider"></div>
									</form>
									{{ Form::close() }}
									<!--da implementare il file remind_pw.php recupero password-->
									<div class="form-group">
										<form action="remind_pw.php" method="post">
											<div class="form-group">
												<button type="submit" class="btn btn-warning btn-block">Recupera credenziali</button>
											</div>
										</form>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<li>
						<a class="btn btn-info" href="informative/guida.pdf">Guida </a>
					</li>
				</ul>
				@endauth
				<!-- FINE LOGIN -->
			</div>
			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container -->
	</nav>
	<!-- REGISTER MODAL -->
	<div class="col-lg-12">
		<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Registrati</h4>
					</div>
					<div class="modal-body">
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
			</div>
		</div>
	</div>

	<!-- FINE REGISTER MODAL -->

	<!-- Intro Section -->
	<section id="intro" class="intro-section">
		<div class="container">
			<div class="row">
				<div class="row centered">
					<div class="col-lg-12">
						<div class="col-lg-6">
							<center><img class="img-responsive" src="/img/logo_FSEM.png" alt="">
							</center>
						</div>
						<div class="col-lg-6">
							<center><img src="/img/home/patient-centered.png" class="img-responsive" style="height:250px"/>
							</center>
						</div>
					</div>
				</div>
				<div class="spin">
					<div id="spinnerContainer" class="spinner"></div>
				</div>

				<br>
				<br>
				<h1>Per una sanità  centrata sul paziente</h1>
				<br>
				<div class="row centered">
					<div class="col-lg-6" style="text-align:left">

						<p>Ci siamo proposti con alcuni colleghi medici ed informatici un obiettivo ambizioso: creare uno strumento che possa costituire la base per rendere sempre disponibili per ciascuno le proprie informazioni cliniche in modo tale che in qualsiasi momento ed ovunque dovesse averne bisogno siano prontamente utilizzabili e, fatto secondo noi altrettanto importante, divenga possibile assumere personalmente e liberamente le decisioni relative alla propria salute. Infatti alla base di ogni scelta libera deve esserci una informazione corretta e completa, ed uno dei piu' grandi paradossi attuali e' che proprio le scelte riguardanti la propria salute sono prese o affidandosi alle decisioni del medico cui ci si e' rivolti, ed in questo caso raramente si ottengono informazioni complete, o cercando autonomamente notizie da conoscenti e sempre piu' spesso sul WEB , caso in cui molto difficilmente saranno corrette. Oltre a supportare le scelte di ciascun cittadino , il registro permettera' a tutti gli operatori sanitari di avere immediatamente disponibili non solo i referti degli esami , ma gli esami stessi come l'immagine di una <a href="http://fsem.di.uniba.it/files/uploads/rx-torace.jpg">radiografia</a> precedente; un cardiologo potra' visionare direttamente i precedenti elettrocardiogrammi, gli ecocardiogrammi e le coronarografie del paziente che sta visitando, ricavando sicuramente informazioni più complete di quelle ottenute dal referto di colleghi, a volte con minore esperienza. La documentazione fotografica di <a href="http://fsem.di.uniba.it/files/uploads/2013-08-21 11.28.23.jpg">alterazioni patologiche </a>potrà  costituire uno strumento obiettivo per la valutazione dell'efficacia o meno delle terapie attuate, infine la registrazione dei <a href="http://fsem.di.uniba.it/files/uploads/cuore_f.wav">suoni cardiaci</a> e polmonari, ottenuta tramite un fonendoscopio elettronico, permettera' anche al medico che non ha precedentemente visitato il paziente di confrontare l'obiettivita' riscontrata con quella iniziale. Diverrà  possibile richiedere un secondo parere senza necessita' di spostamenti del paziente, ma semplicemente inviando il file di report. Vogliamo contribuire a fare in modo che i diversi interessi coinvolti in organizzazioni complesse come i Sistemi Sanitari siano subordinati all'interesse del paziente, evitando quanto sempre piu' spesso accade: che sia il paziente ad essere lo strumento degli interessi dei diversi operatori.</p>
					</div>
					<div class="col-lg-6">
						<img src="/img/archiviazione.png" alt="">
						<h3>Archiviazione</h3>
						<p>della storia clinica di ciascun individuo</p>
					</div>
					<div class="col-lg-6">
						<img src="/img/condivisione.png" alt="">
						<h3>Condivisione</h3>
						<p>delle informazioni con i propri Care Provider</p>
					</div>
					<div class="col-lg-6">
						<img src="/img/monitor.png" alt="">
						<h3>Supporto multimediale</h3>
						<p>Il registro puà² raccogliere numerosi formati multimediali per una archiviazione innovativa e completa</p>
					</div>
				</div>
			</div>
		</div>
		</div>
	</section>
	<hr>
	<!-- Progetto Section -->
	<section id="progetto" class="progetto-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1>Alcune schermate</h1>
					<br>
					<br>
					<div class="row">
						<div class="col-lg-8 col-lg-offset-2">
							<div id="carousel-example-generic" class="carousel slide">
								<!-- Indicators -->
								<ol class="carousel-indicators">
									<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
									<li data-target="#carousel-example-generic" data-slide-to="1"></li>
									<li data-target="#carousel-example-generic" data-slide-to="2"></li>
									<li data-target="#carousel-example-generic" data-slide-to="3"></li>
								</ol>
								<!-- Wrapper for slides -->
								<div class="carousel-inner">
									<div class="item active">
										<img src="/img/home/item-01.png" alt="">
									</div>
									<div class="item">
										<img src="/img/home/item-02.png" alt="">
									</div>
									<div class="item">
										<img src="/img/home/item-03.png" alt="">
									</div>
									<div class="item">
										<img src="/img/home/item-04.png" alt="">
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-lg-offset-3">
						</div>
					</div>

				</div>
				<div class="col-lg-12">
					<br>
					<br>
					<h2 class="centered">Una Medicina al passo coi tempi</h2>
					<br>
					<br>

					<p style="text-align:left">La tecnologia con la diffusione dei personal computer prima, di Internet dopo, ha innovato numerosissimi aspetti della vita quotidiana. Quasi nessuno oggi utilizza cartine stradali o consulta enciclopedie. E'cambiato il modo di programmare viaggi, prenotare aerei ed alberghi, gestire il proprio conto corrente. Si diffonde sempre di più l'acquisto di beni tramite Internet. Dall'ascolto della musica alla fotografia si potrebbe continuare con un lunghissimo elenco di ambiti in cui negli ultimi cinquant'anni il modo di operare si è totalmente modificato. Non è possibile dire altrettanto del modo in cui vengono gestite le informazioni mediche. Attualmente ciascun paziente custodisce personalmente i risultati degli esami effettuati, riportati in forma cartacea e recentemente in alcuni casi su cd, delle indagini diagnostiche svolte ambulatorialmente, mentre nessuna traccia resta dell'anamnesi e dell'obiettività  rilevata in occasione delle visite mediche, salvo i casi in cui un professionista particolarmente scrupoloso non rediga oltre ad una prescrizione terapeutica anche una sintesi dell'anamnesi raccolta e dell'obiettività  riscontrata. In caso di ricovero tutte le informazioni acquisite vengono riportate nella cartella clinica di cui il paziente puà² eventualmente chiedere una copia. Le attuali cartelle non hanno un indice che possa immediatamente far conoscere a chi le consulta quali esami clinici sono in esse contenuti e in che parte della cartelle è possibile ritrovarli. Sono difficilmente quantificabili i costi in termini economici e di salute che derivano da tale frammentazione delle informazioni cliniche, ma appaiono evidenti i vantaggi che si otterebbero se tali informazioni fossero sempre disponibili e rapidamente reperibili. Il registro sanitario elettronico personale che stiamo completando consentirà  ai suoi utenti di poter accedere, ovunque sia presente una connessione ad Internet alle proprie informazioni sanitarie.</p>
					<p style="text-align:left"><a href="http://www.puntotvonline.it/2016/03/VIDEO-Addio-alla-cartella-clinica-arriva-il-fascicolo-elettronico-consultabile-con-un-click.html">Intervista al dott. Girardi</a>
					</p>
					<p style="text-align:left"><a href="http://www.puntotvonline.it/2016/03/VIDEO-Addio-alla-cartella-clinica-arriva-il-fascicolo-elettronico-consultabile-con-un-click.html"><img src="img/IntervistaPuntoTv.png"/></a>
					</p>
					<br>
					<br>
				</div>
			</div>
		</div>
	</section>
	<hr>
	<!-- Chi Siamo Section -->
	<section id="chisiamo" class="chisiamo-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="centered">Chi Siamo</h1>
					<br>
					<div class="col-lg-12">
						<!-- ACCORDION -->
						<div class="accordion ac" id="accordion2">
							<div class="accordion-group">
								<div class="accordion-heading centered">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
		                        	<h3>dott. Francesco Girardi</h3>
                                    <img src="/img/home/girardi.png">
                                    <h3><small>dirigente medico ASL BARI</small></h3>
                                </a>
								
								</div>
								<!-- /accordion-heading -->
								<div id="collapseOne" class="accordion-body collapse">
									<div class="accordion-inner">
										<p>Il dott. Girardi ha ottenuto con il massimo dei voti la maturità  scientifica presso il Liceo "Enrico Fermi" di Bari. All'età  di 24 anni ha ottenuto con il beneficio della lode la Laurea in Medicina e Chirurgia presso l'Università ' degli Studi di Bari, ove tre anni dopo si è specializzato con lode in Ematologia Generale.<br> Ha iniziato la propria attività  di medico effettuando sostituzioni di medici di medicina generale e di guardia medica.<br> Nelle Estati del 1989 e 1990 ha lavorato presso il Pronto Soccorso estivo di Villanova ( BR) e Castellaneta Marina (TA)<br> Nel 1991 è stato assunto presso le Case di Cura Riunite di Bari ove ha lavorato sino al 1996 nei reparti di Oncologia Medica, Nefrologia e dialisi e Medicina Interna.<br> Nel 1994 ha ottenuto il Diploma con lode al corso di perfezionamento in â€œOncologia dell'Apparato digerente: I tumori del grosso intestinoâ€�<br> Dal 1996 al 1999 ha lavorato presso la clinica Villa Bianca di Martina Franca (TA) ove si è occupato di riabilitazione oncologica, ortopedica e pneumologica. <br> Il 1 Giugno 1999, avendo vinto il concorso per dirigente medico presso l'Ematologia di Brindisi ha iniziato ad occuparsi di Emato-oncologia e di Talassemia. <br> Durante gli anni di lavoro presso l'Ematologia ha partecipato alla progettazione di una delle prime cartelle cliniche elettroniche in rete : <a href="http://www.talassemia.it">webthal</a> utilizzata per il monitoraggio dei pazienti talassemici.<br> Ha inoltre svolto attività  di ricerca partecipando allo studio di fase III per l'<a href="http://www.ema.europa.eu/">EMA</a> e la
											<a=h ref="www.fda.gov">FDA</a> per la registrazione dell'ExjadeÂ®.<br> Nel 2001 ha conseguito l'European Computer Driving Licence NÂ° IT 037761.<br> Dal 2004 si è trasferito presso la ASL BARI ove ha lavorato nei reparti di Medicina e di Geriatria dell'Ospedale Fallacara di Triggiano ed è attualmente impiegato come medico dirigente dell' Ufficio Valutazione Appropriatezza Ricoveri e Prestazioni (UVARP).<br> Nel 2013 ha conseguito la laurea triennale in Informatica, relatore il prof. Giovanni Dimauro, discutendo la tesi : "Il paziente al centro dell'assistenza: un approccio digitale" ottenendo la lode. Il lavoro di tesi, consistito nello sviluppo del prototipo di un fascicolo sanitario elettronico multimediale è stato ampliato con le tesi di altri laureandi.</p>

										<p>Ha presentato al "2014 IEEE Workshop on Biometric Measurements and Systems for Security and Medical Applications" <a href="http://bioms2014.di.unimi.it/">BIOMS</a> tenutosi a Roma il 17 Ottobre 2014 il lavoro<a href="https://www.deepdyve.com/lp/institute-of-electrical-and-electronics-engineers/the-patient-centered-electronic-multimedia-health-fascicle-emhf-EghfPPsAHb"> "The Patient Centered Electronic Multimedia Health Fascicle - EMHF" </a> di cui è coautore insieme ai professori Giovanni Dimauro e Marco Matteo Ciccone.</p>
									</div>
									<!-- /accordion-inner -->
								</div>
								<!-- /collapse -->
							</div>
							<!-- /accordion-group -->
							<br>

							<div class="accordion-group">
								<div class="accordion-heading centered">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
		                        	<h3>prof. Giovanni Dimauro</h3>
                                    <img src="/img/home/dimauro.png" style="height: 161px; width: 126px;">
                                    <h3><small>professore associato dipartimento di Informatica Universita' degli studi di Bari 'Aldo Moro'</small></h3>
		                        </a>
								
								</div>
								<div id="collapseTwo" class="accordion-body collapse">
									<div class="accordion-inner">
										<p>Il prof.Dimauro, fin dall'entrata in servizio presso l'Università di Bari (settembre 1990) ha sempre svolto la sua attività  in forma di tempo pieno.<br> E' Coordinatore del Corso di Laurea in Informatica e Tecnologie per la Produzione del Software da novembre 2010.<br> Ha fatto parte del Collegio dei Docenti del Dottorato di Informatica fin dal XV ciclo e tuttora ne fa parte;<br> E' componente della Commissione Paritetica del Consiglio Interclasse dei Corsi di Laurea in Informatica (CICSI) dell'Università  di Bari dal 2010.<br> E' stato eletto Componente del Comitato di Area per la Valutazione della Ricerca (CAR) 2001/03 dell'Università di Bari.<br> È stato nominato Tutor degli studenti per il triennio 2006-2009<br> Nel 2010 è stato nominato dal Dipartimento di Informatica Coordinatore del Sistema Integrato dei Laboratori Didattici (SILAD) del Dipartimento e svolge tuttora tale coordinamento.</p>

										<p>Il Prof. Dimauro ha partecipato a numerose Conferenze, Workshop e Scuole internazionali e cioè ha contribuito sia alla sua maturazione scientifica che anche all'acquisizione di esperienza tecnico-organizzativa che gli ha consentito di collaborare attivamente all'organizzazione scientifica sia in Italia che all'estero di alcune manifestazioni di levatura nazionale ed internazionale.</p>

										<p> Di seguito si riporta un elenco di tali attività  organizzative:</p>

										<ul>

											<li>Second International Workshop on Frontiers in Handwriting Recognition: Organizzazione e Segreteria Scientifica; </li>

											<li>7th International Conference on Image Analysis and Processing (7ICIAP) : Organizzazione e Segreteria Scientifica;</li>

											<li>5th International Workshop on Frontiers in Handwriting Recognition : Organizzazione e Segreteria Scientifica;</li>

										</ul>
									</div>
									<!-- /accordion-inner -->
								</div>
								<!-- /collapse -->
							</div>
							<!-- /accordion-group -->
							<br>

						</div>
						<!-- Accordion -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Link Section -->
	<section id="link" class="link-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">

					<div class="accordion ac" id="accordion3">
						<div class="accordion-group">
							<br><br>
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree">
								<center>
									<h3>Links</h3>
								</center>
							</a>
							<div class="accordion-inner">
								<div id="collapseThree" class="accordion-body collapse">
									<div class="row">
										<div class="col-lg-4">
											<nav class="footer-nav">
												<center>
													<h4>Ospedali</h4>
												</center>
												<ul>
													<li><a href='http://www.sanita.puglia.it/web/ospedalegiovannixxiii'>Policlinico di Bari</a>
													</li>
													<li><a href='http://www.sanita.puglia.it/web/irccs'>IRCCS Giovanni Paolo II</a>
													</li>
													<li><a href='https://www.ieo.it/'>Istituto Europeo di Oncologia</a>
													</li>
													<li><a href='http://www.ospedalebambinogesu.it/'>Ospedale Bambin Gesà¹</a>
													</li>
												</ul>
											</nav>
										</div>

										<div class="col-lg-4">
											<nav class="footer-nav">
												<center>
													<h4>Linee Guida e Società  Mediche</h4>
												</center>
												<ul>
													<li><a href="http://www.snlg-iss.it/lgn#">Linee Guida Nazionali</a>
													</li>
													<li><a href="http://www.salute.gov.it/imgs/C_17_pubblicazioni_1164_allegato.pdf">Linee guida alla diagnostica per immagini</a>
													</li>
													<li><a href="http://www.g-i-n.net/library/international-guidelines-library">Biblioteca Internazionale delle Linee Guida</a>
													</li>
													<li><a href="http://www.escardio.org/Guidelines-&-Education/Clinical-Practice-Guidelines/ESC-Clinical-Practice-Guidelines-list/listing">Società  Europea di Cardiologia</a>
													</li>
												</ul>
											</nav>
										</div>

										<div class="col-lg-4">
											<nav class="footer-nav">
												<center>
													<h4>Istituzioni</h4>
												</center>
												<ul>
													<li><a href="http://www.salute.gov.it/">Ministero della Salute</a>
													</li>
													<li><a href="http://www.agenziafarmaco.gov.it/it">Agenzia Italiana del Farmaco</a>
													</li>
												</ul>
											</nav>
										</div>
									</div>
									<!--row-->
									<div class="col-lg-4">
										<nav class="footer-nav">
											<center>
												<h4>Documenti</h4>
											</center>
											<ul>
												<li><a href="http://www.privacy.it/codiceprivacy.html">Codice della privacy</a>
												</li>
												<li><a href="informative/trasfusionalePoliclinico.pdf">Informativa donatori Policlinico Bari</a>
												</li>
											</ul>
										</nav>
									</div>
									<div class="row">

									</div>
									<!--row-->
								</div>
								<!--collapseThree-->
							</div>
							<!--accordion inner-->
						</div>
					</div>
				</div>
				<!--col-lg-12-->
			</div>
			<!--row-->
		</div>
		<!--container-->
	</section>
	<!-- Contact Section -->
	<section id="contact" class="contact-section">
		<div class="container">
			<div class="col-lg-5">
				<h3>Chiediamo il tuo aiuto</h3>
				<p>Non spetta a noi giudicare i risultati del nostro lavoro. Sappiamo di aver fatto del nostro meglio potendo contare solo sulle nostre forze. Per poterne valutare l'effettiva validità  abbiamo bisogno di poterlo sperimentare in modo da poter correggere eventuali errori ed appportare possibili miglioramenti. Se sei interessato sia come paziente che come operatore sanitario, ti chiediamo di registrarti, la registrazione e l'utilizzo saranno gratuiti per tutta la fase sperimentale, per poter contribuire con i tuoi suggerimenti a realizzare uno strumento che potrà  essere utile per meglio tutelare la tua salute o quella dei tuoi pazienti.
				</p>
			</div>

			<div class="col-lg-7">
				<h3>Dacci un suggerimento</h3>
				<br>
				@if ($errors->any())
    				<div class="alert alert-danger" role="alert">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif
				@if(Session::has('success'))
				         <div class="alert alert-success" role="alert">
				             {{ Session::get('success') }}
				         </div>
				@endif
				{{ Form::open(array('url' => '/send-suggestion', 'method' => 'get', 'id' => 'form_contact_us')) }}
				{{ csrf_field() }}
					<div class="form-group">
						<label for="name1">Nome</label>
						{{ Form::text('nome', '', array('class' => 'form-control', 'placeholder' => 'Il tuo nome')) }}
					</div>
					<div class="form-group">
						<label for="email1">Indirizzo email</label>
						{{ Form::email('mail', '', array('class' => 'form-control', 'placeholder' => 'Inserisci un indirizzo email')) }}
					</div>
					<div class="form-group">
						<label>Messaggio</label>
						{{ Form::textarea('messaggio', '', array('class' => 'form-control', 'rows' => 3, 'placeholder' => 'Il tuo messaggio')) }}
					</div>
					<br>
					{{ Form::submit('INVIA', array('class' => 'btn btn-large btn-warning')) }}
				{{ Form::close() }}
			</div>
		</div>

	</section>
	<div id="c">
		<div class="container">
			<p>Incaricato e responsabile del trattamento dei dati: dott. Francesco Girardi; C.F. GRRFNC62A06A662W; Bari, Via Amendola, 79; mail: privacy@fsem.eu</p>
			<p>Proseguendo con la navigazione si intende accettata la <a href="informative/consensoInformatoFsem.eu.html"><b> politica della privacy</b></a> adottata</p>

			<div class="footer-right">

				<p>copyright © FSEM 2017</p>
				</hr>


			</div>
		</div>
	</div>
	<!--	<div class="footer-right">
				<a href = "http://www.privacy.it/codiceprivacy.html">Codice della privacy</a>
				<a href = "http://www.salute.gov.it/">Ministero della Salute</a>
			</div>
				<nav class="footer-nav">
							<ul>
								<li><a href = "#">Home</a></li>
								<li><a  href="#progetto">Il Progetto</a></li>
								<li><a  href="#chisiamo">Chi Siamo</a></li>
								<li><a  href="#contact">Contattaci</a></li>
							</ul>
					</nav>
					<nav class="footer-nav">
							<ul>
								<li><a href ='http://www.sanita.puglia.it/portal/page/portal/SAUSSC/Aziende%20Sanitarie/AZIENDE%20OSPEDALIERE/Azienda%20Ospedaliero%20Universitaria%20Consorziale%20Policlinico'>Policlinico di Bari</a></li>
								<li><a href ='http://www.sanita.puglia.it/portal/page/portal/SAUSSC/Aziende%20Sanitarie/AZIENDE%20OSPEDALIERE/I.R.C.C.S%20Ospedale%20Oncologico%20Giovanni%20Paolo%20II%20Bari'>IRCCS Giovanni Paolo II</a></li>
								<li><a href ='https://www.ieo.it/'>Istituto Europeo di Oncologia</a></li>
								<li><a href ='http://www.ospedalebambinogesu.it/'>Ospedale Bambin Gesà¹</a></li>
							</ul>
					</nav>
					<nav class="footer-nav">
							<ul>
								<li><a href = "http://www.snlg-iss.it/lgn#">Linee Guida Nazionali</a></li>
								<li><a href = "http://www.salute.gov.it/imgs/C_17_pubblicazioni_1164_allegato.pdf">Linee guida alla diagnostica per immagini</a></li>
								<li><a href ="http://www.g-i-n.net/library/international-guidelines-library">Biblioteca Internazionale delle Linee Guida</a></li>
								<li><a href ="http://www.escardio.org/Guidelines-&-Education/Clinical-Practice-Guidelines/ESC-Clinical-Practice-Guidelines-list/listing">Società  Europea di Cardiologia</a></li>
							</ul>
					</nav>
			</div>
		</div>
	-->
	<!-- jQuery -->
	<script src="/js/jquery-2.0.3.min.js"></script>
	<script src="/js/spin.js"></script>
	<script src="/js/scroll.js"></script>
	<script src="/js/jquery.blockUI.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="/plugins/bootstrap/js/bootstrap.js"></script>

	<!-- Scrolling Nav JavaScript -->
	<script src="/js/jquery.easing.min.js"></script>
	<script src="/js/scrolling-nav.js"></script>

	<!-- Scrolling Nav JavaScript -->
	<script src="/plugins/jquery-validation-1.11.1/dist/jquery.validate.min.js"></script>
	<script src="/plugins/jquery-validation-1.11.1/localization/messages_it.js"></script>
	<script src="/js/formscripts/login.js"></script>
	<script>
		$( '.carousel' ).carousel( {
			interval: 3500
		} )
	</script>

</body>

</html>