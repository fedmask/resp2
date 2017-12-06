@extends( 'auth.layouts.basic_registration' )
@extends( 'auth.layouts.registration_head' )

@section( 'pageTitle', 'Registrazione Paziente' )
@section('register_content')
	<!--REGISTER SECTION-->

	<section id="register" class="register-section">
	
		<div class="container">

			<div class="row">

				<div class="col-lg-12">



					<center>

						<section id="head">

							<img src="/img/IconPatient.png" alt="pzicon"></img>

						</section>
						<br>

						<h1>Registrazione paziente</h1>

					</center>

					<br>

					<br>
					<form id="" action="/register/patient" method="POST" class="form-horizontal">
					{{ csrf_field() }}
						<h3>Account</h3>
						<fieldset>
							<div class="form-group">
								<label for="userName" class="control-label col-lg-3">Username *</label>
								<div class="col-lg-3"><input id="userName" name="username" type="text" class="form-control">
								</div>
								<input id="role" name="role"></input>
							</div>



							<div class="form-group">

								<label for="email" class="control-label col-lg-3">Email *</label>

								<div class="col-lg-3"><input id="email" name="email" type="email" class="form-control">
								</div>

								<label for="confirmEmail" class="control-label col-lg-3">Conferma Email *</label>

								<div class="col-lg-3"><input id="confirmEmail" name="confirmEmail" type="email" class="form-control">
								</div>

							</div>



							<div class="form-group">

								<label for="password" class="control-label col-lg-3">Password *</label>

								<div class="col-lg-3"><input id="password" name="password" type="password" class="form-control" placeholder="almeno 8 caratteri tra cui una cifra">
								</div>

								<label for="confirmPassword" class="control-label col-lg-3">Conferma Password *</label>

								<div class="col-lg-3">
									<input id="confirmPassword" name="confirmPassword" type="password" class="form-control">
								</div>
							</div>
							<div class="form-group">

								<label for="surname" class="control-label col-lg-3">Cognome *</label>

								<div class="col-lg-3"><input id="surname" name="surname" type="text" class="form-control">
								</div>

								<label for="name" class="control-label col-lg-3">Nome *</label>

								<div class="col-lg-3"><input id="name" name="name" type="text" class="form-control">
								</div>

							</div>

							<div class="form-group">

								<label for="gender" class="control-label col-lg-3">Sesso *</label>

								<div class="col-lg-3">

									<label class="radio-inline">
												
													<input  type="radio"  name="gender" id="genderM" value="M">M
													
                                                </label>

								

									<label class="radio-inline">

                                                    <input  type="radio"  name="gender" id="genderF" value="F">F

                                                </label>

								

								</div>
								<label for="CF" class="control-label col-lg-3">Codice Fiscale *</label>

								<div class="col-lg-3"><input id="CF" name="CF" type="text" data-mask="wwww-wwww-wwww-wwww" class="form-control">
								</div>


							</div>


							<div class="form-group">

								<label for="birthCity" class="control-label col-lg-3">Comune di nascita *</label>

								<div class="col-lg-3"><input id="birthCity" name="birthCity" type="text" class="typeahead form-control">
								</div>

								<label for="birthDate" class="control-label col-lg-3">Data di nascita *</label>

								<div class="col-lg-3"><input id="birthDate" name="birthDate" type="text" class="form-control" placeholder="Inserisci  gg-mm-aaaa ">
								</div>

							</div>


							<div class="form-group">

								<label for="livingCity" class="control-label col-lg-3">Comune di residenza *</label>
								<div class="col-lg-3"><input id="livingCity" name="livingCity" type="text" class="typeahead form-control">
								</div>

								<label for="address" class="control-label col-lg-3">Via/Corso/Piazza *</label>

								<div class="col-lg-3"><input id="address" name="address" type="text" class="form-control">
								</div>

							</div>

							<div class="form-group">

								<label for="telephone" class="control-label col-lg-3">Recapito telefonico *</label>

								<div class="col-lg-3">

									<input id="telephone" name="telephone" type="tel" class="form-control">
						
								</div>



							</div>
							<div class="form-group dropup">

								<label for="bloodType" class="control-label col-lg-3">Gruppo sanguigno </label>

								<div class="col-lg-3">

									<button name="bloodTypeDrop" class="btn btn-default dropdown-toggle" type="button" id="bloodTypeDrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										<span class="caret"></span>
										</button>
								

									<ul id="dropupMenu" class="dropdown-menu" role="menu" aria-labelledby="bloodTypeDrop">
										<li role="presentation"><a id="0-" role="menuitem" tabindex="-1">0 negativo</a>
										</li>
										<li role="presentation"><a id="0+" role="menuitem" tabindex="-1">0 positivo</a>
										</li>
										<li role="presentation"><a id="A-" role="menuitem" tabindex="-1">A negativo</a>
										</li>
										<li role="presentation"><a id="A+" role="menuitem" tabindex="-1">A positivo</a>
										</li>
										<li role="presentation"><a id="B-" role="menuitem" tabindex="-1">B negativo</a>
										</li>
										<li role="presentation"><a id="B+" role="menuitem" tabindex="-1">B positivo</a>
										</li>
										<li role="presentation"><a id="AB-" role="menuitem" tabindex="-1">AB negativo</a>
										</li>
										<li role="presentation"><a id="AB+" role="menuitem" tabindex="-1">AB positivo</a>
										</li>
									</ul>

									<input id="bloodType" name="bloodType" class="form-control" value="-1">

								</div>


								<label for="maritalStatus" class="control-label col-lg-3">Stato Matrimoniale </label>

								<div class="col-lg-3">

									<select class="form-control" name="maritalStatus" id="maritalStatus">
										<option value="A">Annullato</option>
										<option value="D">Divorziato</option>
										<option value="I">Interlocutorio</option>
										<option value="L">Legalmente Separato</option>
										<option value="M">Sposato</option>
										<option value="P">Poligamo</option>
										<option value="S">Mai Sposato</option>
										<option value="T">Convivente</option>
										<option value="W">Vedovo</option>
									</select>
								</div>
							</div>
							<div class="form-group">

								<label for="shareData" class="control-label col-lg-3">Condividere i dati con i medici</label>

								<div class="col-lg-3">

									<label class="radio-inline">
												
													<input  type="radio"  name="shareData" id="shareY" value="Y">Si
													
                                                </label>

								

									<label class="radio-inline">

                                                    <input  type="radio"  name="shareData" id="shareN" value="N" checked>No

                                                </label>

								

								</div>


							</div>



							<div class="form-group">
								<div class="col-lg-4">
									</br>
									</br>
									</br>
									</br>
									</br>
									<label for="profilePic" class="control-label">Carica una immagine per il tuo profilo.(Opzionale)</label>
								</div>

								<div class="col-lg-4">
									</br>
									</br>

									<input id="profilePic" type="file" class="file" data-preview-file-type="text" accept="image/*" name="profilePic" value="null">
									<input id="profilePicHidden" name="profilePicHidden" class="form-control" value="null">

								</div>
							</div>
							<p class="pull-right">(*) Campi obbligatori</p>
							<button type="submit">Registrazione</button>
						</fieldset>



						<h3>Termini e condizioni</h3>

						<fieldset>

							<article>

								<center id="consensus">

								</center>

							</article>

							<div class="form-group">
								<div class="col-lg-4">
									<label for="acceptTerms">Accetto i termini e le condizioni.</label>
									<input id="acceptTerms" name="acceptTerms" type="checkbox">
								</div>
							</div>

						</fieldset>

					</form>

				</div>

			</div>

		</div>

	</section>
@endsection