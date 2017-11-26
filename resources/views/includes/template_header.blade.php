<link href="/css/icon_chat.css" rel="stylesheet">
<link href="/css/chat_style.css" rel="stylesheet">
<!-- Typeahead plugin -->
<link href="/css/typeahead.css" rel="stylesheet">

<!-- BEGIN BODY-->
@php( $role = App\ User::find( Auth::id() )[ 'role' ] )
<body class="padTop53 ">
	<audio id="notification_audio">
		<source src="/audio/incoming_mex.mp3" type="audio/mpeg"></source>
	</audio>
	<!-- MAIN WRAPPER -->
	<div id="wrap">
		<!--MESSAGES MODAL -->
		<div class="col-lg-12">
			<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-chat">
					<div class="modal-content">
						<div class="modal-body">
							<div class="row">
								<div id="messagesList" class="col-lg-4 col-md-6">
									<!--Alt messages list-->
									<div class="panel widget-messages-alt">
										<div class="panel-heading">
											<span class="panel-title"><i class="panel-title-icon fa fa-envelope"></i>Lista messaggi</span>
										</div>
										<!-- / .panel-heading -->
										<div class="panel-body padding-sm">
											<div id="messages_list" class="messages-list">
												<?php
												/*
												for($i=0; $i< $this->get_var('conversation_num'); $i++){
													$lastMex = $this ->get_var('lastmex_conversation_'.$i);
													//echo " NUM MEX CONV: ".$i." ".$this->get_var('mex_conversation_'.$i.'_num');
													if($this->get_var('conv_status_'.$i) == 0){
														echo '<div id="message_conversation#'.$this -> get_var('conversation_'.$i.'_id').'" class="message_'.$this -> get_var('conversation_'.$i.'_id').' message message_conversation_'.$this -> get_var('conversation_'.$i.'_id').' conversation_unread">
															<input id="message_conversation_value_'.$this -> get_var('conversation_'.$i.'_id').'" value="'.$this -> get_var('conversation_'.$i.'_id').'" class="message_conversation_value"></input>
															<input id="message_conversation_otheruserid_'.$this -> get_var('conversation_'.$i.'_id').'" value="'.$this -> get_var('otherUser_id_'.$i).'" class="message_conversation_value"></input>
															<input id="first_second_user_conv_'.$this -> get_var('conversation_'.$i.'_id').'" value="'.$this->get_var('first_second_user_conv_'.$i).'" class="first_second_user" ></input>
															<img src="'.$this->get_var('patientpic_path_'.$i).'" alt="" class="message-avatar-alt">
															<a href="#" class="message-subject">'.$lastMex->getLabel().'</a>
															<div class="message-description">
																da <a href="#">'.$this->get_var('user_name_'.$i).'</a>
																&nbsp;&nbsp;·&nbsp;&nbsp;'.$this->get_var('lastmex_conversation_'.$i.'_time').'
															</div> <!-- / .message-description -->
														</div> <!-- / .message -->';
													}else{
														echo '<div id="message_conversation#'.$this -> get_var('conversation_'.$i.'_id').'" class="message_'.$this -> get_var('conversation_'.$i.'_id').' message message_conversation_'.$this -> get_var('conversation_'.$i.'_id').' conversation_mex">
															<input id="message_conversation_value_'.$this -> get_var('conversation_'.$i.'_id').'" value="'.$this -> get_var('conversation_'.$i.'_id').'" class="message_conversation_value"></input>
															<input id="message_conversation_otheruserid_'.$this -> get_var('conversation_'.$i.'_id').'" value="'.$this -> get_var('otherUser_id_'.$i).'" class="message_conversation_value"></input>
															<input id="first_second_user_conv_'.$this -> get_var('conversation_'.$i.'_id').'" value="'.$this->get_var('first_second_user_conv_'.$i).'" class="first_second_user" ></input>
															<img src="'.$this->get_var('patientpic_path_'.$i).'" alt="" class="message-avatar-alt">';
														if (isset ($lastMex))
														echo'	
															<a href="#" class="message-subject">'.$lastMex->getLabel().'</a>';
														echo '	<div class="message-description">
																da <a href="#">'.$this->get_var('user_name_'.$i).'</a>
																&nbsp;&nbsp;·&nbsp;&nbsp;'.$this->get_var('lastmex_conversation_'.$i.'_time').'
															</div> <!-- / .message-description -->
														</div> <!-- / .message -->';
													}
												}
												echo '<div id="new_conversation" class="message new_conversation" style="height: auto; width: auto;">
															<i class="icon-plus"></i>
															<a href="#" class="message-subject"></a>
															<div class="message-description">
																a <input   id="sendToUser" name="sendToUser" type="text"  class="typeahead message">
																&nbsp;&nbsp;·&nbsp;&nbsp;
															</div> <!-- / .message-description -->
														</div> <!-- / .message -->';
														*/
												?>
											</div>
											<!-- / .messages-list -->
										</div>
										<!-- / .panel-body -->
									</div>
									<!-- / .panel -->
									<!-- Fine MESSAGES_LIST_ALT -->
								</div>

								<div id="messagesChat" class="col-lg-8 col-md-6">

									<!--Chat-->
									<div class="panel widget-chat">
										<div class="panel-heading">
											<span class="panel-title"><i class="panel-title-icon fa icon_custom-chat"></i>Messaggi privati</span>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="closeMessageModal">&times;</button>
										</div>
										<!-- / .panel-heading -->
										<div id="messages_chat" class="panel-body">

											<?php
											/*
											for($i=0; $i<$this->get_var('conversation_num'); $i++){
												echo '<div id="container_conversation_'.$this -> get_var('conversation_'.$i.'_id').'">';
												for($j=0; $j<$this->get_var('mex_conversation_'.$i.'_num'); $j++){
													echo '
													<div data-timestamp="'.$this->get_var('mex_'.$j.'_conversation_'.$i.'_time').'"  class="'.$this -> get_var('mex_'.$j.'_conversation_'.$i.'_class').' mex_conversation mex_conversation_'.$this -> get_var('conversation_'.$i.'_id').'">
														<img src="'.$this->get_var('mex_conv_'.$i.'patientpic_path_'.$j).'" alt="" class="message-avatar">
														<div class="message-body">
															<div class="message-heading">
																<a class="username" href="#" title="">'.$this->get_var('mex_'.$j.'_conversation_'.$i.'_username').' </a> scrive:
																<span class="pull-right">'.$this->get_var('mex_'.$j.'_conversation_'.$i.'_time').'</span>
															</div>
															<div class="message-text">'.$this->get_var('mex_'.$j.'_conversation_'.$i.'_content').'
															</div>
														</div> <!-- / .message-body -->
													</div>  <!-- / .message -->';
												}
												echo '</div>';
											}*/
											?>

										</div>
										<!-- / .panel-body -->
										<form class="panel-footer panel-footer-chat chat-controls" id="send_private_message">
											<div class="chat-controls-input">
												<textarea id="send_private_message_textarea" rows="1" class="form-control"></textarea>
												<input id="idsorgente" value="{{ Auth::id() }}" class="submission"></input>
												<input id="iddestinatario" value="-1" class="submission"></input>
												<input id="idconversazione" value="-1" class="submission"></input>
											</div>
											<button id="send_private_message_btn" class="btn btn-primary chat-controls-btn">Invia</button>
										</form>
										<!-- / .panel-footer -->
									</div>
									<!-- / .panel -->
									<!-- Fine chat -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<!--END MESSAGES MODAL -->

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
					<!-- HOME SECTION -->
					@if( $role === 'paziente')
					<li><a href="/home">Home <em class="icon-home"></em> </a>
					</li>
					@else
					<li><a href="/home">Home <em class="icon-home"></em> </a>
					</li>
					@endif
					<!-- END HOME SECTION -->


					<!--ALERTS SECTION -->
					<?php
					/*
					if ( $role == "pz"){
					echo'
                    <li class="chat-panel dropdown">
                        <a id="numNotification_dropdown" class="" href="#">messaggi: <i class="panel-title-icon fa icon_custom-chat"></i>';
							if($this->get_var('label_notifiche') == 0){
								echo '<span id="numNotification" class="label label-info">';
							}else{
								echo '<span id="numNotification" class="label label-danger">';
							}
							echo $this->get_var('label_notifiche') . 
						 '</a>

                        <ul id="modal_notification" class="dropdown-menu dropdown-alerts">'.
						
							$num=$this->get_var('label_notifiche'); //le notifiche mostrate sono massimo 7
							if($num>7) { $num=7; }
							for($i=0; $i<$this->get_var('conversation_num') ; $i++){
								$lastMex = $this ->get_var('lastmex_conversation_'.$i);
								if($this->get_var('conv_status_'.$i) == 0){
									echo "<li id=\"notification_conversation#".$this -> get_var('conversation_'.$i.'_id')."\" class=\"notification_conversation notification_conversation_".$this -> get_var('conversation_'.$i.'_id')."\">
                                		<a data-toggle=\"modal\" data-target=\"#messageModal\" href=\"\">
                                    		<div>
                                        	<i class=\"icon-envelope\"></i> ", $lastMex->getLabel(),
                                    		"</div>
											<span class=\"small\">DA: ".$this->get_var('user_name_'.$i)."<span><br>
											<span class=\"text-muted\" >".$this->get_var('lastmex_conversation_'.$i.'_time')."</span>
                                		</a>
                            		 </li>
                            		<li id=\"notification_divider_conversation#".$this -> get_var('conversation_'.$i.'_id')."\" class=\"divider notification_divider_conversation_".$this -> get_var('conversation_'.$i.'_id')."\"></li>";
								}
							}
                       echo '    
                            
                            <li>
                                <a class="text-center " data-toggle="modal" data-target="#messageModal" href=" ' . $this->get_var('link_mostratutti').' ">
                                    <strong>Mostra tutti</strong>
                                    <i class="icon-angle-right"></i>
                                </a>
                            </li>
                        </ul>

                    </li>';
					}*/
					?>
					<!-- END ALERTS SECTION -->
					<!--USER SETTINGS SECTIONS -->
					<!--rispetto alla versione originale si è tolta la classe dropdown  e si sono lasciate la modifica				
					delle impostazioni di sicurezza ed il logout nella lista della navbar-->
					<!--Modifica impostazioni sicurezza  -->
					@if( $role === 'paziente')
					<li>
						<a href=" '. $this->get_var('link_impostazionisicurezza'). ' "><i class="icon-lock"></i>Impostazioni di sicurezza</a>
					</li>
					@else
					<li><a href="http://fsem.di.uniba.it/modello%20PBAC/createPDF.php"><i class="icon-book"></i> Report</a>
					</li>
					@endif

					<!-- se l'utente e' un paziente visualizzo il pulsante per l'esportazione del profilo -->
					@if( $role === 'paziente')
					<li><a href="/formscripts/exportPatient.php?patientid=' . $pz_id . '"><i class="glyphicon glyphicon-cloud-download"></i> Esporta profilo</a>
					</li>
					@endif
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
		<!-- END HEADER SECTION -->