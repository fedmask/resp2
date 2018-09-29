@include('layouts.cookiescript')
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description"
	content="Registro Elettronico Sanitario Personale">
<meta name="author" content="FSEM.EU">
<!--tag per Norton safeweb-->
<meta name="norton-safeweb-site-verification"
	content="968cfkk7w10gz46o40uds-pcd3ycz6eb9pwfxvjrdyb20jhdn2rqzvjt-52lriqobfa56j0k34oa7ftdrw5ar2zg6gawwlnpvemqsnqliv3zee16nrdjyo0agyu3bdr2" />
<link rel="shortcut icon" href="faviconFSEM.ico">

<title>Registro Elettronico Sanitario Personale</title>

<!-- Bootstrap Core CSS -->
<link href="/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="/css/scrolling-nav.css" rel="stylesheet">
<link href="/css/yamm.css" rel="stylesheet" />

<link
	href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic"
	rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Raleway:400,300,700"
	rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/plugins/Font-Awesome/css/font-awesome.css" />
<link rel="stylesheet" href="/css/spin.css" />

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
	<nav class="navbar navbar-default navbar-fixed-top yamm"
		role="navigation">
		<div class="container">
			<div class="navbar-header page-scroll">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<header class="navbar-header">
					<a href="/home" class="navbar-brand"
						style="color: #1d71b8; font-size: 22px"><img
						src="/img/logo_icona.png" alt="">&nbsp; R<span
						style="color: #36a9e1">egistro</span> E<span
						style="color: #36a9e1">lettronico</span> S<span
						style="color: #36a9e1">anitario</span> P<span
						style="color: #36a9e1">ersonale</span> M<span
						style="color: #36a9e1">ultimediale</span> </a>
				</header>

			</div>
		</div>
	</nav>

	<p>
		<br> <br> <br> <br>
	</p>


	<div class="container">
		<div class="row">
			@if(\Illuminate\Support\Facades\Cookie::get('consent') == null ||
			\Illuminate\Support\Facades\Cookie::get('consent') === "")
			<div>
				<h1>Gestione Cookie</h1>
				<hr>
			</div>

			<h2>Non hai acconsentito all'utilizzo dei cookie</h2>

			<h3>Se accetti l'utilizzo dei cookie, saranno memorizzati i seguenti:</h3>
			<ul>
				<li><span style="font-weight: bold">consent</span> - Consente al
					sistema di memorizzare le informazioni temporali di accettazione.</li>
				<li><span style="font-weight: bold">XSRF-TOKEN</span> - Il sistema
					genera automaticamente un "token" CSRF per ogni sessione utente
					attiva gestita dall'applicazione. Questo token viene utilizzato per
					verificare che l'utente autenticato sia quello che sta
					effettivamente effettuando le richieste all'applicazione.</li>
				<li><span style="font-weight: bold">laravel_session</span> - le
					sessioni forniscono un modo per archiviare le informazioni
					sull'utente attraverso le richieste.</li>
				<li><span style="font-weight: bold">Google analytics cookies</span>
					- Google Analytics e' uno strumento semplice e di facile utilizzo
					che aiuta i proprietari di siti web a misurare il modo in cui gli
					utenti interagiscono con i contenuti del sito web..</li>
			</ul>
			<p>
				<br>
			</p>
			<div align="center" onclick="refresh()">
				<button class="btn btn-info" onclick="accept()">Consenti l'utilizzo
					dei cookie.</button>

				@else
				<div>
					<h1>Gestione Cookie</h1>
					<hr>
				</div>

				<h1>Hai accettato (il
					{{\Illuminate\Support\Facades\Cookie::get('consent')}}) l'uso dei
					seguenti cookie:</h1>
				<ul>
					<li><span style="font-weight: bold">consent</span> - Consente al
						sistema di memorizzare le informazioni temporali di accettzione.</li>
					<li><span style="font-weight: bold">XSRF-TOKEN</span> - Il sistema
						genera automaticamente un "token" CSRF per ogni sessione utente
						attiva gestita dall'applicazione. Questo token viene utilizzato
						per verificare che l'utente autenticato sia quello che sta
						effettivamente effettuando le richieste all'applicazione.</li>
					<li><span style="font-weight: bold">laravel_session</span> - le
						sessioni forniscono un modo per archiviare le informazioni
						sull'utente attraverso le richieste.</li>
					<li><span style="font-weight: bold">Google analytics cookies</span>
						- Google Analytics e' uno strumento semplice e di facile utilizzo
						che aiuta i proprietari di siti web a misurare il modo in cui gli
						utenti interagiscono con i contenuti del sito web.</li>
				</ul>
				<p>
					<br>
				</p>
				<div align="center" onclick="refresh()">
					<button class="btn btn-danger" onclick="refuse()">Revoca l'utilizzo
						dei cookie.</button>
				</div>
				@endif
			</div>
		</div>
		<div class="container">
			<div>
				<h1>Cookie Policy</h1>
				<hr>
			</div>
		</div>
		<div class="container">
			<div class="panel-group" id="accordion">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion"
								href="#collapse1">Cookie: cosa sono e a che servono</a>
						</h4>
					</div>
					<div id="collapse1" class="panel-collapse collapse in">
						<div class="panel-body">
							<h3>
								<strong>Cookie</strong>
							</h3>
							<p>Questo sito fa uso di cookie, file di testo che vengono
								registrati sul terminale dell' utente oppure che consentono l'
								accesso ad informazioni sul terminale dell'utente. I cookie
								permettono di conservare informazioni sulle preferenze dei
								visitatori, sono utilizzati al fine di verificare il corretto
								funzionamento del sito e di migliorarne le funzionalita'
								personalizzando il contenuto delle pagine in base al tipo del
								browser utilizzato, oppure per semplificarne la navigazione
								automatizzando le procedure (es. Login, lingua sito), ed infine
								per l'analisi dell'uso del sito da parte dei visitatori.</p>
							<p>Il presente sito fa uso delle seguenti categorie di cookie:</p>
							<p>
								- <strong>cookie tecnici</strong>, utilizzati al solo fine di
								effettuare la trasmissione di una comunicazione elettronica, per
								garantire la corretta visualizzazione del sito e la navigazione
								all' interno di esso. Inoltre, consentono di distinguere tra i
								vari utenti collegati al fine di fornire un servizio richiesto
								all'utente giusto (Login), e per motivi di sicurezza del sito.
								Alcuni di questi cookie sono eliminati alla chiusura del browser
								(cookie di sessione), altri hanno una durata maggiore (come ad
								esempio il cookie necessario per conservazione il consenso
								dell'utente in relazione all'uso dei cookie, che dura 1 anno).
								Per questi cookie non occorre consenso;
							</p>
							<p>
								- <strong>cookie di analisi</strong>, utilizzati direttamente
								dal gestore del sito per raccogliere informazioni, in forma
								aggregata, sul numero degli utenti e su come questi visitano il
								sito stesso. Sono assimilati ai cookie tecnici se il servizio e'
								anonimizzato.
							</p>
							<p>
								- <strong>cookie di profilazione e marketing</strong>,
								utilizzati esclusivamente da terze parti diverse dal titolare
								del presente sito per raccogliere informazioni sul comportamento
								deli utenti durante la navigazione, e sugli interessi e
								abitudini di consumo, anche al fine di fornire pubblicita'
								personalizzata.&nbsp;
							</p>

							<p>
								Cliccando <strong>OK sul banner</strong> presente al primo
								accesso al sito oppure <strong>navigando il sito</strong>, il
								visitatore acconsente espressamente all'uso dei cookie e delle
								tecnologie similari, e in particolare alla registrazione di tali
								cookie sul suo terminale per le finalita' sopra indicate, oppure
								all'accesso tramite i cookie ad informazioni sul suo terminale.
							</p>
							<p>
								<span style="color: #ff0000;"><strong>&nbsp;</strong></span>
							</p>
							<p>&nbsp;&nbsp;</p>
						</div>
					</div>
				</div>


				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion"
								href="#collapse2">Come disabilitare i cookie</a>
						</h4>
					</div>
					<div id="collapse2" class="panel-collapse collapse in">
						<div class="panel-body">
							<h4>
								<strong>Disabilitazione cookie</strong>
							</h4>

							<p>
								L'utente puo' rifiutare l'utilizzo dei cookie e in qualsiasi
								momento puo' revocare un consenso gia' fornito. Poiche' i cookie
								sono collegati al browser utilizzato, <strong>POSSONO ESSERE
									DISABILITATI DIRETTAMENTE DAL BROWSER</strong>, cosi
								rifiutando/revocando il consenso all'uso dei cookie, oppure
								accedendo all'apposita schermata posta in alto.
							</p>
							<p>
								<br /> Le istruzioni per la disabilitazione dei cookies si
								trovano alle seguenti pagine web:&nbsp;
							</p>
							<p>
								<a title="Attivare e disattivare i cookie"
									href="https://support.mozilla.org/it/kb/Attivare%20e%20disattivare%20i%20cookie"
									target="_blank" rel="noopener noreferrer">Mozilla Firefox</a>&nbsp;-&nbsp;<a
									title="Come bloccare, abilitare o consentire i cookie"
									href="https://support.microsoft.com/it-it/help/17442/windows-internet-explorer-delete-manage-cookies"
									target="_blank" rel="noopener noreferrer">Microsoft Internet
									Explorer</a>&nbsp;- <a title="Eliminare i cookie"
									href="https://support.microsoft.com/it-it/help/4027947/windows-delete-cookies"
									target="_blank" rel="noopener">Microsoft Edge</a> -&nbsp;<a
									title="Cancellazione, attivazione e gestione dei cookie in Chrome"
									href="https://support.google.com/chrome/answer/95647?hl=it"
									target="_blank" rel="noopener noreferrer">Google Chrome</a>&nbsp;-&nbsp;<a
									title="Cookie"
									href="http://help.opera.com/Windows/10.00/it/cookies.html"
									target="_blank" rel="noopener noreferrer">Opera</a>&nbsp;-&nbsp;<a
									title="Impostazioni web per Safari sull‘iPhone, sull‘iPad, o sull‘iPod touch"
									href="https://support.apple.com/it-it/HT201265" target="_blank"
									rel="noopener noreferrer">Apple Safari</a>&nbsp;
							</p>
							<p>&nbsp;</p>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion"
								href="#collapse3">Cookie di terze parti</a>
						</h4>
					</div>
					<div id="collapse3" class="panel-collapse collapse in">
						<div class="panel-body">
							<h4>
								<strong>Cookie di terze parti</strong>
							</h4>
							<p>Questo sito funge anche da intermediario per cookie di terze
								parti (come i pulsanti per i social network), utilizzati per
								poter fornire ulteriori servizi e funzionalita' ai visitatori e
								per semplificare l'uso del sito stesso, o per fornire
								pubblicita' personalizzata. Questo sito non ha alcun controllo
								sui loro cookie interamente gestiti dalle terze parti e non ha
								accesso alle informazioni raccolte tramite detti cookie. Le
								informazioni sull'uso dei detti cookie e sulle finalita' degli
								stessi, nonche' sulle modalita' per l'eventuale disabilitazione,
								sono fornite direttamente dalle terze parti alle pagine indicate
								di seguito.</p>
							<p>Il presente sito utilizza cookie delle seguenti terze parti.</p>
							<p>
								- <strong>Google</strong> <strong>Analytics</strong>: utilizzato
								per analizzare l'uso del sito da parte degli utenti, compilare
								report sulle attivita' del sito e il comportamento degli utenti,
								verificare quanto spesso gli utenti visitano il sito, come il
								sito viene rintracciato e quali pagine sono visitate piu'
								frequentemente. Le informazioni sono combinate con informazioni
								raccolte da altri siti al fine di creare un quadro comparativo
								dell'uso del sito rispetto ad altri siti delle medesima
								categoria. <br />Dati raccolti: identificativo del browser, data
								e orario di interazione col sito, pagina di provenienza,
								indirizzo IP. <br />Luogo di trattamento dei dati: Unione
								europea essendo attiva l'anonimizzazione del servizio.
							</p>
							<p>
								I dati raccolti non consentono l'identificazione personale degli
								utenti, e non sono incrociati con altre informazioni relative
								alla stessa persone. Sono <strong>anonimizzati</strong>
								(troncati all'ultimo ottetto). In base ad apposito accordo e'
								vietato a Google Inc. l'incrocio di tali dati con quelli
								ricavati da altri servizi.
							</p>
						</div>
					</div>
				</div>


				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion"
								href="#collapse4">Ulteriori Informazioni</a>
						</h4>
					</div>
					<div id="collapse4" class="panel-collapse collapse in">
						<div class="panel-body">
							<p>
								Ulteriori informazioni sui cookies di Google Analytics si
								trovano alla pagina&nbsp;<a
									title="Google Analytics Cookie Usage on Websites"
									href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage"
									target="_blank" rel="noopener">Google Analytics Cookie Usage on
									Websites</a>.&nbsp;<br /> <br /> <span style="color: #000000;">L'utente
									puo' <strong>disabilitare</strong>&nbsp;(opt-out) in modo
									selettivo la raccolta dei dati da parte di Google Analytics
								</span> installando sul proprio browser l'<a
									title="Componente aggiuntivo del browser per la disattivazione di Google Analytics"
									href="https://tools.google.com/dlpage/gaoptout" target="_blank"
									rel="noopener noreferrer">apposito componente fornito da Google</a>
								(opt out). <br />

							</p>
						</div>
					</div>
				</div>
			</div>


		</div>



		<p>
			<br>
		</p>
		<div align="center"
			
			<p>
				La nostra Cookie Policy e' scaricabile cliccando su: <a
					href="informative/Cookie Policy.pdf">Cookie Policy</a>
			</p>
		</div>


	</div>

	<p>
		<br>
	</p>
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script
		src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>
