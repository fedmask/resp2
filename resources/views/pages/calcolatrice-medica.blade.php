@extends( 'layouts.app' )
@extends( 'includes.template_head' )

@section( 'pageTitle', 'Calcolatrice Medica' )
@section( 'content' )
	<!--PAGE CONTENT -->
	
	<!-- TODO: Aggiungere dal vecchio template (template_page_calc) tutto il codice riguardante il settaggio di altezza peso, ecc... -->
	<div id="content">
		<div class="inner" style="min-height:1200px;">
			<div class="row">
				<div class="col-lg-12">
					<h2>Calcolatrice Medica <i class = "icon-keyboard"></i></h2>
					<hr>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>

									<th>peso</th>
									<th>altezza</th>
									<th>creatininemia</th>
								</tr>
							</thead>
							<tbody>
								<tr>
								<!-- TODO: questi valori derivano dallo script a cui fa riferimento il commento alla riga 8 -->
									<td><input id="peso" type="number" step="any" placeholder="Kg" min=5 max=2 00 value="0">
									</td>
									<td><input id="altezza" type="number" step="1" placeholder="cm" min=8 0 max=2 30 value="0">
									</td>
									<td><input id="creatininemia" type="number" step="0.1" placeholder="mg/dl" min=0.1 max=13 value="1">
									</td>
								</tr>
								<tr>
									<td><input id="eta" type="hidden" value="{{$user->getAge($user->getBirthdayDate())}}"/>
									</td>
									<td><input id="sesso" type="hidden" value="{{$user->getGender()}}"/>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!--table-responsive-->
					<div class="accordion ac" id="accordion2calc">
						<div class="accordion-group">
							<div class="row">
								<div class="accordion-heading centered">
									<div class="col-lg-12">
										<div class="col-lg-4">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2calc" href="#collapseDosi">
														<h3>Calcolo dosi 
															<span >
															  <i  class="icon-angle-down"></i>
															</span>           	
														</h3>
													</a>
										
										</div>
										<div class="col-lg-4">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2calc" href="#collapseClearance">
														<h3>Calcolo Clearance  
															<span >
															  <i  class="icon-angle-down"></i>
															</span>           	
														</h3>
													</a>
										
										</div>
									</div>
								</div>
								<!--accordion- group heading centered-->
							</div>
							<!--row-->
							<div id="collapseDosi" class="accordion-body collapse">
								<div class="accordion-inner">
									<div class="row">
										<div class="col-lg-12">
											<h3>
												<center>posologia</center>
											</h3>
											<p>Il sistema fornisce un supporto. E' compito e responsabilit&agrave del prescrittore verificare la corretta posologia.</p>
										</div>
										<!--col-lg-12-->
										<div class="col-lg-4">
											<div class="panel panel-warning">

												<div class="panel-heading">
													<strong>Dose in base al peso o alla superficie corporea</strong>
												</div>
												<div class="panel-body">
													<table>
														<tr>
															<td><label> dose (mg/Kg) </label>
															</td>
														</tr>
														<tr>
															<td><input id="dose" type="number" step="0.1" placeholder="mg/Kg" min=0/>
															</td>
														</tr>
														<tr>
															<td><label> dose (mg/mq) </label>
															</td>
														</tr>
														<tr>
															<td><input id="dose_mq" type="number" step="0.1" placeholder="mg/mq" min=0/>
															</td>
														</tr>
														<tr>
															<td><label> somministrazioni</label>
															</td>
														</tr>
														<tr>
															<td><input id="somministrazioni" type="number" step="1" placeholder=" numero al giorno" min=1 max=6 value="1"/>
															</td>

														</tr>
														<tr>
															<td><button onclick="calcolaDose()"> calcola </button><button onclick="cancella()"> cancella </button>
															</td>
															<td></td>
														</tr>
													</table>
												</div>
												<!--panelbody-->

												<div class="panel-footer">
													<label>dose totale : </label><span id="doseCalcolata"></span><span><label>mg</label></span>
													<br>
													<label>dose singola : </label><span id="singSomm"></span> <span><label>mg</label></span>
												</div>


											</div>
											<!-- panel panel-warning">-->
										</div>
										<!--col-lg-4-->
										<div class="col-lg-4">
											<div class="panel panel-info">

												<div class="panel-heading">
													<strong>Calcolo della velocit&agrave di infusione</strong>
												</div>
												<div class="panel-body">
													<table>

														<tr>
															<td><label>dose da infondere</label>
															</td>
														</tr>
														<tr>
															<td><input id="doseDaInf" type="number" step="1" placeholder="mcg/Kg/min" min=1>
															</td>
														</tr>
														<tr>
															<td><label> contenuto fiala  </label>
															</td>
														</tr>
														<tr>
															<td><input id="doseFiala" type="number" step="any" placeholder="mg">
															</td>
														</tr>

														<tr>
															<td><label>  fiale diluite </label>
															</td>
														</tr>
														<tr>
															<td><input id="num_fiale" type="number" step="1" placeholder="numero" min=1 value="1"/>
															</td>
														</tr>
														<tr>
															<td><label>volume flebo</label>
															</td>
														</tr>
														<tr>
															<td><input id="volFlebo" type="number" step="50" placeholder=" millilitri" min=1 00 max=5 00 value="250"/>
															</td>

														</tr>
														<tr>
															<td><button onclick="calcolaVel()"> calcola </button><button onclick="cancellaVel()"> cancella </button>
															</td>
															<td></td>
														</tr>
													</table>
												</div>
												<!--panel body-->
												<div class=" panel-footer">
													<label>concentrazione : </label><span id="concentrazione"></span><span><label>mg/ml</label></span>
													<br>
													<label>velocit&agrave di infusione: </label><span id="velInfusione"></span> <span><label>ml/ora</label></span>
												</div>
												<!--panel-footer-->

											</div>
											<!-- panel panel-info"-->
										</div>
										<!--col-lg-4-->
										<div class="col-lg-4">
											<div class="panel panel-success">

												<div class="panel-heading">
													<strong>Gocce-MILLILITRI</strong>
												</div>
												<div class="panel-body">
													<table>

														<tr>
															<td><label>Contenuto Soluzione (mg)</label>
															</td>
														</tr>
														<tr>
															<td><input id="Cont_Sol" type="number" step="0.1" placeholder="mg" min=1 value="1"/>
															</td>
														</tr>
														<tr>
															<td><label> Volume Soluzione (ml)  </label>
															</td>
														</tr>
														<tr>
															<td><input id="Vol_Sol" type="number" step="0.1" placeholder="ml" min=1 value="1"/>
															</td>
														</tr>
														<tr>
															<td><label>  Posologia ( mg) </label>
															</td>
														</tr>
														<tr>
															<td><input id="posologiaMg1" type="number" step="0.1" placeholder="mg">
															</td>
														</tr>
														<tr>
															<td><label>  gocce per millilitro </label>
															</td>
														</tr>
														<tr>
															<td><input id="goccePerMl" type="number" step="1" placeholder="num_gocce" value="20"/>
															</td>
														</tr>
														<tr>
															<td><button onclick="calcolaMl()"> calcola </button><button onclick="cancellaMl()"> cancella </button>
															</td>
														</tr>
													</table>

												</div>
												<!--panel body-->
												<div class=" panel-footer">

													<label>MILLILITRI : </label><span id="N_millilitri"></span><span><label>ml</label></span>
													<br>
													<label>Numero: </label><span id="N_gocce"></span> <span><label>gocce</label></span>
												</div>
												<!--panel-footer-->


											</div>
											<!-- panel panel-success"-->
										</div>
										<!--col-lg-4-->
									</div>
									<!--row-->
								</div>
								<!--accordion inner-->
							</div>
							<!--accordion-body collapse-->

							<div id="collapseClearance" class="accordion-body collapse">
								<div class="accordion-inner">
									<div class="row">
										<h3>
											<center>clearance</center>
										</h3>
										<div class="col-lg-6">
											<div class="panel panel-info">
												<div class="table-responsive">
													<table class="table">
														<tr>
															<td><button onclick="calcolaCreat()"> calcola </button>
															</td>
															<td>Formula di Cockcroft - Gault</td>
														</tr>
													</table>
													<p><label>Clearance della creatinina : </label><span id="creatClear"></span><span><label>ml/min</label></span>
													</p>
												</div>
												<!-- table-responsive-->
											</div>
											<!-- panel panel-info"-->
										</div>
										<!--col-lg-6-->
										<div class="col-lg-6">
											<div class="panel panel-info">
												<div class="table-responsive">
													<table class="table">
														<tr>
															<td><button onclick="calcolaCreat1()"> calcola </button>
															</td>
															<td>Con creatininuria e volume urinario </td>
														</tr>
														<tr>
															<td>creatininuria</td>
															<td><input id="creatininuria" type="number" step="1" placeholder="mg/dl" min=1 max=2 00 value="1"/>
															</td>
														</tr>
														<tr>
															<td>diuresi</td>
															<td><input id="diuresi" type="number" step="50" placeholder="ml" value="1000"/>
															</td>
														</tr>
													</table>
													<p><label>Clearance della creatinina : </label><span id="creatClear1"></span><span><label>ml/min</label></span>
													</p>
												</div>
												<!-- table-responsive-->
											</div>
											<!-- panel panel-info"-->
										</div>
										<!--col-lg-6-->


									</div>
									<!--row-->
								</div>
								<!--accordion inner-->
							</div>
							<!--accordion-body collapse-->
						</div>
						<!--accordion group-->
					</div>
					<!--accordion ac 2calc-->
				</div>
				<!--col-lg-12-->
			</div>
			<!--row-->
			<hr/>
		</div>
		<!--inner-->
	</div>
	<!--content-->
	<!--END PAGE CONTENT -->
	@endsection