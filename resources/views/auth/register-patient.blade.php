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
					{{ Form::open(array('url' => '/register/patient', 'class' => 'form-horizontal')) }}
					{{ csrf_field() }}
						<h3>Account</h3>
						<fieldset>
							<div class="form-group">
								<label for="userName" class="control-label col-lg-3">Username *</label>
								<div class="col-lg-3"><input id="userName" name="username" type="text" class="form-control">
									@if ($errors->has('username'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('username') }}</div>
									@endif
								</div>
							</div>

							<div class="form-group">
								<label for="email" class="control-label col-lg-3">Email *</label>
								<div class="col-lg-3"><input id="email" name="email" type="email" class="form-control">
									@if ($errors->has('email'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('email') }}</div>
									@endif
								</div>
								<label for="confirmEmail" class="control-label col-lg-3">Conferma Email *</label>
								<div class="col-lg-3"><input id="confirmEmail" name="confirmEmail" type="email" class="form-control">
									@if ($errors->has('confirmEmail'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('confirmEmail') }}</div>
									@endif
								</div>
							</div>

							<div class="form-group">
								<label for="password" class="control-label col-lg-3">Password *</label>
								<div class="col-lg-3"><input id="password" name="password" type="password" class="form-control" placeholder="almeno 8 caratteri tra cui una cifra">
									@if ($errors->has('password'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('password') }}</div>
									@endif
								</div>
								<label for="confirmPassword" class="control-label col-lg-3">Conferma Password *</label>
								<div class="col-lg-3">
									<input id="confirmPassword" name="confirmPassword" type="password" class="form-control">
									@if ($errors->has('confirmPassword'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('confirmPassword') }}</div>
									@endif
								</div>
							</div>

							<div class="form-group">
								<label for="surname" class="control-label col-lg-3">Cognome *</label>
								<div class="col-lg-3"><input id="surname" name="surname" type="text" class="form-control">
									@if ($errors->has('surname'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('surname') }}</div>
									@endif
								</div>
								<label for="name" class="control-label col-lg-3">Nome *</label>
								<div class="col-lg-3"><input id="name" name="name" type="text" class="form-control">
									@if ($errors->has('name'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('name') }}</div>
									@endif
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
                                    @if ($errors->has('gender'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('gender') }}</div>
									@endif
								</div>
								<label for="CF" class="control-label col-lg-3">Codice Fiscale *</label>
								<div class="col-lg-3"><input id="CF" name="CF" type="text" class="form-control">
									@if ($errors->has('CF'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('CF') }}</div>
									@endif
								</div>
							</div>

							<div class="form-group">
								<label for="birthCity" class="control-label col-lg-3">Comune di nascita *</label>
								<div class="col-lg-3"><input id="birthCity" name="birthCity" type="text" class="typeahead form-control">
									@if ($errors->has('birthCity'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('birthCity') }}</div>
									@endif
								</div>
								<label for="birthDate" class="control-label col-lg-3">Data di nascita *</label>
								<div class="col-lg-3"><input id="birthDate" name="birthDate" type="text" class="form-control" placeholder="Inserisci  gg-mm-aaaa ">
									@if ($errors->has('birthDate'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('birthDate') }}</div>
									@endif
								</div>
							</div>

							<div class="form-group">
								<label for="livingCity" class="control-label col-lg-3">Comune di residenza *</label>
								<div class="col-lg-3"><input id="livingCity" name="livingCity" type="text" class="typeahead form-control">
									@if ($errors->has('livingCity'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('livingCity') }}</div>
									@endif
								</div>
								<label for="address" class="control-label col-lg-3">Via/Corso/Piazza *</label>
								<div class="col-lg-3"><input id="address" name="address" type="text" class="form-control">
									@if ($errors->has('address'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('address') }}</div>
									@endif
								</div>
							</div>

							<div class="form-group">
								<label for="telephone" class="control-label col-lg-3">Recapito telefonico *</label>
								<div class="col-lg-3">
									<input id="telephone" name="telephone" type="tel" class="form-control">
									@if ($errors->has('telephone'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('telephone') }}</div>
									@endif
								</div>
							</div>

							<div class="form-group dropup">
								<label for="bloodType" class="control-label col-lg-3">Gruppo sanguigno </label>
								<div class="col-lg-3">
										{{Form::select('bloodType', ['0' => '0 negativo', '1' => '0 positivo', '2' => 'A negativo', '3' => 'A positivo', '4' => 'B negativo', '5' => 'B positivo', '6' => 'AB negativo', '7' => 'AB positivo',], '0', ['class' => 'form-control'])}}
									@if ($errors->has('bloodType'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('bloodType') }}</div>
									@endif
								</div>

								<label for="maritalStatus" class="control-label col-lg-3">Stato Matrimoniale </label>
								<div class="col-lg-3">
									<select class="form-control" name="maritalStatus" id="maritalStatus">
										<option value="0">Sposato</option>
										<option value="1">Annullato</option>
										<option value="2">Divorziato</option>
										<option value="3">Interlocutorio</option>
										<option value="4">Legalmente Separato</option>
										<option value="5">Poligamo</option>
										<option value="6">Mai Sposato</option>
										<option value="7">Convivente</option>
										<option value="8">Vedovo</option>
									</select>
									@if ($errors->has('maritalStatus'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('maritalStatus') }}</div>
									@endif
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
						</fieldset>

						<h3>Termini e condizioni</h3>
						<fieldset>
							<article>
								<center id="consensus"></center>
							</article>

							<div class="form-group">
								<div class="col-lg-4">
									<label for="acceptTerms">Accetto i termini e le condizioni.</label>
									<input id="acceptTerms" name="acceptTerms" type="checkbox">
									@if ($errors->has('acceptTerms'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('acceptTerms') }}</div>
									@endif
								</div>
							</div>
						</fieldset>
						{{ Form::submit('Registrazione', array('class' => 'btn btn-large btn-primary center')) }}
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</section>
@endsection