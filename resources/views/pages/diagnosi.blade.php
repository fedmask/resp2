@extends('layouts.app')
@extends('includes.template_head')

@section('pageTitle', 'Diagnosi')
@section('content')
<!--PAGE CONTENT -->

<div id="content">
            <div class="inner" style="min-height:1200px;">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Elenco diagnosi</h2>
						<hr>
						<
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="formscripts/jquery.js"></script>
<script src="formscripts/jquery-ui.js"></script>
<script src="formscripts/diagnosi.js"></script>



<div class="row">
					<div class="col-lg-12" >
						<div class="btn-group">
<button class="btn btn-primary" id="nuovaD"><i class="icon-stethoscope"></i> Nuova diagnosi</button>
<button class="btn btn-primary" id="concludiD"><i class="icon-ok-sign"></i> Concludi diagnosi</button>
<button class="btn btn-primary" id="annullaD"><i class="icon-trash"></i> Annulla diagnosi</button>

</div></div></div><br>





		<form id="formD" style="display:none" action="formscripts/diagnosi.php" method="POST" class="form-horizontal" >
			<div class="tab-content">
				<div class="row">
				
					
					<?php	
						
					$cps=$this->get_var('suggestCps');
					$script = '<script>
							   $(document).ready(function(){
								var cps ='.$cps." var cpSuggest = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.whitespace,
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  local: cps
});";

	for($i=0; $i<$nDiagno; $i++){
		$script=$script."$('#txt".$this->get_var('dia.id.'.$i)."').typeahead({
	  hint: true,
	  highlight: true,
	  minLength: 1
	},
	{
	  name: 'cps',
	  source: cpSuggest,
	  limit: 10
	});";
	}
$script=$script."


	$('#nomeCpD').typeahead({
	  hint: true,
	  highlight: true,
	  minLength: 1
	},
	{
	  name: 'cps',
	  source: cpSuggest,
	  limit: 10
	});
								
							});
							</script>";
					
					if ($cp_id == NULL){
					
					echo $script;}
					
						?>	
						
							
							
						
				
					<div class="col-lg-12">
						<div class="form-group">
							<label class="control-label col-lg-4">Diagnosi:</label>
							<div class="col-lg-4">
								<input id="nomeD" type="text"  class="form-control"/>
							</div>
						</div>
					</div>
					
					<div class="col-lg-12">
						<div class="form-group">
						<label class="control-label col-lg-4">Care provider:</label>
						<div class="col-lg-4">
						@if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
						<input id="nomeCpD" value="{{$current_user->getName()}} {{$current_user->getSurname()}}" readonly class="form-control"/>
						@endif
								
								</div>
						</div>
						</div>
						
						
						<div class="col-lg-12" style="display:none;">
						<div class="form-group">
						<label class="control-label col-lg-4">cpId:</label>
						<div class="col-lg-4">
							@if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
							<input id="cpId" readonly value="$current_user->id_utente" class="form-control"/>
							@else
							<input id="cpId" readonly value="-1" class="form-control"/>
							@endif

						</div>
						</div>
						</div>
						<div class="col-lg-12" style="display:none;">
						<div class="form-group">
						<label class="control-label col-lg-4">pzId:</label>
						<div class="col-lg-4">
						
						<input id="pzId" readonly value="{{$visitingId}}" class="form-control"/>
						</div>
						</div>
						</div>
		    
					<div class="col-lg-12">
						<div class="form-group">		
							<label class="control-label col-lg-4">Stato:</label>
								<div class="col-lg-4">
									<select id="statoD" class="form-control">
										<option selected value="0">Sospetta</option>
										<option value="1">Confermata</option>
										<option value="2">Esclusa</option>
									</select>
								</div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">	
							<label class="control-label col-lg-4">Confidenzialità:</label>
								<div class="col-lg-4">
									<select id="confD" class="form-control">
										<option value = "1">Nessuna Restrizione</option>
										<option value = "2">Basso</option>
										<option value = "3">Moderato</option>
										<option value = "4">Normale</option>
										<option value = "5">Riservato</option>
										<option value = "6">Strettamente Riservato</option>
									</select>
								</div>
						</div>
					</div>				
				</div>
			</div>
		
		</form>
		<br>
							<div class="row">
							<div class="col-lg-12">
							<div class="panel panel-danger">
							   <div class="panel-heading">Confermate</div>		
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table" id="tableConfermate">
										<thead>
                                                                <tr>
                                                                	<th>Diagnosi</th>
                                                                    <th>Ultimo aggiornamento</th>
                                                                   
																	<th>Visibilità</th> 
																	<th>Care provider</th>
																	<th>Opzioni</th>
                                                                    
                                                                </tr>
                                                            </thead>
										 <tbody>
        <?php
		
		


																	
																		
																		
																		
																			
																			
																		
                                                                        $num = $conf;
																		for($i=0; $i<$num ; $i+=5){
																			
																		if ($arrConf[$i + 1]<=$livConf)
																			{
																				echo '<tr id="r'.$arrConf[$i + 4].'">';
																					echo '<td>'.$arrConf[$i + 0].'</td>';
																					echo '<td>'.$arrConf[$i + 2].'</td>';
																				
																					echo '<td>'.$arrConf[$i + 1].'</td>';
																					echo '<td>'.$arrConf[$i + 3].'</td>';
																					echo '<td>
																					<div id="row">
																					<div id="col-lg-12">
																					<div id="btn-group">';
																							
																							echo '<button id='.$arrConf[$i + 4].' class="indagini btn btn-primary"><i class="icon-search icon-white"></i></button>
																							<button id='.$arrConf[$i + 4].' class="terapie btn btn-warning"><i class="icon-lightbulb icon-white"></i></button>
																							<button id='.$arrConf[$i + 4].' class="anamnesi btn btn-danger"><i class="icon-remove icon-white"></i></button>
																								
																						   </div></div></div>';
																						  echo'<form id="indagini'.$arrConf[$i + 4].'" action="index.php?pag=indagini';if($cp_id != NULL){echo '&cp_Id='.$cp_id.'&pz_Id='.$pz_id;} echo '" method="post">

																					<input readonly style="display:none;" type="text" name="idDiagnosi" value="'.$arrConf[$i + 4].'" />
																					
																					</form>';
																					echo'<form id="terapie'.$arrConf[$i + 4].'" action="index.php?pag=terapie';if($cp_id != NULL){echo '&cp_Id='.$cp_id.'&pz_Id='.$pz_id;} echo '" method="post">
																						
																					<input readonly style="display:none;" type="text" name="idDiagnosi" value="'.$arrConf[$i + 4].'" />
																					
																					</form></td>';
																				echo '</tr>'; 
				echo '																	
	<tr id="riga'.$arrConf[$i + 4].'" style="display:none">
		<td colspan="5">
			<form class="form-horizontal">
				<div class="row">						


					<div class="col-lg-12"'; /*if($cp_id == NULL) echo 'style="display:none;"';*/  echo '>
						<div class="form-group">
							<label class="control-label col-lg-4">Stato:</label>
							<div class="col-lg-4">
								<select class="form-control" id="selStat'.$arrConf[$i + 4].'">
									<option value="0" >Sospetta</option>
									<option value="1" selected>Confermata</option>
									<option value="2" >Esclusa</option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-lg-12"'; if($cp_id != NULL) echo 'style="display:none;"'; echo '>
						<div class="form-group">
							<label class="control-label col-lg-4">Confidenzialità:</label>
							<div class="col-lg-4">
								<select class="form-control" id="selConf'.$arrConf[$i + 4].'">';
										
										$countConf = 1;
										foreach($this->get_var('arrayConf') as $conf ){
											echo '<option ';
											if($arrConf[$i+1]==$countConf)
												echo 'selected ';
											echo 'value="'.$conf['codice'].'">'.$conf['descrizione'].'</option>';
											$countConf++;
										}													
									
									/*echo '<option value="1"'; if($arrConf[$i + 1]==1) {echo ' selected';} echo '>Nessuna restrizione</option>
									<option value="2"'; if($arrConf[$i + 1]==2) {echo ' selected';} echo '>Basso</option>
									<option value="3"'; if($arrConf[$i + 1]==3) {echo ' selected';} echo '>Normale</option>
									<option value="4"'; if($arrConf[$i + 1]==4) {echo ' selected';} echo '>Moderato</option>
									<option value="5"'; if($arrConf[$i + 1]==5) {echo ' selected';} echo '>Riservato</option>
									<option value="6"'; if($arrConf[$i + 1]==6) {echo ' selected';} echo '>Strettamente riservato</option>*/
								echo '</select>
							</div>
						</div>
					</div>
																						
					<div class="col-lg-12"'; if($cp_id != NULL) echo 'style="display:none;"'; echo '>
						<div class="form-group">
							<label class="control-label col-lg-4">Care provider:</label>
							<div class="col-lg-4">';
							$splitCps = explode(' (Conferm.)<br>', $arrConf[$i + 3]);
							echo'
								<input id="txt'.$arrConf[$i + 4].'" type="text"  class="form-control" value="'.$splitCps[0].'"
							</div>
						</div>
					</div>
					</div>				
									
					
				</div>
			</form>
			
			<div style="text-align:right;">
				<a href="" onclick="return false;" class=annulla id="'.$arrConf[$i + 4].'">[Annulla]</a>
				<a href="" onclick="return false;" class=conferma id="'.$arrConf[$i + 4].'">[Conferma]</a>
			</div>
			
		</td>
	</tr>';
																				
																			}
                                                                        }
                                                                 ?>
                                                            </tbody>
									</table>

								</div><!--table responsive-->
							   </div>
							</div>
						</div>
						</div><!--row-->
                                 
							
							
								<div class="row">
							<div class="col-lg-12">
								
								
							<div class="panel panel-warning">
							   <div class="panel-heading">Sospette</div>

										
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table" id="tableSospette">
										<thead>
                                                                <tr>
                                                                	<th>Diagnosi</th>
                                                                    <th>Ultimo aggiornamento<br/></th>
                                                                   
																	<th>Visibilità</th> 
																	<th>Care provider</th>
																	<th>Opzioni</th>
                                                                    
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                        $num=$sosp;
																		
                                                                        for($i=0; $i<$num ; $i+=5){
																			
                                                                            if ($arrSosp[$i + 1]<=$livConf)
																			{
																				echo '<tr class="info" id="r'.$arrSosp[$i + 4].'">';
																					echo '<td id="diagnosiSosp'.$arrSosp[$i + 4].'">'.$arrSosp[$i + 0].'</td>';
																					echo '<td id="dataSosp'.$arrSosp[$i + 4].'">'.$arrSosp[$i + 2].'</td>';
																					echo '<td id="confSosp'.$arrSosp[$i + 4].'">'.$arrSosp[$i + 1].'</td>';
																					echo '<td id="cpSosp'.$arrSosp[$i + 4].'">'.$arrSosp[$i + 3].'</td>';
																					echo '<td>
																					<div id="row">
																					<div id="col-lg-12">
																					<div id="btn-group">
																					<button id='.$arrSosp[$i + 4].' class="indagini btn btn-primary"><i class="icon-search icon-white"></i></button>
																					<button id='.$arrSosp[$i + 4].' class="modifica btn btn-success "><i class="icon-pencil icon-white"></i></button>
																					<button id='.$arrSosp[$i + 4].' class="elimina btn btn-danger"><i class="icon-remove icon-white"></i></button>
																					
																					</div></div></div>';
																					echo'<form id="indagini'.$arrSosp[$i + 4].'" action="index.php?pag=indagini';if($cp_id != NULL){echo '&cp_Id='.$cp_id.'&pz_Id='.$pz_id;} echo '" method="post">
																					<input readonly style="display:none;" type="text" name="idDiagnosi" value="'.$arrSosp[$i + 4].'" />
																					
																					</form></td>';
																					//if ($myRole == ass)
																					//	echo "<td>",$this->get_var('diagnosi_'.$i.'_visibilita'),"</td>\n";
																				echo '</tr>'; 
																				
																				echo '																	
	<tr id="riga'.$arrSosp[$i + 4].'" style="display:none">
		<td colspan="5">
			<form class="form-horizontal">
				<div class="row">	

					<div class="col-lg-12"'; /*if($cp_id == NULL)echo 'style="display:none;"';*/  echo '>
						<div class="form-group">
							<label class="control-label col-lg-4">Stato:</label>
							<div class="col-lg-4">
								<select class="form-control" id="selStat'.$arrSosp[$i + 4].'">
									<option value="0" selected>Sospetta</option>
									<option value="1" >Confermata</option>
									<option value="2" >Esclusa</option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-lg-12"'; if($cp_id != NULL) echo 'style="display:none;"'; echo '>
						<div class="form-group">
							<label class="control-label col-lg-4">Confidenzialità:</label>
							<div class="col-lg-4">
								<select class="form-control" id="selConf'.$arrSosp[$i + 4].'">
									<option value="1"'; if($arrSosp[$i + 1]==1) {echo 'selected';} echo '>Nessuna restrizione</option>
									<option value="2"'; if($arrSosp[$i + 1]==2) {echo 'selected';} echo '>Basso</option>
									<option value="3"'; if($arrSosp[$i + 1]==3) {echo 'selected';} echo '>Normale</option>
									<option value="4"'; if($arrSosp[$i + 1]==4) {echo 'selected';} echo '>Moderato</option>
									<option value="5"'; if($arrSosp[$i + 1]==5) {echo 'selected';} echo '>Riservato</option>
									<option value="6"'; if($arrSosp[$i + 1]==6) {echo 'selected';} echo '>Strettamente riservato</option>
								</select>
							</div>
						</div>
					</div>
																						
					<div class="col-lg-12"'; if($cp_id != NULL) echo 'style="display:none;"'; echo '>
						<div class="form-group">
							<label class="control-label col-lg-4">Care provider:</label>
							<div class="col-lg-4">';
							$splitCps = explode(' (Sospetta)<br>', $arrSosp[$i + 3]);							
							echo'
								<input id="txt'.$arrSosp[$i + 4].'" type="text"  class="form-control" value="'.$splitCps[0].'"
							</div>
						</div>
					</div>
					</div>				
									
					
				</div>
			</form>
			<div style="text-align:right;">
				<a href="" onclick="return false;" class=annulla id="'.$arrSosp[$i + 4].'">[Annulla]</a>
				<a href="" onclick="return false;" class=conferma id="'.$arrSosp[$i + 4].'">[Conferma]</a>
			</div>
			
		</td>
	</tr>';
																			}
                                                                        }
                                                                 ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
												</div>
											</div>	<!--panelwarning-->	
									</div>	<!--col lg12-->
								</div>
								
								
								
							<div class="row">
							<div class="col-lg-12">
								
								
							<div class="panel panel-success">
							   <div class="panel-heading">Escluse</div>

										
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table" id="tableEscluse">
										<thead>
                                                                <tr>
                                                                	<th>Diagnosi</th>
                                                                    <th>Ultimo aggiornamento<br/></th>
                                                                   
																	<th>Visibilità</th> 
																	<th>Care provider</th>
																	<th>Opzioni</th>
                                                                    
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
																		$num = $escl;
                                                                        for($i=0; $i<$num ; $i+=5){
																			
                                                                            if ($arrEscl[$i + 1]<=$livConf)
																			{
																				echo '<tr class="info" id="r'.$arrEscl[$i + 4].'">';
																					echo '<td>'.$arrEscl[$i + 0].'</td>';
																					echo '<td>'.$arrEscl[$i + 2].'</td>';
																					echo '<td>'.$arrEscl[$i + 1].'</td>';
																					echo '<td>'.$arrEscl[$i + 3].'</td>';
																					//if ($myRole == ass)
																					//	echo "<td>",$this->get_var('diagnosi_'.$i.'_visibilita'),"</td>\n";
																					echo '<td>
																					<div id="row">
																					<div id="col-lg-12">
																					<div id="btn-group">';
																					//<button id='.$arrEscl[$i + 4].' class="modifica btn btn-primary "><i class="icon-pencil icon-white"></i></button>
																					echo '
																					
																					<button id='.$arrEscl[$i + 4].' class="indagini btn btn-primary"><i class="icon-search icon-white"></i></button>
																					<button id='.$arrEscl[$i + 4].' class="elimina btn btn-danger"><i class="icon-remove icon-white"></i></button>
																					</div></div></div>'
																					;
																					echo'<form id="indagini'.$arrEscl[$i + 4].'" action="index.php?pag=indagini';if($cp_id != NULL){echo '&cp_Id='.$cp_id.'&pz_Id='.$pz_id;} echo '" method="post">
																					<input readonly style="display:none;" type="text" name="idDiagnosi" value="'.$arrEscl[$i + 4].'" />
																					
																					</form></td>';
																				echo '</tr>'; 
echo '																	
	<tr id="riga'.$arrEscl[$i + 4].'" style="display:none">
		<td colspan="5">
			<form class="form-horizontal">
				<div class="row">			

					<div class="col-lg-12"'; /*if($cp_id == NULL) echo 'style="display:none;"';*/ echo '>
						<div class="form-group">
							<label class="control-label col-lg-4">Stato:</label>
							<div class="col-lg-4">
								<select class="form-control" id="selStat'.$arrEscl[$i + 4].'">
									<option value="0" >Sospetta</option>
									<option value="1" >Confermata</option>
									<option value="2" selected>Esclusa</option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-lg-12"'; if($cp_id != NULL) echo 'style="display:none;"'; echo '>
						<div class="form-group">
							<label class="control-label col-lg-4">Confidenzialità:</label>
							<div class="col-lg-4">
								<select class="form-control" id="selConf'.$arrEscl[$i + 4].'">
									<option value="1"'; if($arrEscl[$i + 1]==1) {echo 'selected';} echo '>Nessuna restrizione</option>
									<option value="2"'; if($arrEscl[$i + 1]==2) {echo 'selected';} echo '>Basso</option>
									<option value="3"'; if($arrEscl[$i + 1]==3) {echo 'selected';} echo '>Normale</option>
									<option value="4"'; if($arrEscl[$i + 1]==4) {echo 'selected';} echo '>Moderato</option>
									<option value="5"'; if($arrEscl[$i + 1]==5) {echo 'selected';} echo '>Riservato</option>
									<option value="6"'; if($arrEscl[$i + 1]==6) {echo 'selected';} echo '>Strettamente riservato</option>
								</select>
							</div>
						</div>
					</div>
																						
					<div class="col-lg-12"'; if($cp_id != NULL) echo 'style="display:none;"'; echo '>
						<div class="form-group">
							<label class="control-label col-lg-4">Care provider:</label>
							<div class="col-lg-4">';
							$splitCps = explode(' (Esclusa)<br>', $arrEscl[$i + 3]);
							echo'
								<input id="txt'.$arrEscl[$i + 4].'" type="text"  class="form-control" value="'.$splitCps[0].'"
							</div>
						</div>
					</div>
					</div>				
									
					
				</div>
			</form>
			<div style="text-align:right;">
				<a href="" onclick="return false;" class=annulla id="'.$arrEscl[$i + 4].'">[Annulla]</a>
				<a href="" onclick="return false;" class=conferma id="'.$arrEscl[$i + 4].'">[Conferma]</a>
			</div>
			
		</td>
	</tr>';
																			}
                                                                        }
                                                                 ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
													
												</div>	<!--panelbody-->
											</div>
									</div>	<!--col lg12-->
								</div><!--row-->
						
						

                    </div>
                </div>
                <hr />
            </div>
			
			
        </div>


<!--END PAGE CONTENT -->
@endsection