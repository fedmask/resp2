<!-- Datepicker CSS -->
<link href="/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

@if(Session::has('message'))
    <script>
        alert("{!! Session::get('message') !!}");
    </script>
@endif

<!-- REGISTER MODAL -->
<div class="col-lg-12">
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Registrati</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="well">
                                <center><img src="/img/IconPatient.png" class="img-responsive"/>
                                </center>
                                <center>
                                    <h3>Paziente</h3>
                                </center>
                                <center>
                                    <p>Privati cittadini</p>
                                </center>
                                <a href="#" data-toggle="modal" data-target="#registerPatient" data-dismiss="modal"
                                   class="btn btn-success btn-block">Registra un nuovo paziente</a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="well">
                                <center><img src="/img/IconCareProvider.png" class="img-responsive"/>
                                </center>
                                <center>
                                    <h3>CareProvider</h3>
                                </center>
                                <center>
                                    <p>Strutture e personale sanitario</p>
                                </center>
                                <a href="#" data-toggle="modal" data-target="#registerCPP" data-dismiss="modal" class="btn btn-info btn-block">Registra un nuovo
                                    careprovider</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div><!-- FINE REGISTER MODAL -->

<!-- REGISTER PATIENT MODAL -->
<div class="col-lg-12">
    <div class="modal fade" id="registerPatient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Registra paziente</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('route' => 'registerPatientAmm', 'class' => 'form-horizontal', 'method'=> 'Post')) }}
                    {{ csrf_field() }}
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
                            <div class="col-lg-3"><input id="confirmEmail" name="confirmEmail" type="email"
                                                         class="form-control">
                                @if ($errors->has('confirmEmail'))
                                    <div class="alert alert-danger"
                                         role="alert">{{ $errors->first('confirmEmail') }}</div>
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
                                    <input type="radio" name="gender" id="genderM" value="male">M
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="genderF" value="female">F
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
                            <div class="col-lg-3"><input id="birthCity" name="birthCity" type="text"
                                                         class="typeahead form-control">
                                @if ($errors->has('birthCity'))
                                    <div class="alert alert-danger" role="alert">{{ $errors->first('birthCity') }}</div>
                                @endif
                            </div>
                            <label for="birthDate" class="control-label col-lg-3">Data di nascita *</label>
                            <div class="col-lg-3"><input id="birthDate" name="birthDate" type="text"
                                                         class="form-control" placeholder="Inserisci  gg-mm-aaaa ">
                                @if ($errors->has('birthDate'))
                                    <div class="alert alert-danger" role="alert">{{ $errors->first('birthDate') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="livingCity" class="control-label col-lg-3">Comune di residenza *</label>
                            <div class="col-lg-3"><input id="livingCity" name="livingCity" type="text"
                                                         class="typeahead form-control">
                                @if ($errors->has('livingCity'))
                                    <div class="alert alert-danger"
                                         role="alert">{{ $errors->first('livingCity') }}</div>
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
                                {{Form::select('maritalStatus', ['M' => 'Sposato', 'A' => 'Annullato', 'D' => 'Divorziato', 'I' => 'Interlocutorio', 'L' => 'Legalmente Separato', 'P' => 'Poligamo', 'S' => 'Mai Sposato', 'T' => 'Convivente', 'W' => 'Vedovo',], '0', ['class' => 'form-control'])}}
                                @if ($errors->has('maritalStatus'))
                                    <div class="alert alert-danger"
                                         role="alert">{{ $errors->first('maritalStatus') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="shareData" class="control-label col-lg-3">Condividere i dati con i
                                medici</label>
                            <div class="col-lg-3">
                                <label class="radio-inline">
                                    <input type="radio" name="shareData" id="shareY" value="Y">Si
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="shareData" id="shareN" value="N" checked>No
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-5">
                                </br>
                                </br>
                                </br>
                                <label for="profilePic" class="control-label">Carica una immagine per il tuo profilo.
                                    (OP)</label>
                            </div>

                            <div class="col-lg-4">
                                </br>
                                </br>
                                <input id="profilePic" type="file" class="file" data-preview-file-type="text"
                                       accept="image/*" name="profilePic" value="null">
                                <input id="profilePicHidden" name="profilePicHidden" class="form-control" value="null">
                            </div>
                        </div>
                        <p class="pull-right">(*) Campi obbligatori</p>
                    </fieldset>
                    </br>
                    </br>
                    <div class="row">
                        <div class="col-lg-8"></div>
                        <div class="col-lg-4">
                            <button type="button" data-dismiss="modal" class="btn btn-default" >Annulla</button>
                            {{ Form::submit('Registrazione', array('class' => 'btn btn-primary center')) }}
                        </div>

                    </div>

                    {{ Form::close() }}



                </div>
            </div>
        </div>
    </div>
</div>
<!-- FINE REGISTER PATIENT MODAL -->

<!-- REGISTER CAREPROVIDER MODAL -->
<div class="col-lg-12">
    <div class="modal fade" id="registerCPP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Registra careprovider</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('route' => 'registerCppAmm', 'class' => 'form-horizontal', 'method'=> 'Post')) }}
                    {{ csrf_field() }}
                    <fieldset>
                        <!--username-->
                        <div class="form-group">
                            <label for="username" class="control-label col-lg-2">Username *</label>
                            <div class="col-lg-3"><input id="username" name="username" type="text" class="form-control" required>
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
                            <div class="col-lg-3"><input id="confirmEmail" name="confirmEmail" type="email"
                                                         class="form-control">
                                @if ($errors->has('confirmEmail'))
                                    <div class="alert alert-danger"
                                         role="alert">{{ $errors->first('confirmEmail') }}</div>
                                @endif
                            </div>
                        </div>

                        <!--ordine--da rendere obbligatori>-->
                        <div class="form-group">
                            <label for="numOrdine" class="control-label col-lg-2">N° iscrizione *</label>
                            <div class="col-lg-3"><input id="numOrdine" name="numOrdine" type="text"
                                                         class="form-control" placeholder="numero di iscrizione ordine">
                                @if ($errors->has('numOrdine'))
                                    <div class="alert alert-danger" role="alert">{{ $errors->first('numOrdine') }}</div>
                                @endif
                            </div>
                            <label for="registrationCity" class="control-label col-lg-3">Località Iscrizione *</label>
                            <div class="col-lg-3">
                                <input id="registrationCity" name="registrationCity" type="text" class="form-control"
                                       placeholder="Località ordine di iscrizione">
                                @if ($errors->has('registrationCity'))
                                    <div class="alert alert-danger"
                                         role="alert">{{ $errors->first('registrationCity') }}</div>
                                @endif
                            </div>
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="tipoSpecializzazione" class="control-label col-lg-2">Attivit&agrave svolta *
                            </label>
                            <div class="col-lg-4">
                                <select name="tipoSpecializzazione" id="tipoSpecializzazione" class="form-control">
                                    <option value=""></option>
                                    <option value="aud">Audiometrista</option>
                                    <option value="emg">Operatore Emergenza</option>
                                    <option value="far">Farmacista</option>
                                    <option value="fst">Fisioterapista</option>
                                    <option value="igd">Igenista dentale</option>
                                    <option value="inf">Infermiere</option>
                                    <option value="lgp">Logopedista</option>
                                    <option value="mcs">Medico Continuità Assistenziale</option>
                                    <option value="mmg">Medico di medicina generale</option>
                                    <option value="mos">Medico Ospedaliero</option>
                                    <option value="mps">Medico di Pronto Soccorso</option>
                                    <option value="msa">Medico Specialista Ambulatoriale</option>
                                    <option value="mso">Medico Specialista Ospedaliero</option>
                                    <option value="odt">Odontoiatra</option>
                                    <option value="otc">Ottico</option>
                                    <option value="oth">Altro</option>
                                    <option value="pls">Pediatra di libera scelta</option>
                                    <option value="psi">Psicologo</option>
                                    <option value="tps">Tecnico psicologo</option>
                                </select>
                                @if ($errors->has('attivitaSvolta'))
                                    <div class="alert alert-danger"
                                         role="alert">{{ $errors->first('attivitaSvolta') }}</div>
                                @endif
                            </div>
                        </div>
                        <br>


                        <div class="form-group">
                            <label for="surname" class="control-label col-lg-2">Cognome *</label>
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
                            <label for="gender" class="control-label col-lg-2">Sesso *</label>
                            <div class="col-lg-3">
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="genderM" value="male">M
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="genderF" value="female">F
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
                            <div class="col-lg-3"><input id="birthCity" name="birthCity" type="text"
                                                         class="typeahead form-control">
                                @if ($errors->has('birthCity'))
                                    <div class="alert alert-danger" role="alert">{{ $errors->first('birthCity') }}</div>
                                @endif
                            </div>
                            <label for="birthDate" class="control-label col-lg-3">Data di nascita *</label>
                            <div class="col-lg-3"><input id="birthDate" name="birthDate" type="text"
                                                         class="form-control" placeholder="Inserisci  gg-mm-aaaa ">
                                @if ($errors->has('birthDate'))
                                    <div class="alert alert-danger" role="alert">{{ $errors->first('birthDate') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="livingCity" class="control-label col-lg-2">Comune di residenza *</label>
                            <div class="col-lg-3"><input id="livingCity" name="livingCity" type="text"
                                                         class="typeahead form-control">
                                @if ($errors->has('livingCity'))
                                    <div class="alert alert-danger"
                                         role="alert">{{ $errors->first('livingCity') }}</div>
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
                            <div class="col-lg-3"><input id="capSedePF" name="capSedePF" type="text" placeholder="CAP"
                                                         class="form-control">
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
                            <label class="control-label col-lg-2">Altre informazioni
                            </label>
                            <textarea id="otherInfo" name="otherInfo" cols="50" rows="4"
                                      placeholder="Ulteriori informazioni relative alla propria attivit&agrave ">
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
                                <label for="profilePic" class="control-label">Carica una immagine per il tuo
                                    profilo.(Opzionale)</label>
                            </div>

                            <div class="col-lg-4">
                                </br>
                                </br>
                                <input id="profilePic" type="file" class="file" data-preview-file-type="text"
                                       accept="image/*" name="profilePic" value="null">
                                <input id="profilePicHidden" name="profilePicHidden" class="form-control" value="null">
                            </div>
                        </div>

                    </fieldset>
                    <p class="pull-right">(*) Campi obbligatori</p>
                    </fieldset>
                    </br>
                    </br>
                    </br>
                    <div class="row">
                        <div class="col-lg-8"></div>
                        <div class="col-lg-4">
                            <button type="button" data-dismiss="modal" class="btn btn-default">Annulla</button>
                            {{ Form::submit('Registrazione', array('class' => 'btn btn-primary center')) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div><!-- FINE REGISTER CAREPROVIDER MODAL -->