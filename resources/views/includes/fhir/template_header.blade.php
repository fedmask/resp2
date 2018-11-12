<?php
$id_paz = $current_user->data_patient()->first()->id_paziente;
?>

<link href="/css/icon_chat.css" rel="stylesheet">
<link href="/css/chat_style.css" rel="stylesheet">
<!-- Typeahead plugin -->
<link href="/css/typeahead.css" rel="stylesheet">

<!-- BEGIN BODY-->
<script src="{{ asset('js/jquery-2.0.3.min.js') }}"></script>
<body class="padTop53 ">
	<audio id="notification_audio">
		<source src="/audio/incoming_mex.mp3" type="audio/mpeg"></source>
	</audio>

		<!-- HEADER SECTION -->
		<div id="top">

			<nav class="navbar navbar-inverse navbar-fixed-top " style="padding-top: 10px;">
				<a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
                    <i class="icon-align-justify"></i>
                </a>
			

				<!-- LOGO SECTION -->
				<header class="navbar-header">
				<a class="navbar-brand" style="color:red; font-size:28px"><img src="/img/RESP-FHIR.png" alt="">&nbsp;
                           F<span style="color:orange">ast</span>
                           H<span style="color:orange">ealthcare</span>
						   I<span style="color:orange">nteroperability</span>
                           R<span style="color:orange">esources</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           <img src="/img/logo_icona.png" alt="">&nbsp;
                           <span style="color:#1d71b8">R</span>
                           <span style="color:#1d71b8">E</span>
						   <span style="color:#1d71b8">S</span>
                           <span style="color:#1d71b8">P</span>
				
						</a>
				
						</header>
						
						</nav>
						</div></body>
						
				<!-- END LOGO SECTION -->
				<ul class="nav navbar-top-links navbar-right">
					<!-- HOME SECTION -->

					<!--END ADMIN SETTINGS -->
				</ul>
			</nav>
		</div>
		
		
		<!-- END HEADER SECTION -->