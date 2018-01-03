<script>
	window.onload = function(){

	var map;
	var geocoder;
	var bounds = new google.maps.LatLngBounds();
	var markersArray = [];
	var markersArraySet = [];
	var addressArrayJSON;
	var addressArrayJSONSet;

	var origin;
	var destination;

	var destinationIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=D|FF0000|000000';
	var originIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=O|FFFF00|000000';

	var kmSlider;
	var startZone;

	var issetCpp = "<?php echo ($this->is_set('isCpp') ? 'true' : 'false') ?>";
	var userId = "<?php echo $this->get_var('numCp') ?>";
	var issetCpp = "<?php echo ($this->is_set('isCpp') ? 'true' : 'false') ?>";// "<?php if($this->is_set('isCpp')) echo true; else echo false; ?>";
	var emailArray = <?php  echo (!empty($emailArray)) ?  json_encode($emailArray) : 'null' ?>;
	var emailArraySet = <?php echo json_encode($emailArray_set) ?>;
	
	var userMail = "<?php echo $this->get_var('userMail') ?>";
	
	$('.btn-mailCpp').click(function(){
		//console.log("email selected: " + emailArray[$(this).val()]);
		//$('#mailModal').show();
		$("#mailCpp").val(emailArray[$(this).val()]);		
		$('input[name="mailCpp"]').val(emailArray[$(this).val()]);
	});
	
	$('.btn-mailCppSet').click(function(){
		//console.log("emailSet selected: " + emailArraySet[$(this).val()]);
		$("#mail").val(emailArraySet[$(this).val()]);
		$('input[name="mailCpp"]').val(emailArraySet[$(this).val()]);
	});

	
	$('#mailModal').on('hidden.bs.modal', function(){
		$('#patmailformcpp')[0].reset();
	});
	
	
	
	
	$('#patmailformcpp').validate({
			rules: {
				contentMail: "required",
				mailSubject: "required"
			},
			errorClass: 'help-block col-lg-6',
			errorElement: 'span',
			highlight: function (element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
			},
			unhighlight: function (element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
			},
			submitHandler: function(event) { 
			
				$.post("formscripts/sendpatmailCpp.php",
				{
					sender: userMail,
					nomeutente:		$("#username").val(),
					mail:			$("#mailCpp").val(),
					oggettomail:	$("#mailSubject").val(),
					contenuto:		$("#contentMail").val()
				},
				function(status){
					$('#patmailformcpp')[0].reset();
					alert("Status: " + status);
					$('#mailModal').modal('hide');
				});
			}
	});// fine $('#patmailform').validate
	
	
	$('.buttonAdd').click(function(){
		var cppConf = $('#dropdownMenu_'+$(this).val().split(' ')[1]).val();
		 $.ajax({
				  type: "POST",
				  url: "formscripts/addCareProvider.php",
				  dataType: "json",
				  data: {'idCare' : $(this).val(), 'cppConf': cppConf},
				  success: function(msg) {
					//console.log("Answer: " + msg.answer);
					location.reload();//window.location.replace("http://fsem.di.uniba.it/index.php?pag=cproviders");
				  },
				  error: function(msg){
					//console.log("Error: " + msg.error);
				  }
				  
				});
		//alert("buttonAdd: " + $(this).val());
	});
	
	$('.buttonDelete').click(function(){
		$.ajax({
				  type: "POST",
				  url: "formscripts/deleteCareProvider.php",
				  dataType: "json",
				  data: {'idCare' : $(this).val()},
				  success: function(msg) {
					//console.log("Answer: " + msg.answer);
					location.reload();//window.location.replace("http://fsem.di.uniba.it/index.php?pag=cproviders");
				  },
				  error: function(msg){
					//console.log("Error: " + msg.error);
				  }
				  
				});
		//alert("buttonDelete: " + $(this).val());
	});
	
	kmSlider = new Slider('#kmThresh', {
		formatter: function(value) {
			return 'Distanza dal domicilio: ' + value + " km";
		},
		min:0,
		max:1000
	});//Slider

	/*$('#ex1Slider').on('mousedown', function() {
			var shown=true;
			shown ? $(this).hideBalloon() : $(this).showBalloon();
			shown = !shown;
		}).showBalloon( { contents: '<p>Trascina lo slider per vedere i CareProvider a te più vicini!</p>' ,css: {
		border: 'solid 4px #149BDF ',
		padding: '10px',
		fontSize: '120%',
		fontWeight: 'bold',
		lineHeight: '3',
		backgroundColor: '#EFE9E5',
		color: '#149BDF ',
		top: $('#ex1Slider').position().top + " px",
		left: $('#ex1Slider').position().left + " px"
		
	  }});*/
	  
	  
	
	  //google.maps.event.addDomListener(window, 'load', initialize);

	initialize();
	
	
	
	/*

	*/
	function codeAddress(address) {
		var longlat;
		geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			longlat = results[0].geometry.location;
			
			map.setCenter(results[0].geometry.location);
			
			var marker = new google.maps.Marker({
				map: map,
				position: results[0].geometry.location
			});
			map.setZoom(10);
			return longlat;
		} else if (status === google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {    
				setTimeout(function() {
					codeAddress(address);
				}, 2000);
		}else {
		  //alert('Geocode was not successful for the following reason: ' + status);
		}
	  });
	}//codeAddress



	function initialize() {
		
		var numCp = "<?php echo $this->get_var('numCp') ?>";
		var numCpSet = "<?php echo $this->get_var('numCpSet') ?>";
		
		startZone = "<?php echo $this->get_var('userCity')." ".$this->get_var('userAddress') ?>";
		//console.log("start: " + startZone);
		var opts = {
			zoom: 10
			};
		
		map = new google.maps.Map(document.getElementById('map-canvas'), opts);
		
		geocoder = new google.maps.Geocoder();	
		
		
		//codeAddress(startZone);
		
		var lat,lng = "null";
		
		var dropdownPush=0;

		$(".dropdown-toggle").on("contextmenu",function(event){
			var caller = event.target.id;
			var ext = caller.split('_')[1];
			
			if(dropdownPush == 1){
				$('#toSetTable').css('min-height', ($('#toSetTable').height() - $('#setLevelCpp_'+ext).height())+'px');
				dropdownPush = !dropdownPush;
			}
		}); 

		
		$('.dropdown-toggle-unset').click(function(event){
			
			dropdownPush = !dropdownPush;
			//$('#setLevelCpp').show();
			var caller = event.target.id;
			var ext = caller.split('_')[1];

			var min= $('#setLevelCpp_'+ext).css('display');
			//console.log("display: " + min);

			if(( $('#setLevelCpp_'+ext).css('display') == 'none' ) && dropdownPush==0){
				//console.log("none!");
				dropdownPush=1;
				$('#toSetTable').css('min-height', ($('#toSetTable').height() - $('#setLevelCpp_'+ext).height())+'px');
				  //$('#toSetTable').css('min-height', ($('#toSetTable').height()  + $('#setLevelCpp_'+ext).height())+'px');
			}
			
			
			
			if(dropdownPush == 1){
				$('#toSetTable').css('min-height', ($('#toSetTable').height()  + $('#setLevelCpp_'+ext).height())+'px');



				


				

				
				//$('#toSetTable').css('min-height', ($('#toSetTable').height() + 100)+'px');
			}else
				$('#toSetTable').css('min-height', ($('#toSetTable').height() - $('#setLevelCpp_'+ext).height())+'px');
		});
		
		$('.cppLevel').click(function(event){
			//console.log("trigger: " + event.target.id + " value: " + event.target.getAttribute("value"));
			$('#dropdownMenu_'+event.target.getAttribute("value")).html('Livello '+event.target.id + '<span class="caret"></span>');
			$('#dropdownMenu_'+event.target.getAttribute("value")).val(event.target.id);


			
			$('.dropdown-toggle-unset').trigger( "click" );
		});

		
		
		//Mod for set careproviders
		$('.dropdown-toggle-set').click(function(event){
			
			dropdownPush = !dropdownPush;
			//$('#setLevelCpp').show();
			var caller = event.target.id;
			var ext = caller.split('_')[1];

			var min= $('#setLevelCppSet_'+ext).css('display');
			//console.log("displaySet: " + min);

			if(( $('#setLevelCppSet_'+ext).css('display') == 'none' ) && dropdownPush==0){
				//console.log("noneSet!");
				dropdownPush=1;
				$('#toSetTableSet').css('min-height', ($('#toSetTableSet').height() - $('#setLevelCppSet_'+ext).height())+'px');
				  //$('#toSetTable').css('min-height', ($('#toSetTable').height()  + $('#setLevelCpp_'+ext).height())+'px');
			}
			
			
			
			if(dropdownPush == 1){
				$('#toSetTableSet').css('min-height', ($('#toSetTableSet').height()  + $('#setLevelCppSet_'+ext).height())+'px');
				
				
				
				//$('#toSetTable').css('min-height', ($('#toSetTable').height() + 100)+'px');
			}else
				$('#toSetTableSet').css('min-height', ($('#toSetTableSet').height() - $('#setLevelCppSet_'+ext).height())+'px');
		});
		
		
		$('.cppLevelSet').click(function(event){
			var cppConf = $('#dropdownMenuSet_'+$(this).val().split(' ')[1]).val();
			//console.log("trigger change confidentialitySet: " + event.target.id + " value: " + event.target.getAttribute("value"));
			
			//$('#dropdownMenuSet_'+event.target.getAttribute("value")).html('Livello '+event.target.id + '<span class="caret"></span>');
			//$('#dropdownMenuSet_'+event.target.getAttribute("value")).val(event.target.id);
			
			//$('.dropdown-toggle-set').trigger( "click" );
			
			$.ajax({
				  type: "POST",
				  url: "formscripts/modifyConfidentiality.php",
				  dataType: "json",
				  data: {'idCare' : event.target.getAttribute("value"),'cppConf' : event.target.id},
				  success: function(msg) {
					//console.log("Answer: " + msg.answer);
					location.reload();//window.location.replace("http://fsem.di.uniba.it/index.php?pag=cproviders");
				  },
				  error: function(msg){
					//console.log("Error: " + msg.error);
				  }
				  
			});
			
		});
		//INSERT MOD.
		

	  
		kmSlider.on('slideStop', function(event){
				deleteOverlays();			
				
				//console.log('array: '+ addressArrayJSON);
			if(addressArrayJSON.length !=0)
				updateMarkers(addressArrayJSON,"false");
				
				
				
				if(issetCpp == "true"){
				
					//updateMarkers(addressArrayJSONSet,"true");
				}			
			
		}); //kmSlider.on
		
		
		
		
		
		google.maps.event.addListenerOnce(map, "center_changed", function() {
			lat = map.getCenter().lat();
			lng = map.getCenter().lng();
			
			//console.log("actual coordinate: " + lat + " " + lng); 
		});
		
		addressArrayJSON = <?php echo json_encode($addressArray) ?>;
		//check if array is empty
	if(addressArrayJSON.length !=0)
		updateMarkers(addressArrayJSON,"false");
		
		if(issetCpp == "true"){
			addressArrayJSONSet = <?php echo json_encode($addressArray_set) ?>;
			if(addressArrayJSONSet.length !=0)
				updateMarkers(addressArrayJSONSet,issetCpp);
		}
		
		
		
		
		
	}//initialize

	function updateMarkers(addressArrayJSON,set){
			calculateDistances(startZone,addressArrayJSON,set);		
	}

	function calculateDistances(origin,destination,set) {
		
		var service = new google.maps.DistanceMatrixService();
	  
		service.getDistanceMatrix(
		{
		  origins: [origin],
		  destinations: destination,
		  //Beware from the driving...
		  travelMode: google.maps.TravelMode.DRIVING,
		  unitSystem: google.maps.UnitSystem.METRIC,
		  avoidHighways: false,
		  avoidTolls: false
		}, function(response, status) {calcDistance(response, status, set)});
	}//calculateDistances

	function calcDistance(response, status,set) {
	  if (status != google.maps.DistanceMatrixStatus.OK) {
		alert('Error was: ' + status);
	  } else {
		var origins = response.originAddresses;
		var destinations = response.destinationAddresses;
		var kmThresh = kmSlider.getValue()*1000;
		deleteOverlays();
		
		for (var i = 0; i < origins.length; i++) {
		  var results = response.rows[i].elements;

		  //Add Start Point Marker
		  addMarker(origins[i], false,"start");
		  
		  for (var j = 0; j < results.length; j++) {
			//console.log("distance: " + results[j].distance.value);
			
			if(set == "false"){
				if(results[j].distance.value < kmThresh){
					addMarker(destinations[j], true,j,'FF0000');
					$('#careProvider'+j).show();
				}else{
					$('#careProvider'+j).hide();
				}
			}else{
				addMarker(destinations[j], true,j,'00FF00');
			
				$('#careProviderSet'+j).show();
			}
		  }
		}
	  }
	}//calcDistance

	function addMarker(location, isDestination,num,color) {
		var name;
		var surname;
		var address;
		var icon;
		 if (isDestination) {
			icon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=|'+color+'|000000';
			} else {
			icon = originIcon;
			}
		geocoder.geocode({'address': location}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				 bounds.extend(results[0].geometry.location);
				 map.fitBounds(bounds);
		  
		var marker;
		var contentString = "";
		
		if(num!= "start"){
			
			marker = new google.maps.Marker({
				map: map,
				position: results[0].geometry.location,
				icon: icon,
				title: "careProvider"+num,
				clickable: true,
				optimized: false
			});
			
			if(color === '00FF00'){
				markersArraySet.push(marker);
				name  = <?php echo json_encode($nameArray_set) ?>;
				surname  = <?php echo json_encode($surnameArray_set) ?>;
				address  = <?php echo json_encode($addressArray_set) ?>;
			}else{
				markersArray.push(marker);
				name  = <?php echo json_encode($nameArray) ?>;
				surname  = <?php echo json_encode($surnameArray) ?>;
				address  = <?php echo json_encode($addressArray) ?>;
			}
			contentString = '<div id="content">'+
			  '<div id="siteNotice">'+
			  '</div>'+
			  '<h3 id="firstHeading" class="firstHeading">'+
			   name[num]+" "+surname[num]+
			  '</h3>'+
			  '<div id="bodyContent">Indirizzo: '+
			  address[num]+
			  '</div>'+
			  '</div>';
		}else{
			marker = new google.maps.Marker({
				map: map,
				position: results[0].geometry.location,
				icon: icon,
				title: num,
				clickable: true,
				optimized: false
				});
			
			 markersArray.push(marker);		

			
			var name  = "<?php echo $this->get_var('userName') ?>";
			var surname  = "<?php echo $this->get_var('userSurname') ?>";
			var address  = "<?php echo $this->get_var('userAddress')." ".$this->get_var('userCity') ?>";
			
			contentString = '<div id="content">'+
			  '<div id="siteNotice">'+
			  '</div>'+
			  '<h3 id="firstHeading" class="firstHeading">'+
			   name+" "+surname+
			  '</h3>'+
			  '<div id="bodyContent">Indirizzo: '+
			  address+
			  '</div>'+
			  '</div>';  
		}
		  
		var infowindow = new google.maps.InfoWindow({
			content: contentString
		});

		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
			map.setZoom(14);
		});
		
		} else if (status === google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {    
				setTimeout(function() {
					//addMarker(location, isDestination,num,color);
					addMarker(location, isDestination);
				}, 2000);
		} else {
		  //alert('Geocode was not successful for the following reason: '   + status);
		}
	  });
	}//addmarker

	function deleteOverlays() {
		for (var i = 0; i < markersArray.length; i++) {
			markersArray[i].setMap(null);
		}	
		markersArray = [];
	}

	google.maps.event.addListenerOnce(map, 'tilesloaded', function(){
		
		/*
		$('.dropdown-toggle-set').on('mouseover', function(){
		console.log("hover dropdown!");
		$(this).showBalloon();			
	}).showBalloon( { contents: '<p>Cambia il livello di confidenzialità!</p>' ,css: {
		border: 'solid 4px #149BDF ',
		padding: '10px',
		fontSize: '120%',
		fontWeight: 'bold',
		lineHeight: '3',
		backgroundColor: '#EFE9E5',
		color: '#149BDF '		
	}});
	  
	$('.dropdown-toggle-set').on('mouseout', function(){
		console.log("out dropdown!");
		$(this).hideBalloon();
	});
	*/
	$('.dropdown-toggle-set').balloon({ contents: '<p>Cambia il livello di confidenzialità!</p>' ,css: {
		border: 'solid 4px #149BDF ',
		padding: '10px',
		fontSize: '120%',
		fontWeight: 'bold',
		lineHeight: '3',
		backgroundColor: '#EFE9E5',
		color: '#149BDF '		
	}});
	
	
	
	$('.btn-mailCpp').balloon({ contents: '<p>Invia una mail!</p>' ,css: {
		border: 'solid 4px #149BDF ',
		padding: '10px',
		fontSize: '120%',
		fontWeight: 'bold',
		lineHeight: '3',
		backgroundColor: '#EFE9E5',
		color: '#149BDF '		
	}});
	
	$('.btn-mailCppSet').balloon({ contents: '<p>Invia una mail!</p>' ,css: {
		border: 'solid 4px #149BDF ',
		padding: '10px',
		fontSize: '120%',
		fontWeight: 'bold',
		lineHeight: '3',
		backgroundColor: '#EFE9E5',
		color: '#149BDF '		
	}});
	
	$('.dropdown-toggle-unset').balloon({ contents: '<p>Imposta il livello di confidenzialità!</p>' ,css: {
		border: 'solid 4px #149BDF ',
		padding: '10px',
		fontSize: '120%',
		fontWeight: 'bold',
		lineHeight: '3',
		backgroundColor: '#EFE9E5',
		color: '#149BDF '		
	}});
	
	
	
	$('#ex1Slider').on('mousedown', function() {
			var shown=true;
			shown ? $(this).hideBalloon() : $(this).showBalloon();
			shown = !shown;
		}).showBalloon( { contents: '<p>Trascina lo slider per vedere i CareProvider a te più vicini!</p>' ,css: {
		border: 'solid 4px #149BDF ',
		padding: '10px',
		fontSize: '120%',
		fontWeight: 'bold',
		lineHeight: '3',
		backgroundColor: '#EFE9E5',
		color: '#149BDF ',
		top: $('#ex1Slider').position().top + " px",
		left: $('#ex1Slider').position().left + " px"
		
	  }});
	//alert("slider top: " + $('#ex1Slider').position().top + " px" + " Slider left: " + $('#ex1Slider').position().left + " px");
	});
	
}//windowsonload
</script>