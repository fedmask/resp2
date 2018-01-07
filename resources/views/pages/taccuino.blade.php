@extends('layouts.app')
@extends('includes.template_head')

@section('pageTitle', 'Taccuino Paziente')
@section('content')
<!--PAGE CONTENT -->
<script src="{{ asset('js/dolore.js') }}"></script>
<div id="content">
	<div class="inner" style="min-height:1200px;">
		<div class="row">
			<div class="col-lg-12">
				<h2>Taccuino Paziente</h2>
				<!-- TODO: Rinserire dal resp vecchio le politiche di lettura in base al livello di confidenzialità -->
			</div>
		</div>
	<hr />

	<!--inizio modal canvas-->
	{{ Form::open(array('id'=>'report', 'url'=>'/pazienti/taccuino/addReporting')) }}
		{{ csrf_field() }}
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<div class="modal" id="canvasModal" tabindex="-1"    role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Annotazioni del paziente e rappresentazione del dolore</h4>
					<button type="submit" id="sendBtn" name="sendBtn" class="btn btn-primary">Salva e Chiudi</button>
					<!--<button class="btn btn-danger btn-lg btn-line btn-block" style="text-align:left;" onclick="erase_dolore()">btn-lg-->
						<button type="button" class="btn btn-danger " style="text-align:right;" onclick="erase_dolore()">
							<!--&nbsp;&nbsp;&nbsp;--><i class="icon-eraser icon-2x"></i> Cancella tutto fronte</button>
							<button type="button" class="btn btn-danger " style="text-align:right;" onclick="erase_dolore_back()">
								<!--&nbsp;&nbsp;&nbsp;--><i class="icon-eraser icon-2x"></i> Cancella tutto retro</button>
								<button type="button" class="btn btn-danger " style="text-align:right;" onclick="toggleBackFront()">
									<!--&nbsp;&nbsp;&nbsp;--><i class=" icon-resize-horizontal icon-2x"></i> Fronte/Retro</button>
								</div>
								<div class="modal-body">
									<div class="row">
										<div class="well col-lg-12">
											<div class="pain_save">
												{{Form::textarea('save_pain_textarea', null, ['id'=>"save_pain_textarea", 'name'=>"save_pain_textarea", 'placeholder'=>"Inserire note personali come modalità di insorgenza del dolore, durata etc...", 'rows'=>"1", 'class'=>"form-control"])}}
											</div>
										</br>
										<div class="form-group">
											<label class="control-label col-lg-1" for="datanota">Data:</label>
											<div class="col-lg-3">
												{{Form::date('date', \Carbon\Carbon::now(), ['id'=>"datanota", 'name'=>"datanota", 'class'=>"form-control"])}}
											</div>     
										</div>			
									</div>
									<div class="well col-lg-8">
										<canvas id="canvas_dolore" class="front" width="347" height="866" style="border:2px solid;"></canvas>
										<input type="hidden" name="front">
										<canvas id="canvas_dolore_back" class="back" width="347" height="866" style="border:2px solid;"></canvas>
										<input type="hidden" name="back">
									</div>
									<div class="well col-lg-4">
										<button type="button" class="btn btn-primary btn-lg btn-line btn-block" style="text-align:left;" onClick="color_dolore('#00ff00')">
											&nbsp;&nbsp;<img src="img/taccuino/dolore_verde.png" /> Nessun dolore</button>
											<button type="button" class="btn btn-primary btn-lg btn-line btn-block" style="text-align:left;" onClick="color_dolore('#ffffff')">
												&nbsp;&nbsp;<img src="img/taccuino/dolore_bianco.png" /> Dolore lieve</button>
												<button type="button" class="btn btn-primary btn-lg btn-line btn-block" style="text-align:left;" onClick="color_dolore('#2323d2')">
													&nbsp;&nbsp;<img src="img/taccuino/dolore_blu.png" /> Dolore moderato</button>
													<button type="button" class="btn btn-primary btn-lg btn-line btn-block" style="text-align:left;" onClick="color_dolore('#8a2070')">
														&nbsp;&nbsp;<img src="img/taccuino/dolore_viola.png" /> Dolore intenso</button>
														<button type="button" class="btn btn-primary btn-lg btn-line btn-block" style="text-align:left;" onClick="color_dolore('#7a0026')">
															&nbsp;&nbsp;<img src="img/taccuino/dolore_porpora.png" /> Dolore forte</button>
															<button type="button" class="btn btn-primary btn-lg btn-line btn-block" style="text-align:left;" onClick="color_dolore('#ff0000')">
																&nbsp;&nbsp;<img src="img/taccuino/dolore_rosso.png" /> Dolore molto forte</button>
																<br/>
                                                <button class="btn btn-danger btn-lg btn-line btn-block" style="text-align:left;" onclick="erase_dolore()">
                                                	&nbsp;&nbsp;&nbsp;<i class="icon-eraser icon-2x"></i> Cancella tutto</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        	<button type="button" class="btn btn-primary" onclick="save_dolore()" data-dismiss="modal">Salva e Chiudi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {{ Form::close() }}

                        
                        <!--fine modal canvas-->

                            <div class="row">
                            	<div class="col-lg-12">
                            		<div class="box dark">
                            			@if($current_user->getRole() == User::PATIENT_DESCRIPTION)
                            			<header>
                            				<h5>Aggiorna il taccuino</h5>
                            				</header>
                            				<p>
                            				<button class="btn btn-danger btn-block" data-toggle="modal" data-target="#canvasModal"><i class="icon-pencil"></i> Nuova segnalazione</button>
                            				</p>
                            			@endif
                            			<div class="col-lg-12">
                            				<div class="panel panel-warning">
                            					<div class="panel-heading">
                            						Annotazioni
                            					</div>
                            					<div class="panel-body">
                            						<div class="table-responsive" >
                            							<table class="table" >
                            								<thead>
                            									<tr>
                            										<th>Descrizione</th>
                            										<th>Data</th>
                            										<th>Opzioni</th>
                            									</tr>
                            								</thead>
                            								<tbody>
                            									<!-- TODO: rivedere dal vecchio resp le cronologie -->
                            									@foreach ($records as $record)
                            									<tr>
                            										<td>{{ $record->taccuino_descrizione }}</td>
                            										<td><?php echo date('d/m/y', strtotime($record->taccuino_data)); ?></td>
                            										<td>
                            											<form action="/pazienti/taccuino/removeReporting" method="POST">
                            												{{ csrf_field() }}
                            											<table><tbody><tr><td>
																			<button type="button" id="showPain_{{$record->id_taccuino}}" class="showPain btn btn-default btn-info">
																				<i class="icon-search"></i>
																			</button>
																	</td><td>
																		
																			
																			<button id="removePain_{{$record->id_taccuino}}" class="removePain btn btn-default btn-danger">
																				<i class="icon-remove"></i>
																			</button>
																			<input type="hidden" name="id_taccuino" id="id_contact" value="{{$record->id_taccuino}}">
																		
																		<input id="painFront_{{$record->id_taccuino}}" type="hidden" value="{{$record->taccuino_report_anteriore }}"></input>
																		
																		<img id="canvas_dolore" class="M" src="{{$record->taccuino_report_anteriore }}"></img>
																		<input id="painBack_{{$record->id_taccuino}}" type="hidden" value="{{$record->taccuino_report_posteriore }}"></input>
																		
																	</td></tr></tbody></table>
																</form>
																</td>
																	</tr>
                            									</tr>
																@endforeach
                            								</tbody>
                            							</table>
                            						</div>
                            					</div>
									<!--<div class="panel-footer" style="text-align:right">
										<button class="btn btn-primary btn-sm btn-line" data-toggle="modal" data-target="#modpatcontemergmodal"><i class="icon-pencil icon-white"></i> Modifica</button>
									</div>-->
							</div>
						</div> 
						<center><img id="canvasimg" class="{{$current_user->getGender()}}>"> <img id="canvasimg_back"><br/><br/></center>
					</div>
				</div>
		</div>
	</div>
</div>

						<script>
                        	getFront();
                        	getBack();
                        	$( document ).ready(function() {
                        		$('.showPain').click(function(){
                        			var idShow = $(this).attr('id').split('_')[1];
                        			document.getElementById("canvasimg_back").src = atob($('#painBack_'+1).val());
									document.getElementById("canvasimg").src = atob($('#painFront_'+1).val());
                        		});

                        		$('input[name=front]').val(getFront());
                        		$('input[name=back]').val(getBack());
                        		$("#report").on("submit", function(e){
                        		   $('input[name=front]').val(getFront());
                        		   $('input[name=back]').val(getBack());
								   $.ajaxSetup({
						                headers: {
						                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						                }
						            });

								   $.ajax({
						                url: '/pazienti/taccuino/addReporting',
						                data: {description: "prova"},
						                method: 'POST',
						                datatype: 'JSON',					                
						                success: function (response) {
						                    if (response.status === true) {
						                    	alert($('input[name=front]').val());
						                        console.log(response.message);
						                        $('#myModalCallback').modal('toggle');
						                    } else {
						                        alert($('#front').val());
						                    }
						                },
						                error: function (response) {
						                    $('#errormessage').html(response.message);
						                }
								 	});
                        		});
                        	});
                        </script>
<!--END PAGE CONTENT -->
@endsection