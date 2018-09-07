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

			<h1>Non hai acconsentito all'utilizzo dei cookie</h1>

			<h3>Se accetti l'utilizzo dei cookie, saranno memorizzati i seguenti:</h3>
			<ul>
				<li><span style="font-weight: bold">consent</span> - Consente al
					sistema di memorizzare le informazioni temporali di accettzione.</li>
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

		

		

</body>
</html>
