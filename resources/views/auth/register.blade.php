@extends( 'auth.layouts.basic_registration' )
@extends( 'auth.layouts.registration_head' )

@section( 'pageTitle' )
@section('register_content')
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
			<div class="col-lg-12">
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
	</section>
@endsection