@extends( 'auth.layouts.basic_registration' )
@extends( 'auth.layouts.registration_head' )

@section( 'pageTitle', 'Registrazione Care Provider' )
@section('register_content')
	
	<!--REGISTER SECTION-->

	<section id="register" class="register-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
						
					<center>
					<section id = "head">
						<img src = "/img/IconCareProvider.png" alt = "CPPicon"></img>  
					</section>	
                        <br>   
							<h1>Registrazione Care Provider</h1>
                    </center>
                        <br><br>           
                        {{ Form::open(array('url' => '/register/careprovider', 'class' => 'form-horizontal', 'method'=> 'Post')) }}
						{{ csrf_field() }}
                            <h3>Account</h3>
                            <fieldset>
									<!--username-->
                                    <div class="form-group">
                                        <label for="username" class="control-label col-lg-2">Username *</label>
                                        <div class="col-lg-3"><input id="username" name="username" type="text"  class="form-control">
                                        	@if ($errors->has('username'))
    											<div class="alert alert-danger" role="alert">{{ $errors->first('username') }}</div>
											@endif
										</div>
									</div>
                                   
									<!--e-mail-->
                                    <div class="form-group">
										<label for="email" class="control-label col-lg-2">Email-(PEC) *</label>
                                        <div class="col-lg-3"><input id="email" name="email" type="email" class="form-control">
                                        	@if ($errors->has('email'))
    											<div class="alert alert-danger" role="alert">{{ $errors->first('email') }}</div>
											@endif
										</div>
										<label for="confirmEmail" class="control-label col-lg-3">Conferma Email *</label>
                                        <div class="col-lg-3"><input id="confirmEmail" name="confirmEmail" type="email"  class="form-control">
                                        	@if ($errors->has('confirmEmail'))
    											<div class="alert alert-danger" role="alert">{{ $errors->first('confirmEmail') }}</div>
											@endif
										</div>
                                    </div>

                                    
									<!--password-->
                                    <div class="form-group">
										<label for="password" class="control-label col-lg-2">Password *</label>
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
									
									<!--ordine--da rendere obbligatori>-->
                                    <div class="form-group">
                                        <label for="numOrdine" class="control-label col-lg-2">Numero Iscrizione  *</label>
                                        <div class="col-lg-3"><input id="numOrdine" name="numOrdine" type="text" class="form-control" placeholder = "numero di iscrizione ordine">
                                        	@if ($errors->has('numOrdine'))
    											<div class="alert alert-danger" role="alert">{{ $errors->first('numOrdine') }}</div>
											@endif
										</div>
										 <label for="registrationCity" class="control-label col-lg-3">Localit&agrave Iscrizione *</label>
										<div class="col-lg-3">
											<input id="registrationCity" name="registrationCity" type="text" class="form-control" placeholder = "Localit&agrave ordine di iscrizione">
											@if ($errors->has('registrationCity'))
    											<div class="alert alert-danger" role="alert">{{ $errors->first('registrationCity') }}</div>
											@endif
										</div>
                                    </div>
										<br>
									
									<div class="form-group">
										<label for="tipoSpecializzazione" class="control-label col-lg-2">Attivit&agrave svolta *
										</label>
                                        <div class="col-lg-4">
                                       		<select name="tipoSpecializzazione" id="tipoSpecializzazione" class="form-control" >
                                                <option value="">Scegli la tua attivit&agrave </option>
											</select>
											@if ($errors->has('attivitaSvolta'))
    											<div class="alert alert-danger" role="alert">{{ $errors->first('attivitaSvolta') }}</div>
											@endif
										</div>
									</div>
									<br>
                         
                            							
								<div class="form-group" >
                                    <label for="surname" class="control-label col-lg-2">Cognome *</label>
                                    <div class="col-lg-3"><input  id="surname" name="surname" type="text"  class="form-control">
                                    	@if ($errors->has('surname'))
    										<div class="alert alert-danger" role="alert">{{ $errors->first('surname') }}</div>
										@endif
									</div>									
									<label for="name" class="control-label col-lg-3">Nome *</label>
                                    <div class="col-lg-3"><input  id="name" name="name" type="text"  class="form-control">
                                    	@if ($errors->has('name'))
    										<div class="alert alert-danger" role="alert">{{ $errors->first('name') }}</div>
										@endif
									</div>
								</div>
								
								<div class="form-group">
									<label for="gender" class="control-label col-lg-2">Sesso *</label>
									<div class="col-lg-3">
										<label class="radio-inline">
											<input  type="radio"  name="gender" id="genderM" value="male">M
										</label>
										<label class="radio-inline">
											<input  type="radio"  name="gender" id="genderF" value="female">F
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
									<label for="birthCity" class="control-label col-lg-2">Comune di nascita *</label>
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
									<label for="livingCity" class="control-label col-lg-2">Comune di residenza *</label>
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
                                    <label class="control-label col-lg-2">CAP</label>
                                    <div class="col-lg-3"><input id="capSedePF" name="capSedePF" type="text"  placeholder="CAP" class="form-control">
                                    	@if ($errors->has('cap'))
    										<div class="alert alert-danger" role="alert">{{ $errors->first('cap') }}</div>
										@endif
									</div>
									<label for="telephone" class="control-label col-lg-3">Recapito telefonico *</label>
									<div class="col-lg-3">
										<input id="telephone" name="telephone" type="tel" class="form-control">
										@if ($errors->has('telephone'))
	    									<div class="alert alert-danger" role="alert">{{ $errors->first('telephone') }}</div>
										@endif
									</div>
								</div>
								<br>
								<div class="form-group">
									<label class="control-label col-lg-2" >Altre informazioni
									</label>
									<textarea id="otherInfo" name="otherInfo"  cols="50" rows="4"  placeholder="Ulteriori informazioni relative alla propria attivit&agrave ">
									</textarea>
									@if ($errors->has('otherInfo'))
	    									<div class="alert alert-danger" role="alert">{{ $errors->first('otherInfo') }}</div>
									@endif
								</div>

							<!--	<div class="form-group">-->
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
									
								</fieldset>

                        
							<fieldset>
                            	<div class="form-group">
						<div class="col-lg-8 ">
							<input id="acceptInfo" name="acceptInfo" type="checkbox"> <label
								for="acceptInfoDoc">Ho letto <a
								href="/informative/Informativa.html">l'Informativa relativa al
									Trattamento dei Dati Personali*</a>.
							</label> @if ($errors->has('acceptTerms'))
							<div class="alert alert-danger" role="alert">
								{{$errors->first('acceptInfo') }}</div>
							@endif
						</div>
					</div>

					<p class="pull-right">(*) Campi obbligatori</p>
				</fieldset>
							</fieldset>
                        {{ Form::submit('Registrazione', array('class' => 'btn btn-large btn-primary center')) }}
						{{ Form::close() }}
                </div>
            </div>
        </div> <!--container outer-->
    </section>

    @foreach ($errors as $error)
    	<div class="alert alert-danger" role="alert">{{ $error}}</div>
	@endforeach
@endsection
