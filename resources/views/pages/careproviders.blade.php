@extends('layouts.app')
@extends('includes.template_head')

@section('pageTitle', 'Taccuino Paziente')
@section('content')
<!--PAGE CONTENT -->
<div id="content">
            <div class="inner" style="min-height:1200px;">
                <div class="row">
                    <div class="col-lg-12">
						<!--MODAL EMAIL-->
							<div class="col-lg-12">
										<div class="modal fade" id="mailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="chiudiformmodalmailCpp">&times;</button>
															<h4 class="modal-title" id="H2">Nuova Email</h4>
														</div>
														<form class="form-horizontal"  id="patmailformcpp">
														<div class="modal-body">
															<div class="form-group">
																<label class="control-label col-lg-4">Da :</label>
																<div class="col-lg-8">
																	@if($current_user->getRole() == User::PATIENT_DESCRIPTION)
																	<input type="text" name="username" id="username" value=" {{$current_user->getName()}} " readonly class="form-control"/>
																	@else
																	<input type="text" name="username" id="username" value=" {{$current_user->getName()}} {{$current_user->getSurname()}} " readonly class= "form-control"/>
																	@endif
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-lg-4">A:</label>
																<div class="col-lg-8">
																<input type="text" name="mailCpp" id="mailCpp" value=" " readonly class="form-control"/>
																</div>
															</div>
															<div class="form-group">
																<label for="mailSubject" class="control-label col-lg-4">Oggetto:</label>
																<div class="col-lg-8">
																<input type="text" name="mailSubject" id="mailSubject" class="form-control col-lg-6"/>
																</div>
															</div>
															<div class="form-group">
																<label for="contentMail" class="control-label col-lg-4">Testo:</label>
																<div class="col-lg-8">
																	<textarea name="contentMail" id="contentMail" class="form-control col-lg-6" rows="6"></textarea>
																</div>
															</div>
														 </div>
														 <div class="modal-footer">
																<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
																<button type="submit" class="btn btn-primary">Invia</button> 
														 </div>
														 </form>
													</div>
												</div>
											</div>
					
							</div>
							<!--FINE MODAL EMAIL-->
                        <h2>Care Providers</h2>

						<div class="box dark">
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									<div class="panel panel-default">	
										<div class="panel panel-warning">
											<div class="panel-heading" role="tab" id="headingOne" >
												<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
													<strong>Clicca per aprire la tabella esplicativa dei ruoli :</strong>
												</a>
											</div><!--panel-heading-->
										</div><!--panel-warning-->
										<div id="collapseOne" class="accordion-body collapse" role="tabpanel" aria-labelledby="headingOne">
											<div class="panel-body">
												<div class="table-responsive" >
													<table class="table" >
														 <thead>
															<tr>
																<th>ruolo </th>
																<th>attività</th>
																<th>ruolo </th>
																<th>attività</th>
																<th>ruolo </th>
																<th>attività</th>
															</tr>
														</thead>
														<tbody>
															<!--creo una tabella esplicativa dei codici che inserisce 3 valori per riga -->
															@for($i = 0; $i < count($types)-2; $i = $i+3)
																@php($j = $i+1)
																@php($k = $i +2)
																<tr>
																	<td>{{ $types[ $i ]->id_tipologia}}</td><td>{{ $types[ $i ]->tipologia_descrizione}}</td>
																	<td>{{ $types[ $i ]->id_tipologia}}</td><td>{{ $types[ $j ]->tipologia_descrizione}}</td>
																	<td>{{ $types[ $i ]->id_tipologia}}</td><td>{{ $types[ $k ]->tipologia_descrizione}}</td>
																</tr>

																@if( (count($types)-2)% 3 ==1 )
																<tr>
																	<td>{{ $types[ $i ]->id_tipologia}}</td><td>{{$types[ $i ]->tipologia_descrizione}}</td>
																</tr>
																@elseif((count($types)-2) == 2)
																	@php($j = $i+1)
																	<tr>
																		<td>{{ $types[ $i ]->id_tipologia}}</td><td>{{$types[$j ]->tipologia_descrizione}}</td>
																	</tr>
																@endif
															@endfor
														</tbody>
													</table>
												</div>	<!--table-responsive-->				
											</div><!--panel body-->
										</div><!--accordion-body-collapse-->
									</div><!--panel panel-default-->
								</div><!--panel-group accordion-->
							
                    	
                        <div class="body">
							<div class="panel panel-warning">
								<!-- TODO: Rivedere dal vecchio resp il controllo sulla condivisione o meno dei dati del paziente
								con i care provider -->

                        	<div class="panel-body">
							</br>
								
							<div id="toSetTableSet" class="table-responsive" >
                                    <table class="table" >
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
												<th>Cognome</th>
												<th>Ruolo</th>
                                                <th>Telefono</th>
												<th>Altre informazioni</th>
												<th>Città</th>
												@if($current_user->getRole() == User::PATIENT_DESCRIPTION)
													<th>Conf.</th>
													<th>Opzioni</th>
												@endif
												<th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	@for($i=0; $i<$careproviders; $i++)
                                        		<tr id="careProviderSet{{$i}}" style="display: none;">
															<td id="careProvSet_{{$i}}_name">{{ $careproviders[ $i ]->cpp_nome }}</td>
															<td id="careProvSet_{{$i}}_surname">{{$careproviders[ $i ]->cpp_cognome}}</td>
															<td id="careProvSet_{{$i}}_role">Ruolo</td>
															<td id="careProvSet_{{$i}}_tel">{{ $careproviders[ $i ]->contacts()->first()->cpp_cognome }}</td>
															<td id="careProvSet_{{$i}}_reperibilita">'.$this->get_var('careProvSet_'.$i."_reperibilita").'</td>
															<td id="careProvSet_{{$i}}_address">'.$this->get_var('careProvSet_'.$i."_address").'</td>
															@if($current_user->getRole() == User::PATIENT_DESCRIPTION)
															<td id="careProvSet_{{$i}}_conf">'.$this->get_var('careProvSet_'.$i.'_conf').'
																	</td>
																	<td>
																		<table>
																			<tr>
																				
																				<td>
																					<div class="dropdown">
																						  <button class="btn btn-info dropdown-toggle dropdown-toggle-set" type="button" id="dropdownMenuSet_'.$this->get_var('careProvSet_'.$i.'_id').'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" value="'.$this->get_var('careProvSet_'.$i.'_conf').'">
																							<i class="icon-check"></i>
																							<span class="caret"></span>
																						  </button>
																						  <ul id="setLevelCppSet_'.$id_Cp_set.'" class="dropdown-menu" aria-labelledby="dropdownMenu_'.$id_Cp_set.'">';
																							foreach($this->get_var('arrayConf') as $conf ){
																								//echo '<li><a value="'.$idFiles.'" id="'.$conf['codice'].'" class="to_do" >'.$conf['descrizione'].'</a></li>';
																								echo '<li><a value="'.$id_Cp_set.'" id="'.$conf['codice'].'" class="cppLevelSet" >'.$conf['descrizione'].'</a></li>';
																							}
																							</ul>
																						</div>														
																				</td>
																				<td>
																					<button id="buttonCpp_'.$i.'" value=" '.$id_Cp_set.' " type="button" class="buttonDelete btn btn-default btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-remove"></i></button>
																				</td>
															@else
																	<td>
																		</td>
																		<td>
																			<table>
																				<tr>
																					<td>
																					</td>
																					<td>
																					</td>
															@endif
															<td>															
																<button class="btn btn-warning btn-mailCppSet" data-target="#mailModal" data-toggle="modal" type="button" id="mailSet_'.$this->get_var('careProvSet_'.$i.'_id').'" aria-haspopup="true" aria-expanded="true" value="'.$i.'">
																	<i class="icon-envelope"></i>
																</button>
															</td>
															</tr>
															</table>
															</td>
															</tr>
                                        	@endfor
                                            
												<?php
													$addressArray_set = array();
													$nameArray_set = array();
													$surnameArray_set = array();
													$emailArray_set = array();
												
												if($this->is_set('isCpp')){
													$numCpSet = $this->get_var('numCpSet'); 
													
													$addressArray_set = array();
													$nameArray_set = array();
													$surnameArray_set = array();
													
													for($i=0; $i<$numCpSet ; $i++){
														
														$addressArray_set[$i] =	$this->get_var('careProvSet_'.$i.'_address');
														$nameArray_set[$i] =	$this->get_var('careProvSet_'.$i.'_name');
														$surnameArray_set[$i] =	$this->get_var('careProvSet_'.$i.'_surname');
														$emailArray_set[$i] =	$this->get_var('careProvSet_'.$i.'_email');
														
														echo '<tr id="careProviderSet'.$i.'" style="display: none;">
															<td id="careProvSet_'.$i.'_name">'.$this->get_var('careProvSet_'.$i.'_name').'</td>
															<td id="careProvSet_'.$i.'_surname">'.$this->get_var('careProvSet_'.$i.'_surname').'</td>
															<td id="careProvSet_'.$i.'_role">'.$this->get_var('careProvSet_'.$i."_role").'</td>
															<td id="careProvSet_'.$i.'_tel">'.$this->get_var('careProvSet_'.$i."_tel").'</td>
															<td id="careProvSet_'.$i.'_reperibilita">'.$this->get_var('careProvSet_'.$i."_reperibilita").'</td>
															<td id="careProvSet_'.$i.'_address">'.$this->get_var('careProvSet_'.$i."_address").'</td>';
															if ( $role == "pz")
															{	
																$id_Cp_set = $this->get_var('careProvSet_'.$i.'_id');
																echo'
																	<td id="careProvSet_'.$i.'_conf">'.$this->get_var('careProvSet_'.$i.'_conf').'
																	</td>
																	<td>
																		<table>
																			<tr>
																				
																				<td>
																					<div class="dropdown">
																						  <button class="btn btn-info dropdown-toggle dropdown-toggle-set" type="button" id="dropdownMenuSet_'.$this->get_var('careProvSet_'.$i.'_id').'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" value="'.$this->get_var('careProvSet_'.$i.'_conf').'">
																							<i class="icon-check"></i>
																							<span class="caret"></span>
																						  </button>
																						  <ul id="setLevelCppSet_'.$id_Cp_set.'" class="dropdown-menu" aria-labelledby="dropdownMenu_'.$id_Cp_set.'">';
																							foreach($this->get_var('arrayConf') as $conf ){
																								//echo '<li><a value="'.$idFiles.'" id="'.$conf['codice'].'" class="to_do" >'.$conf['descrizione'].'</a></li>';
																								echo '<li><a value="'.$id_Cp_set.'" id="'.$conf['codice'].'" class="cppLevelSet" >'.$conf['descrizione'].'</a></li>';
																							}
																							/*
																							<li><a value="'.$id_Cp_set.'" id="1" class="cppLevelSet" >Livello 1</a></li>
																							<li><a value="'.$id_Cp_set.'" id="2" class="cppLevelSet">Livello 2</a></li>
																							<li><a value="'.$id_Cp_set.'" id="3" class="cppLevelSet">Livello 3</a></li>
																							<li><a value="'.$id_Cp_set.'" id="4" class="cppLevelSet">Livello 4</a></li>
																							<li><a value="'.$id_Cp_set.'" id="5" class="cppLevelSet">Livello 5</a></li>
																							<li><a value="'.$id_Cp_set.'" id="6" class="cppLevelSet">Livello 6</a></li>
																							*/
																						  echo '</ul>
																						</div>														
																				</td>
																				<td>
																					<button id="buttonCpp_'.$i.'" value=" '.$id_Cp_set.' " type="button" class="buttonDelete btn btn-default btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-remove"></i></button>
																				</td>';
																}
																else 
																	echo'
																		<td>
																		</td>
																		<td>
																			<table>
																				<tr>
																					<td>
																					</td>
																					<td>
																					</td>
																			';
														echo'
															<td>															
																<button class="btn btn-warning btn-mailCppSet" data-target="#mailModal" data-toggle="modal" type="button" id="mailSet_'.$this->get_var('careProvSet_'.$i.'_id').'" aria-haspopup="true" aria-expanded="true" value="'.$i.'">
																	<i class="icon-envelope"></i>
																</button>
															</td>
															</tr>
															</table>
															</td>
															</tr>';
															//<td><a id="'.$this->get_var('careProvSet_'.$i.'_id').'"  href="#" data-toggle="modal" data-target="#formModalCpp"><i class="icon-envelope-alt"></i></a></td>
															/*<td id="careProvSet_'.$i.'_spec">'.'Chirurgo'$this->get_var('careProvSet_'.$i."_spec").'</td>*/
															//<td><button id="buttonCpp_'.$i.'" value=" '.$this->get_var('careProvSet_'.$i.'_id').' " type="button" class="buttonDelete btn btn-default btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button></td>
													}													
												}
												
                         						?>   
                                                
                                        </tbody>
                                    </table>
                            </div><!--table-responsive-->
								
							<div class="table-responsive"  >
                                <table id="mapTable" class="table" border-top="0px">
                                    <tbody>
										
											
											<td width="100%"><div id="map-canvas" ></div></td>
											
										
									</tbody>
                                </table>
                            </div>
							</br>
							
							<div class="table"  >
                                <table id="sliderTable" class="table" border-top="0px">
                                    <tbody>
										
											
											<td width="100%"><input id="kmThresh"  data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="0"/></td>
											
										
									</tbody>
                                </table>
                            </div>
							
									</br>
								<div class="panel panel-warning">
									<header>
									   <!-- TODO: Rivedere dal vecchio resp il controllo sulla condivisione o meno dei dati del paziente
								con i care provider -->
									</header>
										<div class="panel-heading"><strong>I Care Provider  del Registro Elettronico Sanitario  Personale :</strong>
										</div><!--panel-heading-->
									</div><!--panel-warning-->
									<?php	$numCp = $this->get_var('numCp'); ?>
								
								<div id="toSetTable" class="table-responsive" >
										<table class="table" >
											<thead>
												<tr>
													<th>Nome </th>
													<th>Cognome</th>
													<th>Ruolo</th>
													<th>Telefono</th>
													<th>Altre informazioni</th>
													<th>Città</th>
														<!--<th>Specializzazione</th>-->
													<th>Opzioni</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
                                            
												<?php
													
													$num = $this->get_var('numCp'); 
													
													$addressArray = array();
													$nameArray = array();
													$surnameArray = array();
													$emailArray = array();
													$activeArray = array();
													
													for($i=0; $i<$num ; $i++){
														//array_push($addressArray, $this->get_var('careProv_'.$i."_address"));
														//array_push($nameArray, $this->get_var('careProv_'.$i."_name"));
														//array_push($surnameArray, $this->get_var('careProv_'.$i."_surname"));
														//array_push($emailArray, $this->get_var('careProv_'.$i.'_email'));
														$addressArray[$i] =	$this->get_var('careProv_'.$i.'_address');
														$nameArray[$i] =	$this->get_var('careProv_'.$i.'_name');
														$surnameArray[$i] =	$this->get_var('careProv_'.$i.'_surname');
														$emailArray[$i] =	$this->get_var('careProv_'.$i.'_email');
														$activeArray [$i]=	$this->get_var('careProv_'.$i.'_active');
														//if ( $activeArray [$i] == 1){
														echo '<tr id="careProvider'.$i.'" style="display: none;">
															<td id="careProv_'.$i.'_name">'.$this->get_var('careProv_'.$i.'_name').'</td>
															<td id="careProv_'.$i.'_surname">'.$this->get_var('careProv_'.$i.'_surname').'</td>
															<td id="careProv_'.$i.'_role">'.$this->get_var('careProv_'.$i."_role").'</td>
															<td id="careProv_'.$i.'_tel">'.$this->get_var('careProv_'.$i."_tel").'</td>
															<td id="careProv_'.$i.'_reperibilita">'.$this->get_var('careProv_'.$i."_reperibilita").'</td>
															<td id="careProv_'.$i.'_address">'.$this->get_var('careProv_'.$i."_address").'</td>															
															<td>
															<table>
															<tr>';
															if ( $sharableData)
															echo'
															<td>
															<button id="buttonCpp_'.$i.'" value=" '.$this->get_var('careProv_'.$i.'_id').' " type="button" class="buttonAdd btn btn-default btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-plus"></i></button>
															</td>';
															if ( $sharableData){
															echo'
															<td>
																<div class="dropdown">
																	  <button class="btn btn-info dropdown-toggle dropdown-toggle-unset" type="button" id="dropdownMenu_'.$this->get_var('careProv_'.$i.'_id').'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" value="1">
																		<i class="icon-check"></i>
																		<span class="caret"></span>
																	  </button>
																	  <ul id="setLevelCpp_'.$this->get_var('careProv_'.$i.'_id').'" class="dropdown-menu" aria-labelledby="dropdownMenu_'.$this->get_var('careProv_'.$i.'_id').'">';
																		foreach($this->get_var('arrayConf') as $conf ){
																			//echo '<li><a value="'.$idFiles.'" id="'.$conf['codice'].'" class="to_do" >'.$conf['descrizione'].'</a></li>';
																			echo '<li><a value="'.$this->get_var('careProv_'.$i.'_id').'" id="'.$conf['codice'].'" class="cppLevel" >'.$conf['descrizione'].'</a></li>';
																		}
																		/*
																		<li><a value="'.$this->get_var('careProv_'.$i.'_id').'" id="1" class="cppLevel" >Livello 1</a></li>
																		<li><a value="'.$this->get_var('careProv_'.$i.'_id').'" id="2" class="cppLevel">Livello 2</a></li>
																		<li><a value="'.$this->get_var('careProv_'.$i.'_id').'" id="3" class="cppLevel">Livello 3</a></li>
																		<li><a value="'.$this->get_var('careProv_'.$i.'_id').'" id="4" class="cppLevel">Livello 4</a></li>
																		<li><a value="'.$this->get_var('careProv_'.$i.'_id').'" id="5" class="cppLevel">Livello 5</a></li>
																		<li><a value="'.$this->get_var('careProv_'.$i.'_id').'" id="6" class="cppLevel">Livello 6</a></li>
																		*/
																	  echo '</ul>
																</div>
															
															</td>';
															}
															echo'
															<td>
																<button class="btn btn-warning btn-mailCpp" data-target="#mailModal" data-toggle="modal" type="button" id="mailCpp_'.$this->get_var('careProv_'.$i.'_id').'" aria-haspopup="true" aria-expanded="true" value="'.$i.'">
																	<i class="icon-envelope"></i>
																</button>
															</td>
															</tr>
															</table>
															</td>
															</tr>';
															
															//<td><button id="buttonCpp_'.$i.'" value=" '.$this->get_var('careProv_'.$i.'_id').' " type="button" class="buttonAdd btn btn-default btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Assegna</button></td>
															/*<td id="careProv_'.$i.'_spec">'.'Chirurgo'$this->get_var('careProv_'.$i."_spec").'</td>*/
													}
													
                         						?>   
                                                
											</tbody>
										</table>
									</div><!--id="toSetTable" class="table-responsive"-->
							</div><!--panelbody-->
							
							<div class="panel-footer" style="text-align:right">
							</div><!--panel-footer-->
                        	</div><!--panel-warning-->
                        </div><!--body-->
             		</div><!--box-dark-->
					</div><!--col-lg-12-->
                </div><!--row-->
			</div><!--inner-->
		
        </div><!--content-->
<!--END PAGE CONTENT -->

    <style>
      #map-canvas {
        height:30em;
        width: 100%;
      }
	  
	  #mapTable td{
		  border-top: 0px;
	  }
	  
	  #sliderTable td{
		  border-top: 0px;
	  }
	  
	  #ex1Slider{
        width: 100% !important;  
	  }
	  
	 
	  .tooltip{
		  z-index:9999;
	  }
	
	.cppLevel:hover{
		cursor: pointer;	  
	}
	
	.cppLevelSet:hover{
		cursor: pointer;	  
	}
	
	#toSetTableSet{
		overflow: auto;
	}
	
	#toSetTable{
		overflow: auto;
	}
	
    </style>
	<!-- Bootstrap slider CSS -->
	<link href="plugins/bootstrap_slider/css/bootstrap-slider.css" rel="stylesheet">
	
	<!-- Bootstrap slider -->
	<script src="plugins/bootstrap_slider/js/bootstrap-slider.js"></script>
	
	<!-- Custom javascript -->
	@php(include "js/formscripts/careProvidersScript.php")

<!--END PAGE CONTENT -->
@endsection