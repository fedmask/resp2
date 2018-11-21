

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
	<!-- MAIN WRAPPER -->
	<div id="wrap">
		<!--MESSAGES MODAL -->
		
		<!-- HEADER SECTION -->
		<div id="top">

			<nav class="navbar navbar-inverse navbar-fixed-top " style="padding-top: 10px;">
				<a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
                    <i class="icon-align-justify"></i>
                </a>
			

				<!-- LOGO SECTION -->
				<header class="navbar-header">
				<a href="/home" class="navbar-brand" style="color:#1d71b8; font-size:22px"><img src="/img/logo_icona.png" alt="">&nbsp;
                           R<span style="color:#36a9e1">egistro</span>
                           E<span style="color:#36a9e1">lettronico</span>
						   S<span style="color:#36a9e1">anitario</span>
                           P<span style="color:#36a9e1">ersonale</span>
						   M<span style="color:#36a9e1">ultimediale</span>
						</a>
				</header>
				<!-- END LOGO SECTION -->
				<ul class="nav navbar-top-links navbar-right">
					
					
					<li><a href="/home">Home <em class="icon-home"></em> </a>
					</li>
					
					


					<!--Logout  -->
					<li>
						<a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="icon-signout"></i>
                                            Logout
                                        </a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
					</li>
					<!--END ADMIN SETTINGS -->
				</ul>
			</nav>
		</div>
		<body>
		
		<!-- END HEADER SECTION -->