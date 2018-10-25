<!-- MENU SECTION -->


<link rel='stylesheet'
	href='https://use.fontawesome.com/releases/v5.4.1/css/all.css'
	integrity='sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz'
	crossorigin='anonymous'>
<div id="left">
	<div class="media user-media well-small">
		<a class="user-link" href="/home"> <!-- TODO: Aggiungere controllo se l'immagine del profilo è stata impostata -->
			<img class="media-object img-thumbnail user-img"
			alt="Immagine Utente" src="/img/user.gif" />
		</a> <br />
		<div class="media-body">
			<h5 class="media-heading">{{$current_administrator->getName()}}</h5>

			<h5 class="media-heading">{{$current_administrator->getSurname()}}</h5>
		</div>
		<br />
	</div>
	<!--ANAGRAFICA RIDOTTA-->
	<div class="well well-sm">
		<ul class="list-small">
			<li><strong>C.F.</strong>: <span> Non Prevenuto </span></li>
			<li><strong>Data di nascita</strong>: <span> {{$time=date('d-m-Y',
					strtotime(str_replace('/', '-',
					$current_administrator->Data_Nascita)))}} </span> <strong>Età</strong>:
				<span> {{Auth::user()->getAge($time)}} </span></li>
			<li><strong>Telefono</strong>:
				{{$current_administrator->getRecapito()}}</li>
		</ul>

	</div>
	<ul id="menu" class="collapse">


		<li class="panel"><a href="/administration/ControlPanel"> <i
				class='fas fa-tachometer-alt' style='font-size: 18px; color: blue'></i>
				Pannello di Controllo
		</a></li>
		
		<li class="panel"><a href="/administration/CareProviders"> <i
				class='fas fa-file-medical' style='font-size: 18px; color: blue'></i>
				Care Providers
		</a></li>

</div>
<!--FINE ANAGRAFICA RIDOTTA-->

