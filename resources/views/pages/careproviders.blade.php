@extends('layouts.app') @extends('includes.template_head')

@section('pageTitle', 'Care Providers') @section('content')
<!--PAGE CONTENT -->
<div id="content">

	<div class="inner" style="min-height: 1200px;">
		<div class="row">
			<div class="col-lg-12">
			
		
				<h2>Care Providers</h2>

				<div class="box dark">
					<div class="panel-group" id="accordion" role="tablist"
						aria-multiselectable="true">
						<div class="panel panel-default">
							<div class="panel panel-warning">
								<div class="panel-heading" role="tab" id="headingOne">
									<a role="button" data-toggle="collapse"
										data-parent="#accordion" href="#collapseOne"
										aria-expanded="true" aria-controls="collapseOne"> <strong>Clicca
											per aprire la tabella esplicativa dei ruoli :</strong>

									</a>
								</div>
								<!--panel-heading-->
							</div>
							<!--panel-warning-->
							<div id="collapseOne" class="accordion-body collapse"
								role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th>ruolo</th>
													<th>attivita'</th>
													<th>ruolo</th>
													<th>attivita'</th>
													<th>ruolo</th>
													<th>attivita'</th>
												</tr>
											</thead>
											<tbody>
												<!--creo una tabella esplicativa dei codici che inserisce 3 valori per riga -->
												@for($i = 0; $i < count($types)-2; $i = $i+3)
												<tr>
													<td>{{ $types[ $i ]->id_tipologia}}</td>
													<td>{{ $types[ $i ]->tipologia_descrizione}}</td>
													<td>{{ $types[ $i+1 ]->id_tipologia}}</td>
													<td>{{ $types[ $i+1 ]->tipologia_descrizione}}</td>
													<td>{{ $types[ $i+2 ]->id_tipologia}}</td>
													<td>{{ $types[ $i+2 ]->tipologia_descrizione}}</td>
												</tr>

												@if( (count($types)-2)% 3 ==1 )
												<tr>
													<td>{{ $types[ $i ]->id_tipologia}}</td>
													<td>{{$types[ $i ]->tipologia_descrizione}}</td>
												</tr>
												@elseif((count($types)-2) == 2)
												<tr>
													<td>{{ $types[ $i+1 ]->id_tipologia}}</td>
													<td>{{$types[$i+1 ]->tipologia_descrizione}}</td>
												</tr>
												@endif @endfor
											</tbody>
										</table>
									</div>
									<!--table-responsive-->
								</div>
								<!--panel body-->
							</div>
							<!--accordion-body-collapse-->
						</div>
						<!--panel panel-default-->
					</div>
					<!--panel-group accordion-->

					<div class="body">
						<div class="panel panel-warning">
							<!-- TODO: Rivedere dal vecchio resp il controllo sulla condivisione o meno dei dati del paziente
								con i care provider -->

							<div class="panel-body">
								</br>
								<div class="panel panel-warning">
									<div class="panel-heading">
										<strong>I Care Provider associati a te :</strong>
									</div>
								</div>
								<div id="toSetTableSet" class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>Nome</th>
												<th>Cognome</th>
												<th>Ruolo</th>
												<th>Telefono</th>
												<th>Altre informazioni</th>
												<th>Citta'</th> @if($current_user->getDescription() ==
												User::PATIENT_DESCRIPTION)
												<th>Opzioni</th> @endif
												<th></th>
											</tr>
												@for($i = 0; $i < $current_user->trovaCppAssociati(); $i++)
												<tr>
													@for($i = 0; $i < $current_user->trovaCppAssociati(); $i++)
											<tr>
												<td>{{ $current_user->nomeCppAssociato()[$i]}}</td>
												<td>{{ $current_user->cognomeCppAssociato()[$i]}}</td>
												<td>{{ $current_user->ruoloCppAssociato()[$i]}}</td>
												<td>{{ $current_user->telefonoCppAssociato()[$i]}}</td>
												<td>{{ $current_user->informazioniCppAssociato()[$i]}}</td>
												<td>{{ $current_user->cittaCppAssociato()[$i]}}</td>
												<td>{{
													$current_user->confidenzialitaCppAssociato($current_user->id_utente,
													$current_user->idCppAssociato($current_user->telefonoCppAssociato()[$i]))}}</td>
												<td>
													<table>
														<tr>
															<td>
																<div class="dropdown">
																	<button href="#"
																		class="btn btn-info dropdown-toggle dropdown-toggle-unset"
																		type="button" data-toggle="dropdown"
																		aria-haspopup="true" aria-expanded="true">
																		<i class="icon-check"></i> <span class="caret"></span>
																	</button>
																	<ul class="dropdown-menu">
																		<li><a
																			href="http://localhost:8000/1/{{$current_user->id_utente}}/{{$current_user->idCppAssociato($current_user->telefonoCppAssociato()[$i])}}"
																			id="{{($i)}}">Nessuan restrizione</a></li>
																		<li><a
																			href="http://localhost:8000/2/{{$current_user->id_utente}}/{{$current_user->idCppAssociato($current_user->telefonoCppAssociato()[$i])}}"
																			id="{{($i)}}">Basso</a></li>
																		<li><a
																			href="http://localhost:8000/3/{{$current_user->id_utente}}/{{$current_user->idCppAssociato($current_user->telefonoCppAssociato()[$i])}}"
																			id="{{($i)}}">Moderato</a></li>
																		<li><a
																			href="http://localhost:8000/4/{{$current_user->id_utente}}/{{$current_user->idCppAssociato($current_user->telefonoCppAssociato()[$i])}}"
																			id="{{($i)}}">Normale</a></li>
																		<li><a
																			href="http://localhost:8000/5/{{$current_user->id_utente}}/{{$current_user->idCppAssociato($current_user->telefonoCppAssociato()[$i])}}"
																			id="{{($i)}}">Riservato</a></li>
																		<li><a
																			href="http://localhost:8000/6/{{$current_user->id_utente}}/{{$current_user->idCppAssociato($current_user->telefonoCppAssociato()[$i])}}"
																			id="{{($i)}}">Strettamente riservato</a></li>
																	</ul>
																</div>
															</td>
															<td><a
																href="http://localhost:8000/{{$current_user->confidenzialita($current_user->id_utente,$current_user->idCppAssociato($current_user->telefonoCppAssociato()[$i]))}}/{{$current_user->id_utente}}/{{$current_user->idCppAssociato($current_user->telefonoCppAssociato()[$i])}}/ok"
																method="post"><button style="width: 33px; height: 33px;"
																		id="assegnaValore()" type="submit"
																		class="icon-remove btn-danger"></button></a></td>
															<td>
																<button style="width: 33px; height: 33px;"
																	id="{{$current_user->trovaMail($current_user->idCppAssociato($current_user->telefonoCppAssociato()[$i]))}}"
																	onclick="assegnaValore(this.id)"
																	data-target="#formModal"
																	class="icon-envelope btn-warning" data-toggle="modal"
																	aria-hashpopup="true" aria-expanded="true"></button>
															</td>
														</tr>
													</table>

												</td>
											</tr>
											@endfor
											@endfor
													
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
								<!--table-responsive-->

								<script>
//Questa funzione assegna nel form della mail la mail dell'utente loggato 								
function assegnaValore(num){
	var a = document.getElementById("mail").value = num;
	var b = document.getElementById("nomeutente").value= "{{($current_user->getEmail())}}";
}
</script>
								

<div id="map"></div>
<style>
#map {
	height: 400px;
	width: 100%;
}
</style>

<script>
var pos, infoWindow;
var map = new google.maps.Map(document.getElementById('map'));
function initMap() {
	//distanza dal domicilio scenlto dall'utente
	selectedValue=document.getElementById("list").value;
	
 	geocoder = new google.maps.Geocoder();

 	 		
	 @foreach($current_user->trovaLocalita() as $a){
		//Per ogni careProvider calcola la distanza dalla posizione dell'utente
	 	geocoder.geocode({'location': pos}, function(results, status){
 	     if(status == 'OK'){
 	 	     if(results[0]){
 	 	   	   distanza(results[0].address_components[2].long_name, "{{($a)}}"); 
 	 	 	 }
 	     }
     	});
   	  }
	 @endforeach	  

	map = new google.maps.Map(document.getElementById('map'), {zoom: 5});

	 
  //Geolocalizza la posizione dell'utente
    if(navigator.geolocation) {
     navigator.geolocation.getCurrentPosition(function(position) {
    pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

     var marker=new google.maps.Marker({
         position:{
             lat:position.coords.latitude,
             lng:position.coords.longitude},
             map:map,
             icon:'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=IO|FF0000|000000'});
            
      map.setCenter(pos);

    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    });
    } else {
    // Browser non supporta la geolocalizzazione
    handleLocationError(false, infoWindow, map.getCenter());
    }
}//Fine initMap()

//Aggiunge un marker sulla mappa nelle coordinate passate
function addMarker(props){
	  var marker=new google.maps.Marker({
  	  position: props.coords,
  	  map: map,
	  });
    }

//Comunica all'utente il motivo della mancata geolocalizzazione
function handleLocationError(browserHasGeolocation, infoWindow, pos) {
     switch(browserHasGeolocation.code) {
     case browserHasGeolocation.PERMISSION_DENIED:
	     infoWindow.setContent("Permesso negato dall'utente");
    	 infoWindow.open(map);
         break;
     case browserHasGeolocation.POSITION_UNAVAILABLE:
         infoWindow.setContent("Impossibile determinare la posizione corrente");
         infoWindow.open(map);
         break;
     case browserHasGeolocation.TIMEOUT:
         infoWindow.setContent("Il rilevamento della posizione impiega troppo tempo");
         infoWindow.open(map);
         break;
     case browserHasGeolocation.UNKNOWN_ERROR:
         infoWindow.setContent("Si  verificato un errore sconosciuto");
         infoWindow.open(map);
         break;
 		}
}//fine handleLocationError
	
//Calcola la distanza tra il paese dove l'utente  collegato (la posizione attuale) 
//e il paese di ogni careProvider; se la distanza  minore o uguale della distanza scelta dall'utente
//chiama codeAddress(citt) e aggiungiRiga() sulla mappa e aggiunge il rigo nella tabella con i dati del careProvider
function distanza(start, end){
	var directionsService = new google.maps.DirectionsService();
    var directionsDisplay = new google.maps.DirectionsRenderer();
    var request = {
    origin:start,
    destination:end,
    travelMode: google.maps.TravelMode.DRIVING,
    unitSystem: google.maps.UnitSystem.METRIC 
    };
    directionsService.route(request, function(result, status) {
    if (status == google.maps.DirectionsStatus.OK) {
    directionsDisplay.setDirections(result);
	distanzaCity=result.routes[0].legs[0].distance.text;
    
	if(distanzaCity <= selectedValue){
	codeAddress(end);
	aggiungiRiga('my_table',end);
	}
	
   }
  }); 
}//fine distanza


//data una citt restituisce alt e lng e aggiunge un marker
function codeAddress(address) 
{	
	geocoder.geocode({address: address}, function(results, status){
	     if(status == google.maps.GeocoderStatus.OK){
	 	     var marker = new google.maps.Marker({
	 	 	     map:map,
	 	 	     position:results[0].geometry.location});
	     }
	});

}
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDh-s4q4s_Q0OWTWebTHqVvj7ZoDoAJ348&callback=initMap"> 
</script>
								</br>
								<!-- FINE GESTIONE MAPPA -->
								Seleziona fino a quanti km vuoi trovare i Care Provider a te
								piu' vicini <select id="list"
									onchange="initMap();cancellaRiga();">
								
									<option value="1">1</option>
									<option value="5">5</option>
									<option value="10">10</option>
									<option value="20">20</option>
									<option value="30">30</option>
									<option value="40">40</option>
									<option value="50">50</option>
									<option value="60">60</option>
									<option value="70">70</option>
									<option value="80">80</option>
									<option value="90">90</option>
									<option value="100">100</option>
									<option value="200">200</option>
									<option value="300">300</option>
									<option value="400">400</option>
									<option value="500">500</option>
									<option value="600">600</option>
									<option value="700">700</option>
									<option value="800">800</option>
									<option value="900">900</option>
								</select> </br> </br>
								<div class="panel panel-warning">
									<header>
									</header>
									<div class="panel-heading">
										<strong id="prova">I Care Provider del Registro Elettronico
											Sanitario Personale :</strong>
										
									</div>
									<!--panel-heading-->
								</div>
								<!--panel-warning-->

<script type='text/javascript'>

//Questa funzione aggiunge un rigo alla tabella con le informazioni del careProvider
function aggiungiRiga(id_table,citta){	
	var table = document.getElementById(id_table);
	var tbody = table.getElementsByTagName('tbody')[0];
	var colonne = table.getElementsByTagName('th').length;	
	var td = document.createElement('td');
	
	@for($i=0;$i<$current_user->numero();$i++)

		if("{{($current_user->trovaLocalita()[$i])}}"==citta){
												
		var tr = document.createElement('tr');
		//Aggiungo nome
		var td = document.createElement('td');
		var tx=document.createTextNode("{{($current_user->cpp()[$i]->cpp_nome)}}");
		td.appendChild(tx);
		tr.appendChild(td);
		//Aggiungo cognome
		var td = document.createElement('td');
		var tx=document.createTextNode("{{($current_user->cpp()[$i]->cpp_cognome)}}");
		td.appendChild(tx);
		tr.appendChild(td);
		//Aggiungo ruolo
		var td = document.createElement('td');
		var tx=document.createTextNode("{{($current_user->trovaRuolo()[$i])}}");
		td.appendChild(tx);
		tr.appendChild(td);
		//Aggiungo telefono
		var td = document.createElement('td');
		var tx=document.createTextNode("{{($current_user->trovaTelefono()[$i])}}");
		td.appendChild(tx);
		tr.appendChild(td);
		//Aggiungo altre informazioni
		var td = document.createElement('td');
		var tx=document.createTextNode("{{($current_user->trovaInformazioni()[$i])}}");

		td.appendChild(tx);
		tr.appendChild(td);
		//Aggiungo citta
		var td = document.createElement('td');
		var tx=document.createTextNode("{{($current_user->trovaLocalita()[$i])}}");
		td.appendChild(tx);
		tr.appendChild(td);
		//Aggiungo opzioni
		var td = document.createElement('td');
		var tx = document.createElement('span');
		tx.innerHTML = '<button id="{{($i)}}" type="button" value="{{($current_user->cpp()[$i]->id_cpp)}}" class="icon-plus btn-success" onclick="aggiungiCpp(this.id)"/>';

		td.appendChild(tx);
		tr.appendChild(td);
		
		//aggiungo check
		/*	var td = document.createElement('td');
			var tx = document.createElement('span');
			tx.innerHTML="<div class=dropdown>";
			tx.innerHTML='<button href="#" class="btn btn-info dropdown-toggle dropdown-toggle-unset" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';

			tx.innerHTML='<i class=icon-check />';
			tx.innerHTML='<span class=caret />';
			tx.innerHTML='</>';
			tx.innerHTML='<ul class="dropdown-menu">';
			tx.innerHTML='<li/><a href="http://localhost:8000/1/{{$current_user->id_utente}}/"id="{{($i)}}"/>Nessuan restrizione';
			tx.innerHTML='<li/><a href="http://localhost:8000/2/{{$current_user->id_utente}}/"id="{{($i)}}"/>Basso';
			tx.innerHTML='<li/><a href="http://localhost:8000/3/{{$current_user->id_utente}}/"id="{{($i)}}"/>Moderato';
			tx.innerHTML='<li/><a href="http://localhost:8000/4/{{$current_user->id_utente}}/"id="{{($i)}}"/>Normale';
			tx.innerHTML='<li/><a href="http://localhost:8000/5/{{$current_user->id_utente}}/"id="{{($i)}}"/>Riservato';
			tx.innerHTML='<li/><a href="http://localhost:8000/6/{{$current_user->id_utente}}/"id="{{($i)}}"/>Strettamente riservato';		
			tx.innerHTML='</>';

			td.appendChild(tx);
			tr.appendChild(td);*/

		    //aggiungo mail
			var tx = document.createElement('span');
			tx.innerHTML = '<button id="{{$current_user->trovaMail($current_user->cpp()[$i]->id_cpp)}}" onclick="assegnaValore(this.id)" data-target="#formModal" class="icon-envelope btn-warning" data-toggle="modal" aria-hashpopup="true" aria-expanded="true" />';				
			td.appendChild(tx);
			tr.appendChild(td);

				
	tbody.appendChild(tr);
	}
		@endfor	
	}

	//Questa funzione prende l'id_cpp del Care Provider selezionato
	function aggiungiCpp(num){
		var a = document.getElementById(num).value;
		window.location.href="http://localhost:8000/careproviders/"+a;
			
	
}

//Elimina le righe dalla tabella contenente tutti i care Provider registrati nel Resp
function cancellaRiga(){
    var L = document.getElementById("my_table").rows.length;
		while(L>1){
		document.getElementById("my_table").deleteRow(L - 1);
		L--;
		}		  
}
</script>

<div id="toSetTable" class="table-responsive">

									<body>
										<table id='my_table' class='table'>
											<thead>
												<tr>
													<th>Nome</th>
													<th>Cognome</th>
													<th>Ruolo</th>
													<th>Telefono</th>
													<th>Altre informazioni</th>
													<th>Citta'</th>
													<th>Opzioni</th>
												</tr>

											</thead>
											<tbody>

											</tbody>
										</table>
										<br/>
									</body>

								</div>
								<!--id="toSetTable" class="table-responsive"-->
							</div>
							<!--panelbody-->

							<div class="panel-footer" style="text-align: right"></div>
							<!--panel-footer-->
						</div>
						<!--panel-warning-->
					</div>
					<!--body-->
				</div>
				<!--box-dark-->
			</div>
			<!--col-lg-12-->
		</div>
		<!--row-->
	</div>
	<!--inner-->

</div>
<link href="assets/plugins/bootstrap_slider/css/bootstrap-slider.css"
	rel="stylesheet">

<script src="assets/plugins/bootstrap_slider/js/bootstrap-slider.js"></script>


{{-- @php(include "careProvidersScript.php") --}}
<!--END PAGE CONTENT -->
@endsection @endsection
