@extends('layouts.app')
@extends('includes.template_head')

@section('pageTitle', 'Care Providers')
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
																	@if($current_user->getDescription() == User::PATIENT_DESCRIPTION)
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
																<tr>
																	<td>{{ $types[ $i ]->id_tipologia}}</td><td>{{ $types[ $i ]->tipologia_descrizione}}</td>
																	<td>{{ $types[ $i+1 ]->id_tipologia}}</td><td>{{ $types[ $i+1 ]->tipologia_descrizione}}</td>
																	<td>{{ $types[ $i+2 ]->id_tipologia}}</td><td>{{ $types[ $i+2 ]->tipologia_descrizione}}</td>
																</tr>

																@if( (count($types)-2)% 3 ==1 )
																<tr>
																	<td>{{ $types[ $i ]->id_tipologia}}</td><td>{{$types[ $i ]->tipologia_descrizione}}</td>
																</tr>
																@elseif((count($types)-2) == 2)
																	<tr>
																		<td>{{ $types[ $i+1 ]->id_tipologia}}</td><td>{{$types[$i+1 ]->tipologia_descrizione}}</td>
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
												@if($current_user->getDescription() == User::PATIENT_DESCRIPTION)
													<th>Conf.</th>
													<th>Opzioni</th>
												@endif
												<th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	@for($i=0; $i<count($careproviders); $i++)
                                        		<tr id="careProviderSet{{$i}}" style="display: none;">
															<td id="careProvSet_{{$i}}_name">{{ $careproviders[ $i ]->cpp_nome }}</td>
															<td id="careProvSet_{{$i}}_surname">{{$careproviders[ $i ]->cpp_cognome}}</td>
															<td id="careProvSet_{{$i}}_role">Ruolo</td>
															<td id="careProvSet_{{$i}}_tel">{{ $careproviders[ $i ]->contacts()->first()->cpp_cognome }}</td>
															<td id="careProvSet_{{$i}}_reperibilita">.$this->get_var('careProvSet_'.$i."_reperibilita").</td>
															<td id="careProvSet_{{$i}}_address">.$this->get_var('careProvSet_'.$i."_address").</td>
															@if($current_user->getDescription() == User::PATIENT_DESCRIPTION)
															<td id="careProvSet_{{$i}}_conf">.$this->get_var('careProvSet_'.$i.'_conf').
																	</td>
																	<td>
																		<table>
																			<tr>
																				
																				<td>
																					<div class="dropdown">
																						  <button class="btn btn-info dropdown-toggle dropdown-toggle-set" type="button" id="dropdownMenuSet_careProvSet_{{$i}}_id" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" value="careProvSet_{{$i}}_conf">
																							<i class="icon-check"></i>
																							<span class="caret"></span>
																						  </button>
																						  <ul id="setLevelCppSet_{{$i}}'" class="dropdown-menu" aria-labelledby="dropdownMenu_{{$i}}">';
																							foreach($this->get_var('arrayConf') as $conf ){
																								//echo '<li><a value="'.$idFiles.'" id="'.$conf['codice'].'" class="to_do" >'.$conf['descrizione'].'</a></li>';
																								echo '<li><a value="'.$id_Cp_set.'" id="'.$conf['codice'].'" class="cppLevelSet" >'.$conf['descrizione'].'</a></li>';
																							}
																							</ul>
																						</div>														
																				</td>
																				<td>
																					<button id="buttonCpp_{{i}}" value=" {{i}} " type="button" class="buttonDelete btn btn-default btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-remove"></i></button>
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
																<button class="btn btn-warning btn-mailCppSet" data-target="#mailModal" data-toggle="modal" type="button" id="mailSet_{{i}}" aria-haspopup="true" aria-expanded="true" value="'.$i.'">
																	<i class="icon-envelope"></i>
																</button>
															</td>
															</tr>
															</table>
															</td>
															</tr>
                                        	@endfor
                                            
												
                                                
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
												
												@for($i=0; $i<count(CareProvider::all()); $i++)
													@php($careproviders = CareProvider::all());
													<tr id="careProvider{{$i}}" style="display: none;">
															<td id="careProv_{{$i}}_name">{{$careproviders[$i]->cpp_nome}}</td>
															<td id="careProv_{{$i}}_surname">{{$careproviders[$i]->cpp_cognome}}</td>
															<td id="careProv_{{$i}}_role"></td>
															<td id="careProv_{{$i}}_tel">'.$this->get_var('careProv_'.$i."_tel").'</td>
															<td id="careProv_{{$i}}_reperibilita">'.$this->get_var('careProv_'.$i."_reperibilita").'</td>
															<td id="careProv_{{$i}}_address">'.$this->get_var('careProv_'.$i."_address").'</td>															
															<td>
															<table>
															<tr>
															if ( $sharableData)
															echo'
															<td>
															<button id="buttonCpp_{{$i}}" value="{{$i}}" type="button" class="buttonAdd btn btn-default btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-plus"></i></button>
															</td>
															if ( $sharableData){
															echo'
															<td>
																<div class="dropdown">
																	  <button class="btn btn-info dropdown-toggle dropdown-toggle-unset" type="button" id="dropdownMenu_{{$i}}).'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" value="1">
																		<i class="icon-check"></i>
																		<span class="caret"></span>
																	  </button>
																	  <ul id="setLevelCpp_'.$this->get_var('careProv_{{$i}}_id').'" class="dropdown-menu" aria-labelledby="dropdownMenu_{{$i}}).'">';
																		foreach($this->get_var('arrayConf') as $conf ){
																			//echo '<li><a value="'.$idFiles.'" id="'.$conf['codice'].'" class="to_do" >'.$conf['descrizione'].'</a></li>';
																			echo '<li><a value="{{$i}}" id="'.$conf['codice'].'" class="cppLevel" >'.$conf['descrizione'].'</a></li>';
																		}
																		</ul>
																</div>
															
															</td>
															<td>
																<button class="btn btn-warning btn-mailCpp" data-target="#mailModal" data-toggle="modal" type="button" id="mailCpp_" aria-haspopup="true" aria-expanded="true" value="">
																	<i class="icon-envelope"></i>
																</button>
															</td>
														</tr>
													</table>
												</td>
												</tr>
												@endfor
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
	<!-- TODO: Decommentare la seguente riga quando si rivedrà la reimplementazione della sezione careproviders" -->
	{{-- @php(include "careProvidersScript.php") --}}

<!--END PAGE CONTENT -->
@endsection