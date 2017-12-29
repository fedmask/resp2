@extends('layouts.app')
@extends('includes.template_head')

@section('pageTitle', 'Links')
@section('content')
<!--PAGE CONTENT -->
<!--utilità per i pazienti Ospedali - Linee guida -->    
		<div id="content">
           <div class="inner" >
		   <div class="col-lg-12"><h1><center> Utility </center></h1>
			</div>
			<div class="accordion ac" id="accordionUtility">
							<div class="accordion-group">
								<div class="accordion-heading centered">
									<div class = "col-lg-12">
										<div  class = "col-lg-3">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionUtility" href="#Ospedali">
												<h3>Ospedali</h3>
											</a>
										</div>
										<div  class = "col-lg-3">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionUtility" href="#LineeGuida">
												<h3>Linee Guida</h3>
											</a>
										</div>
										<div  class = "col-lg-3">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionUtility" href="#RisorseWeb">
												<h3>Risorse Web</h3>
											</a>
										</div>
										<div  class = "col-lg-3">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionUtility" href="#Riviste">
												<h3>Riviste </h3>
											</a>
										</div>
									</div><!--col-lg-12-->
							</div><!--accordion- group heading centered-->
							
								<div id="Ospedali" class="accordion-body collapse">
									<div class="accordion-inner">	
										<div class ="row">
										    <h3><center>Ospedali</center></h3>
											
											<!--Accordion Ospedali-->
												<div class="accordion-group" id = "ac-Osp">
													<div class="col-lg-12"> 
														<div class="panel warning" >
															<div class = "panel-heading">
																<div  class = "col-lg-12" class = "panel-title">
																	<a class="accordion-toggle" data-toggle="collapse" data-parent="#ac-Osp" href="#OspItaliani">
																		<h2>Italiani</h2>
																	</a>
																</div>
																
															</div><!--panel-heading--> 
															
																<div id="OspItaliani" class="accordion-body collapse">
																	<div class="panel-body">
																	
																	<div class="table-responsive" >
																		<table class="table" >
																			<thead>
																				<tr>
																					<th>Nome Ospedale</th>
																					<th>Sede</th>
																					<th col = 2 >Informazioni</th>
																				</tr>													
																			</thead>
																			<tbody>
																				<tr>
																					<td><a href ='http://www.sanita.puglia.it/portal/page/portal/SAUSSC/Aziende%20Sanitarie/AZIENDE%20OSPEDALIERE/Azienda%20Ospedaliero%20Universitaria%20Consorziale%20Policlinico' target="_blank">Policlinico di Bari</a></td>
																					<td>Bari</td>
																					<td>Policlinico Universitario</td>
																				</tr>
																				<tr>
																					<td><a href ='http://www.sanita.puglia.it/portal/page/portal/SAUSSC/Aziende%20Sanitarie/AZIENDE%20OSPEDALIERE/I.R.C.C.S%20Ospedale%20Oncologico%20Giovanni%20Paolo%20II%20Bari' target="_blank">Giovanni Paolo II</a></td>
																					<td>Bari</td>
																					<td>Istituto Tumori</td>
																				</tr>
																				<tr>
																					<td><a href ='https://www.ieo.it/' target="_blank">Istituto Europeo di Oncologia</a></td>
																					<td>Milano</td>
																					<td>Istituto Tumori</td>
																				</tr>
																				<tr>
																					<td><a href ='http://www.meyer.it/'target="_blank">Ospedale Meyer</a></td>
																					<td>Firenze</td>
																					<td>Ospedale pediatrico</td>
																				</tr>
																				<tr>
																					<td><a href ='http://www.ospedalebambinogesu.it/'target="_blank">Ospedale Bambin Gesù</a></td>
																					<td>Roma</td>
																					<td>Ospedale pediatrico</td>
																				</tr>
																			</tbody>
																		</table>
																											
																	</div><!--table-responsive-->
																	</div><!--panel body-->
																</div><!--OspItaliani--->
																<div class = "panel-heading">
																<div  class = "col-lg-12" class = "panel-title">
																	<a class="accordion-toggle" data-toggle="collapse" data-parent="#ac-Osp" href="#OspEsteri">
																		<h2>Esteri</h2>
																	</a>
																</div>
															</div><!--panel-heading--> 
															<div id="OspEsteri" class="accordion-body collapse">
														
															<div class="panel-body">
															
															<div class="table-responsive" >
																<table class="table" >
																	<thead>
																		<tr>
																			<th>Nome Ospedale</th>
																			<th>Sede</th>
																			<th col = 2 >Informazioni</th>
																		</tr>													
																	</thead>
																	<tbody>
																		<tr>
																			<td><a href ='http://www.gustaveroussy.fr/en'target="_blank">Istituto Gustave Roussy</a></td>
																			<td>Parigi</td>
																			<td>Centro di oncologia</td>
																		</tr>
																		<tr>
																			<td><a href ='http://www.barraquer.com/en/' target="_blank">Centro Barraquer</a></td>
																			<td>Barcellona</td>
																			<td>Centro oculistico</td>
																		</tr>
																		<tr>
																			<td><a href ='http://www.mayoclinic.org/' target="_blank">Mayo Clinic</a></td>
																			<td>Rochester-Stati Uniti</td>
																			<td>Uno dei migliori ospedali degli USA</td>
																		</tr>
																		<tr>
																			<td><a href ='http://www.childrenshospital.org/' target="_blank">Boston Children's Hospital</a></td>
																			<td>Boston-Stati Uniti</td>
																			<td>Migliore pediatria degli USA</td>
																		</tr>
																		<tr>
																			<td><a href ='http://my.clevelandclinic.org/' target="_blank">Cleveland Clinic</a></td>
																			<td>Ohio Stati Uniti</td>
																			<td></td>
																		</tr>
																		<tr>
																			<td><a href ='http://www.cedars-sinai.edu/' target="_blank">Cedars-sinai</a></td>
																			<td>Los Angeles Stati Uniti</td>
																			<td></td>
																		</tr>
																		<tr>
																			<td><a href ='http://www.hopkinsmedicine.org/about/centers_departments/index.html' target="_blank">Johns Hopkins Medicine</a></td>
																			<td>Stati Uniti</td>
																			<td></td>
																		</tr>
																		
																	</tbody>
																</table>
																									
															</div><!--table-responsive-->
															
															</div><!--panel body-->
															
															</div><!--OspEsteri--->
															</div><!--panel warning-->
														 
													 </div><!--col-lg-12-->
												</div><!--accordion-group ac-Osp-->
										</div><!--row-->
								   </div><!--accordion inner-->
								</div><!--accordion-body collapse-->
								<div id="LineeGuida" class="accordion-body collapse">
									<div class="accordion-inner">
										<div class = "row">	
										<h3><center>Linee Guida</center></h3>
										<!--Accordion Linee Guida-->
											<div class="accordion-group" id = "ac-LineeGuida">
												<div class="col-lg-12"> 
													<div class="col-lg-12">
														<div class = "panel-heading">
																<div  class = "col-lg-6" class = "panel-title">
																	<a class="accordion-toggle" data-toggle="collapse" data-parent="#ac-LineeGuida" href="#L_G_Italiane">
																		<h2>Italiane</h2>
																	</a>
																</div><!--panel-title-->
																<div  class = "col-lg-6" class = "panel-title">
																	<a class="accordion-toggle" data-toggle="collapse" data-parent="#ac-LineeGuida" href="#L_G_Internazionali">
																		<h2>Internazionali</h2>
																	</a>
																</div><!--panel-title-->
														</div><!--panel-heading-->
													</div> <!--col-lg-12-->
													
														<div class="col-lg-6"> 
															<div class="panel panel-danger">
																<div id="L_G_Italiane" class="accordion-body collapse">
																	<div class="panel-body">
																		
																			<ul>
																				<li><a href = "http://www.snlg-iss.it/lgn#" target="_blank" >Linee Guida Nazionali</a></li>
																				<li><a href ="http://www.salute.gov.it/imgs/C_17_pubblicazioni_1164_allegato.pdf" target="_blank">Linee guida alla diagnostica per immagini</a></li>
																				<li></li>
																			</ul>
																	</div>
																</div><!--accordion-body collapse-->
															</div>
														 </div>
														<div class="col-lg-6"> 
															<div class="panel panel-danger">
																<div id="L_G_Internazionali" class="accordion-body collapse">
																	<div class="panel-body">
																		
																			<ul>
																				<li><a href ="http://www.g-i-n.net/library/international-guidelines-library" target="_blank">Biblioteca Internazionale delle Linee Guida</a></li>
																				<li><a href ="http://www.escardio.org/Guidelines-&-Education/Clinical-Practice-Guidelines/ESC-Clinical-Practice-Guidelines-list/listing" target="_blank">Società Europea di Cardiologia</a></li>
																				<li><a href ="http://pathways.nice.org.uk/" target="_blank">National Institute for Clinical Excellence</a></li>
																				<li><a href ="http://www.sign.ac.uk/#" target="_blank">SIGN</a></li>
																			</ul>
																	</div>
																</div><!--accordion-body collapse-->
															</div>
														</div>
												</div><!--col-lg-12-->
											</div><!--accordion LineeGuida-->
										</div><!--row-->
									</div><!--accordion inner-->
								</div><!--accordion-body collapse-->	
							
								<div id="RisorseWeb" class="accordion-body collapse">
									<div class="accordion-inner">
										<div class="row">
											<h3><center>Risorse Web</center></h3>
											<!--Accordion Risorse Web-->
											<div class="accordion-group" id = "ac-RisorseWeb">
												<div class="col-lg-12">	
													<div class="col-lg-12">
														<div class = "panel-heading">
																<div  class = "col-lg-6" class = "panel-title">
																	<a class="accordion-toggle" data-toggle="collapse" data-parent="#ac-RisorseWeb" href="#R_W_Italiane">
																		<h2>Italiane</h2>
																	</a>
																</div><!--panel-title-->
																<div  class = "col-lg-6" class = "panel-title">
																	<a class="accordion-toggle" data-toggle="collapse" data-parent="#ac-RisorseWeb" href="#R_W_Internazionali">
																		<h2>Internazionali</h2>
																	</a>
																</div><!--panel-title-->
														</div><!--panel-heading-->
													</div> <!--col-lg-12-->
														<div class="col-lg-6">
															<div class="panel panel-info"><!--rettangolo con bordo celeste-->
																<div id="R_W_Italiane" class="accordion-body collapse">
																	<div class="panel-body">
																	<h3>Italiani</h3>
																		<ul>
																			<li><a href ="http://www.slowmedicine.it/"target="_blank">Slow Medicine</a></li>
																			<li><a href ="http://www.evidence.it/" target="_blank">Medicina basata sull'evidenza</a></li>
																		</ul>
																</div><!--panel-body-->
																</div><!--accordion-body collapse-->
															</div><!--panel-info-->
														</div><!--panel-col-lg-6--> 
														<div class="col-lg-6">
															<div class="panel panel-info">
																<div id="R_W_Internazionali" class="accordion-body collapse">
																	<div class="panel-body">
																	<h3>Internazionali</h3>
																		<ul>
																			<li><a href ="http://www.hon.ch/" target="_blank">Certificazione di  siti medici</a></li>
																			<li><a href ="http://www.uptodate.com/home" target="_blank">evidence-based clinical decision support</a></li>
																			<li><a href ="http://www.worstpills.org/"target="_blank">Effetti collaterali dei farmaci</a></li>
																			<li><a href ="http://www.choosingwisely.org/" target="_blank">Decidere consapevolmente</a></li>
																			<li><a href ="http://www.medicalalgorithms.com/" target="_blank">Algortmi medici </a></li>
																			<li><a href ="http://www.cdc.gov/" target="_blank">Center for Disease Control</a></li>
																			<li><a href ="http://www.who.int/en/" target="_blank">WHO</a></li>
																			<li><a href ="http://www.ema.europa.eu/ema/" target="_blank">EMA</a></li>
																			<li><a href ="http://www.fda.gov/" target="_blank">FDA</a></li>
																			<li><a href ="http://www.quackwatch.com/" target="_blank">Guida alle decisioni intelligenti</a></li>
																			<li><a href ="http://ktclearinghouse.ca/" target="_blank">KT Clearinghouse</a> </li>
																			<li><a href ="http://imagej.nih.gov/ij/download.html" target="_blank">ImageJ-download</a> </li>		
																		</ul>
																		<!--http://imagej.nih.gov/ij/download.html-->
																</div><!--panel-body-->
																</div><!--accordion-body collapse-->
															</div><!--panel-info-->
														</div><!--panel-col-lg-6-->
														
												</div><!--col-lg-12-->
											</div><!--accordion Risorse Web-->
									 </div><!--row-->
									 </div><!--accordion inner-->
								</div><!--body-collapse-->
							
							
								<div id="Riviste" class="accordion-body collapse">
									<div class="accordion-inner">
										<div class = "row">
											<h3><center>Riviste</center></h3>
										<!--Accordion Riviste-->
											<div class="accordion-group" id = "ac-Riviste">
												<div class="col-lg-12">
													<div class="col-lg-12">
														<div class = "panel-heading">
																<div  class = "col-lg-6" class = "panel-title">
																	<a class="accordion-toggle" data-toggle="collapse" data-parent="#ac-Riviste" href="#Riv_Italiane">
																		<h2>Italiane</h2>
																	</a>
																</div><!--panel-title-->
																<div  class = "col-lg-6" class = "panel-title">
																	<a class="accordion-toggle" data-toggle="collapse" data-parent="#ac-Riviste" href="#Riv_Internazionali">
																		<h2>Internazionali</h2>
																	</a>
																</div><!--panel-title-->
														</div><!--panel-heading-->
													</div> <!--col-lg-12-->
													<div class="col-lg-6"> 
															<div class="panel panel-success">
																<div id="Riv_Italiane" class="accordion-body collapse">
																	<div class="panel-body">
																		
																			<ul>
																				<li><a href = "http://www.evidence.it/" target="_blank">Evidence</a></li>
																				<li><a href ="http://www.itjem.org/"target="_blank">Emergenza Urgenza</a></li>
																				<li><a href ="http://www.progettoasco.it/editoria/riviste/rivista-simg/" target="_blank">Rivista-simg</a></li>
																				<li><a href ="http://wp.tuttosanita.it" target="_blank">TuttoSanitàPuglia</a></li>
																			</ul>
																	</div>
																</div><!--accordion-body collapse-->
															</div>
														 </div>
														<div class="col-lg-6"> 
															<div class="panel panel-success">
																<div id="Riv_Internazionali" class="accordion-body collapse">
																	<div class="panel-body">
																		
																			<ul>
																				<li><a href ="http://www.nejm.org/" target="_blank">New England Journal of Medicine</a></li>
																				<li><a href ="http://www.thelancet.com/" target="_blank">The Lancet</a></li>
																				<li><a href ="http://www.bmj.com/" target="_blank">BMJ</a></li>
																				<li><a href ="http://jama.jamanetwork.com/journal.aspx" target="_blank">JAMA</a></li>
																			</ul>
																	</div>
																</div><!--accordion-body collapse-->
															</div>
														</div>
													
											
												</div><!--col-lg-12-->
											</div><!--Riviste-->
										</div><!--row-->
									</div><!--accordion inner-->
								</div><!--accordion-body collapse-->
							</div><!--accordion group-->
						</div><!--accordion Utility-->
		  
		</div><!--inner-->		
 
 </div> <!--content-->        
<!--END PAGE CONTENT -->
@endsection