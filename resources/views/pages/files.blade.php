@extends('layouts.app')
@extends('includes.template_head')

@section('pageTitle', 'Files')
@section('content')
<!--PAGE CONTENT -->
<div id="content">

            <div class="inner" style="min-height:1200px;">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Files</h2>
						<p>In questa pagina sarà possibile visualizzare ed inviare files di immagini di lesioni cliniche immagini di indagini diagnostiche,
						registrazioni, brevi video, risultati di esami o documenti testuali. </p>
						<hr/>
<!-- ACCORDION -->
	<div class="accordion ac" id="accordion2">
		<div class="accordion-group">
		    <div class="accordion-heading centered">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
		            <h2>Files Caricati   &nbsp &nbsp &nbsp &nbsp
						<span >
                          <i  class="icon-angle-down"></i>
                        </span>           	
					</h2>
                </a>
			</div><!--accordion- group heading centered-->
			<div id="collapseOne" class="accordion-body collapse">
		        <div class="accordion-inner">	
					<div class="table table-striped table-bordered table-hover" >
				<div class="table-responsive" >
					<table class="table" >
						<thead>
							<tr>
								<th></th>
								<th>Nome File</th>
								<th>Commenti</th>
								<th>Data Caricamento</th>
								<th>Caricato da:</th>

								@if($current_user->getRole() == User::PATIENT_DESCRIPTION)
								<th>Conf.</th>
								<th>Opzioni</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@php
								if($current_user->getRole() == User::PATIENT_DESCRIPTION){
									$id_patient = $current_user->patient()->first()->id_paziente;	
								} else{
									//TODO: inserire caso in cui sia un care provider
								}
							@endphp
							@if(count($files) > 0)
								@foreach($files as $file)
									<tr>
										<td><button class= "btn btn-default btn-success "  type = "submit" onclick ='window.open("downloadImage/{{$file->id_file}}")'> <i class="icon-check"></i></button></td>
										<td><a href = "downloadImage/{{$file->id_file}}">{{$file->file_nome}}</a></td><td>{{$file->file_commento}}</td><td><?php echo date('d/m/y', strtotime($file->created_at )) ?></td><td>{{User::find($file->auditlog_log()->first()->id_visitante)->getSurname()}}</td>
										

										@if($current_user->getRole() == User::PATIENT_DESCRIPTION)
											<td id = "nomeFile_{{$file->id_file}}conf">{{$file->id_file_confidenzialita}}</td>
												<td>
													<table>
														<tr>
															<td>
																<div class="dropdown">
																	<form method="post" action="/updateFileConfidentiality">
																		{{ csrf_field() }}
																		<select class="btn btn-info dropdown-toggle dropdown-toggle-set" data-toggle="tooltip" data-placement="top" title="Scegli livello confidenzialità" name="updateConfidentiality">
																			<option value="1" title="Livello confidenzialità 1">Conf. 1</option>
																			<option value="2" title="Livello confidenzialità 2">Conf. 2</option>
																			<option value="3" title="Livello confidenzialità 3">Conf. 3</option>
																			<option value="4" title="Livello confidenzialità 4">Conf. 4</option>
																			<option value="5" title="Livello confidenzialità 5">Conf. 5</option>
																			<option value="6" title="Livello confidenzialità 6">Conf. 6</option>
																		</select>
																		<input type="hidden" name="id_patient" value="{{$id_patient}}">
																		<input type="hidden" name="name" value="{{$file->file_nome}}">
																	</form>
																	</div>
																	<script type="text/javascript">
																		$('select').change(function ()
																		{
																		    $(this).closest('form').submit();
																		});
																	</script>	
															</td>
															<td>
																<form method="post" action="/deleteFile">
																	{{ csrf_field() }}
																	<input type="hidden" name="id_patient" value="{{$id_patient}}">
																	<input type="hidden" name="name" value="{{$file->file_nome}}">
																<button  type="submit" class="buttonDelete btn btn-default btn-danger" ><i class="icon-remove"></i></button>
																</form>
															</td>
														</tr>
													</table>
												</td>
										@endif
										</tr>
								@endforeach
							@endif
				
						</tbody>
					</table>
					<hr/>	
				</div><!--class="table-responsive"-->
			</div><!--class table table-striped table-bordered table-hover-->
				</div><!--accordion-inner-->
			</div><!--accordion-body collapse-->	
		</div><!--accordion-group-->
		<hr>
		<div class="accordion-group">
		    <div class="accordion-heading centered">
		         <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
					<h2>Carica nuovi files &nbsp 
						<span >
                          <i  class="icon-angle-down"></i>
                        </span>      
					</h2>
				</a>
			</div><!--accordion- group heading centered-->
			<div id="collapseTwo" class="accordion-body collapse">
		         <div class="accordion-inner">
					<div class="accordion ac"id = "collapseTwo_A" ><!--accordion ac interno-->
						<div class="accordion-group">
							<div class="accordion-heading centered">
								<div class ="row">
									<div class="col-lg-4"> 
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseTwo_A" href="#collapseFoto">
											<h2>Foto del paziente </h2>
										</a>
									</div><!--col-lg-4-->
									<div class="col-lg-4"> 
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseTwo_A" href="#collapseVideo">
											<h2>Video del paziente</h2>
										</a>
									</div><!--col-lg-4-->
									<div class="col-lg-4"> 
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseTwo_A" href="#collapseReg">
											<h2>Registrazioni</h2>
										</a>
									</div><!--col-lg-4-->
									<hr>
									<div class="col-lg-4"> 	
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseTwo_A" href="#collapseStrum">
											<h2>Video Esami Strumentali</h2>
										</a>
									</div><!--col-lg-4-->
									<div class="col-lg-4"> 	
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseTwo_A" href="#collapseDicom">
											<h2>Immagini Dicom</h2>
										</a>
									</div><!--col-lg-4-->
									<div class="col-lg-4"> 	
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseTwo_A" href="#collapseDocuments">
											<h2>Documenti di testo</h2>
										</a>
									</div><!--col-lg-4-->
									
								</div><!--row-->
								
									<div class="row">
									<div id = "collapseFoto" class="accordion-body collapse" >
										<div class="col-lg-12"> 
												<div class="panel panel-warning">
													<div class="panel-body">
														<h3>Foto</h3>
														<hr/>
														<form method = "post" action = "/uploadFile" enctype = "multipart/form-data">
														{{ csrf_field() }} 
															<input  type = "file" accept="image/*" name = "file_field"/>
															<br>
															<label for="comment">Note sul file caricato:
															</label>
															<textarea name="comment" id="comment" cols = "60" rows = "2"  > 
															</textarea>
															@if($current_user->getRole() == User::PATIENT_DESCRIPTION)
															<br><br>
															<label for="conf_1">Visibilità</label>
															<select name="confidentiality">
																	<option value="1">Nessuna restrizione</option>
																	<option value="2">Basso</option>
																	<option value="3">Moderato</option>
																	<option value="4" >Normale</option>
																	<option value="5" selected = "true">Riservato</option>
																	<option value="6"> Strettamente riservato</option>
															  </select>
															@endif
															  <br> <br>
															<input  type = "hidden" name = "fileClass1" value = "1"/> <!--classe per le foto -->
															<input  type = "hidden" name = "idPatient" value = "{{$id_patient}}" />
															<input  type = "hidden" name = "idLog" value = "{{$log->id_audit}}" />
															<input type = "submit" name = "invia" value = "Invia"/>
															<input type='reset' value='Reset' name='reset'>
														</form>
													</div>	<!--panelbody-->
												</div>	<!--panelwarning-->	
										</div>	<!--col lg12-->
									</div><!--collapse foto-->	
									
								<div id = "collapseVideo" class="accordion-body collapse" >
									<div class="col-lg-12"> 
											<div class="panel panel-warning">
												<div class="panel-body">
													<h3>Video</h3>
													<hr/>
													<form method = "post" action = "/uploadFile" enctype = "multipart/form-data"> 
														{{ csrf_field() }} 
														<input  type = "file" accept="video/*" name = "nomefile"/>
														<br>
														<label for="comm">Note sul file caricato:
														</label>
														<textarea name="comm"  cols = "60" rows = "2"  > 
														</textarea>
														@if($current_user->getRole() == User::PATIENT_DESCRIPTION)
														<br><br>
														<label for="conf_1">Visibilità</label>
														<select name="conf_1">
																<option value="1">Nessuna restrizione</option>
																<option value="2">Basso</option>
																<option value="3">Moderato</option>
																<option value="4" >Normale</option>
																<option value="5" selected = "true">Riservato</option>
																<option value="6"> Strettamente riservato</option>
														  </select>
														@endif
														  <br> <br>
														<input  type = "hidden" name = "fileClass2" value = "2"/> <!--classe per i video non diagnostici -->
														<input  type = "hidden" name = "idPaz" value = "{{$id_patient}}" />
														<input  type = "hidden" name = "idLog" value = "{{$log->id_audit}}" /> 
														<input type = "submit" name = "invia" value = "Invia"/>
														<input type='reset' value='Reset' name='reset'>
													</form>
												</div>	<!--panelbody-->
											</div>	<!--panelwarning-->	
									</div>	<!--col lg12-->
								
								</div><!--collapse video-->
								
								</div>
								<div class="row">
									<div id = "collapseReg" class="accordion-body collapse" >
										<div class="col-lg-12"> 
												<div class="panel panel-danger">
													<div class="panel-body">
														<h3>Registrazioni</h3>
														<br/>
														<hr/>
														<form method = "post" action = "/uploadFile" enctype = "multipart/form-data">
														{{ csrf_field() }}
															<input  type = "file" accept="audio/*" name = "nomefile"/>
															<br>
															<label for="comm">Note sul file caricato:
															</label>
															<textarea name="comm"  cols = "60" rows = "2"  > 
															</textarea>
															@if($current_user->getRole() == User::PATIENT_DESCRIPTION)
															<br><br>
															<label for "conf_1">visibilità</label>
															<select name="conf_1">
																	<option value="1">Nessuna restrizione</option>
																	<option value="2">Basso</option>
																	<option value="3">Moderato</option>
																	<option value="4" >Normale</option>
																	<option value="5" selected = "true">Riservato</option>
																	<option value="6"> Strettamente riservato</option>
															  </select>
															@endif
															  <br> <br>
															<input  type = "hidden" name = "fileClass3" value = "3"/> <!--classe per le registrazioni -->
															<input  type = "hidden" name = "idPaz" value = "{{$id_patient}}" />
															<input  type = "hidden" name = "idLog" value = "{{$log->id_audit}}" />
															<input type = "submit" name = "invia" value = "Invia"/>
															<input type='reset' value='Reset' name='reset'>
														</form>
													</div>	<!--panelbody-->
												</div>	<!--panel-danger-->
										</div>	<!--col lg12-->
									</div><!--collapse Reg-->
									<div id = "collapseStrum" class="accordion-body collapse" >	
										<div class="col-lg-12"> 
										<div class="panel panel-danger">
											<div class="panel-body">
											
												<h3>video di esami strumentali</h3>
												<p>coronarografie, esami endoscopici etc.</p>
												<hr/>
												<form method = "post" action = "/uploadFile" enctype = "multipart/form-data">
													{{ csrf_field() }}
														<input  type = "file" name = "nomefile"/>
														<br>
														<label for "comm">Note sul file caricato:
														</label>
														<textarea name="comm"  cols = "60" rows = "2"  > 
														</textarea>
														@if($current_user->getRole() == User::PATIENT_DESCRIPTION)
															<br><br>
															<label for "conf_1">visibilità</label>
															<select name="conf_1">
																	<option value="1">Nessuna restrizione</option>
																	<option value="2">Basso</option>
																	<option value="3">Moderato</option>
																	<option value="4" >Normale</option>
																	<option value="5" selected = "true">Riservato</option>
																	<option value="6"> Strettamente riservato</option>
															  </select>
															@endif
														  <br> <br>
														<input  type = "hidden" name = "fileClass5" value = "5"/> <!--classe per video diagnostici -->
														<input  type = "hidden" name = "idPaz" value = "{{$id_patient}}" />
														<input  type = "hidden" name = "idLog" value = "{{$log->id_audit}}" />
														<input type = "submit" name = "invia" value = "Invia"/>
														<input type='reset' value='Reset' name='reset'>
												</form>
											</div>	<!--panelbody-->
										</div>	<!--panelinfo-->	
									</div>	<!--col lg12-->
									</div>
								</div><!--row-->
								
						<div class="row">
							<div id = "collapseDicom" class="accordion-body collapse" >
								<div class="col-lg-12"> 
									<div class="panel panel-info">
										<div class="panel-body">
										
										<h3>immagini dicom</h3>
										<br/>
											<p>immagini radiologiche ecografiche di cui in alcuni casi ai pazienti vengono forniti i cd.</p>
											<br/>
											<hr/>
											<form method = "post" action = "/uploadFile" enctype = "multipart/form-data">
												{{ csrf_field() }}
													<input  type = "file" name = "nomefile"/>
													<br>
													<label for="comm">Note sul file caricato:
													</label>
													<textarea name="comm"  cols = "60" rows = "2"  > 
													</textarea>
													@if($current_user->getRole() == User::PATIENT_DESCRIPTION)
															<br><br>
															<label for="conf_1">visibilità</label>
															<select name="conf_1">
																	<option value="1">Nessuna restrizione</option>
																	<option value="2">Basso</option>
																	<option value="3">Moderato</option>
																	<option value="4" >Normale</option>
																	<option value="5" selected = "true">Riservato</option>
																	<option value="6"> Strettamente riservato</option>
															  </select>
													@endif
													  <br> <br>
													<input  type = "hidden" name = "fileClass4" value = "4"/> <!--classe per files dicom -->
													<input  type = "hidden" name = "idPaz" value = "{{$id_patient}}" />
													<input  type = "hidden" name = "idLog" value = "{{$log->id_audit}}" />
													<input type = "submit" name = "invia" value = "Invia"/>
													<input type='reset' value='Reset' name='reset'>
											</form>
										
												</div>	<!--panelbody-->
									</div>	<!--panelinfo-->	
								</div>	<!--col lg12-->
							</div>	<!--collapse Dicom-->
							
							<div id = "collapseDocuments" class="accordion-body collapse" >
								<div class="col-lg-12"> 
								<div class="panel panel-info">
									<div class="panel-body">
										<h3>referti-lettere di dimissione</h3>
										<h4>scansione di documenti clinici</h4>
										<p>accetta i formati: pdf, doc, docx ,txt, odt.
										Nel caso i files contengano informazioni sensibili &egrave raccomandata la protezione con password.</p>
										<hr/>
										<form method = "post" action = "" enctype = "multipart/form-data">
											{{ csrf_field() }}
												<input  type = "file" name = "nomefile"/>
												<br>
												<label for "comm">Note sul file caricato:
												</label>
												<textarea name="comm"  cols = "60" rows = "2"  > 
												</textarea>
												@if($current_user->getRole() == User::PATIENT_DESCRIPTION)
															<br><br>
															<label for="conf_1">visibilità</label>
															<select name="conf_1">
																	<option value="1">Nessuna restrizione</option>
																	<option value="2">Basso</option>
																	<option value="3">Moderato</option>
																	<option value="4" >Normale</option>
																	<option value="5" selected = "true">Riservato</option>
																	<option value="6"> Strettamente riservato</option>
															  </select>
													@endif
												  <br> <br>
												<input  type = "hidden" name = "fileClass6" value = "6"/> <!--classe per scansioni referti, lettere di dimissioni -->
												<input  type = "hidden" name = "idPaz" value = "{{$id_patient}}" />
												<input  type = "hidden" name = "idLog" value = "{{$log->id_audit}}" />
												<input type = "submit" name = "invia" value = "Invia"/>
												<input type='reset' value='Reset' name='reset'>
										</form>
									</div>	<!--panelbody-->
								</div>	<!--panelwarning-->	
							</div>	<!--col lg12-->	
							</div> <!--collapse Documents-->
						</div>	<!--row-->
							</div><!--fine accordion heading centered collapseTwo_A-->
						</div><!--fine accordion-group collapseTwo_A-->
					</div><!--fine accordion ac interno collapseTwo_A-->
				</div><!--accordion-inner-->
			</div><!--accordion-body collapse-->
		</div><!--accordion group-->
	</div><!--accordion-->


	<!-- TODO: Aggiungere opzioni in caso in cui non si disponga dei permessi necessari, vedere vecchio resp -->						
					</div>
                </div><!--row-->

                <hr />
			</div><!--inner-->

        </div><!--content-->
<!--END PAGE CONTENT -->
@endsection