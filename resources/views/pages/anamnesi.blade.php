@extends( 'layouts.app' )
@extends( 'includes.template_head' )
@section( 'pageTitle', 'Anamnesi' )
@section( 'content' )

    <div id="content">
        <div class="inner">
            <div class="row">
                <div class="col-lg-9">
                    <h2> Anamnesi </h2>
                </div>

            </div><!--row-->
            <hr/>
            <!-- script per la manipolazione delle anamnesi familiari-->

            <script src="{{url('https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js')}}"></script>
            <script src="{{asset('js/formscripts/jquery.js')}}"></script>
            <script src="{{asset('js/formscripts/jquery-ui.js')}}"></script>
            <script type="text/javascript" src="{{ url('/js/formscripts/anamnesi.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/formscripts/modanamfam.js') }}"></script>

            <div class="row">

                <!-- TABELLA RELATIVA ALL'ANAMNESI FAMILIARE-->
                <form action="{{ action('AnamnesiController@store') }}" method="post" class="form-horizontal">
                    {{csrf_field()}}
                    <div class="col-md-6">
                        <div class="panel panel-success">

                            <div class="panel-heading">
                                <center><h4>Familiare </h4></center>
                                <!--bottoni per la gestione delle modifiche-->

                                <div class="btn-group" style="text-align: left;">
                                    <a id="buttonUpdateFam" class="btn btn-success btn-sm btn-line"><i
                                                class="icon-pencil icon-white"></i>Aggiorna</a>

                                    <button type="submit" class="btn btn-warning btn-sm" id="btn_salvafam"
                                       style="display: none;"><i
                                                class="icon-save"></i>Salva</button>
                                    <a type="submit" class="btn btn-info btn-sm" id="buttonCodiciFam"
                                       style="display: none;"
                                       data-toggle="modal" data-target="#table_update_anamnesifam"><i
                                                class="icon-flag"></i>
                                        Codici</a>
                                    <a class="btn btn-danger btn-sm" id="buttonAnnullaFam" style="display: none;"><i
                                                class="icon-trash"></i> Annulla</a>

                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>

                                    <textarea class="col-md-12" id="testofam" name="testofam" cols="44" rows="10"
                                              readonly="true"
                                              style="resize:none; border: transparent; overflow-y: scroll; max-height: 200px;"
                                              placeholder="qui puoi inserire il tuo testo...">
                                        @foreach ($anamnesiFamiliare as $a)
                                            {{ $a->anamnesi_contenuto }}
                                        @endforeach

                                    </textarea>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!--bottone che permette le modifiche ANAMNESI FAMILIARE-->
                            <div class="panel-footer" style="text-align:right;">
                            </div>
                        </div>
                    </div>
                </form><!--CHIUSURA ANAMNESI FAMILIARE-->


                <!-- TABELLA RELATIVA ALL'ANAMNESI FISIOLOGICA -->
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <center><h4>Fisiologica</h4></center>
                            <div class="btn-group" style="text-align: right;">
                                <button id="btnfisio" class="btn btn-primary btn-sm btn-line" data-toggle="modal"
                                        data-target="#modanamnesifis"><i class="icon-pencil icon-white"></i> Aggiorna
                                </button>
                                <button class="btn btn-success btn-sm" style="visibility: hidden;"></i>Salva</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr></tr>
                                    </thead>


                                    <tbody>
                                    <tr>
                                           <textarea class="col-md-12" id="testofis" name="testofis" cols="44" rows="10"
                                                     readonly="true"
                                                     style="resize:none; border: transparent; overflow-y: scroll; max-height: 200px;"></textarea>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--bottone che fa comparire un menu con tutte le voci della FISIOLOGICA-->

                        <div class="panel-footer" style="text-align:right">
                        </div>
                    </div><!--row familiare e fisiologica-->

                </div><!--inner-->
            </div><!--content-->
            <div class="row">

                <!-- TABELLA RELATIVA ALL'ANAMNESI PATOLOGICA REMOTA-->
                <div class="col-md-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <center><h4>Patologica remota</h4></center>
                            <div class="btn-group" style="text-align: left;">
                                <!--bottoni per la gestione delle modifiche-->
                                <a type="submit" class="btn btn-success btn-sm" id="btn_salvapatrem"
                                   style="display: none;"><i
                                            class="icon-save"></i>Salva</a>
                                <a class="btn btn-danger btn-sm" id="btn_annullapatrem" style="display: none;"><i
                                            class="icon-trash"></i> Annulla</a>
                                <a id="buttonHiddenPatRem" class="btn btn-warning btn-sm btn-line"><i
                                            class="icon-pencil icon-white"></i>Aggiorna</a>
                            </div>

                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                    <textarea class="col-md-12" id="testopat" name="testopat" cols="44" rows="10"
                                              readonly="true"
                                              style="resize:none; border: transparent; overflow-y: scroll; max-height: 200px;">
                                    </textarea>
                                    </tr>
                                    <!--	<br />-->
                                    <hr/>
                                    <tr>
                                        <strong>Patologie remote raggruppate per Categorie Diagnostiche (MDC):</strong>
                                    </tr>
                                    <hr/>
                                    <tr>
                                        <a id="btnmodrem" class="text-left;" style="cursor: pointer; display: none;"
                                           data-toggle="modal" data-target="#modanamnesipat">Modifica patologie
                                            pregresse</a>
                                    </tr>
                                    <tr>
												<textarea onclick="textAreaAdjust(this)" class="col-md-12"
                                                          id="testopatmod" name="testopatmod" cols="44" rows="5"
                                                          readonly="readonly"
                                                          style="resize:none; border: transparent; overflow-y: scroll; font-size: small; height: 20%;"></textarea>
                                    </tr>
                                    <!-- <hr />-->

                                    <div class="panel-body;" style="text-align:left">
                                        <!--<a id="btnmodrem" class="text-left;" style="cursor: pointer; display: none;" data-toggle="modal" data-target="#modanamnesipat">Modifica patologie pregresse</a>-->
                                    </div>


                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="panel-footer" style="text-align:right">
                        </div>
                    </div><!--panel warning-->
                </div><!--col-md-6-->

                <!-- TABELLA RELATIVA ALL'ANAMNESI PATOLOGICA PROSSIMA-->
                <div class="col-md-6">
                    <!--	<div class="panel panel-primary">-->
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <center><h4>Patologica prossima</h4></center>
                            <!--<div class="btn-group pull-right" style="text-align: left;">-->
                            <!--bottoni per la gestione delle modifiche-->
                            <div class="btn-group" style="text-align: left;">
                                <a id="buttonHiddenpp" class="btn btn-danger btn-sm btn-line pull-right"><i
                                            class="icon-pencil icon-white"></i>Aggiorna</a>
                                <button class="btn btn-info btn-sm pull-left" id="btnsposta" data-toggle="modal"
                                        data-target="#modansposta" onclick="InserisciTesto()"><i
                                            class="icon-hand-left"></i>
                                    Sposta
                                </button>

                                <a type="submit" class="btn btn-success btn-sm" id="btn_salvapp" style="display: none;"><i
                                            class="icon-save"></i>Salva</a>
                                <a class="btn btn-warning btn-sm" id="btn_annullapp" style="display: none;"><i
                                            class="icon-trash"></i> Annulla</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr></tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                           <textarea class="col-md-12" id="testopatpp" name="testopatpp" cols="44"
                                                     rows="10" readonly="true"
                                                     style="resize:none; border: transparent; overflow-y: scroll; max-height: 200px;"></textarea>
                                    </tr>
                                    <!-- <br />-->
                                    <hr/>


                                    <tr>
                                        <strong>Patologie prossime raggruppate per Categorie Diagnostiche
                                            (MDC):</strong>
                                    </tr>
                                    <hr/>
                                    <tr>
                                        <a id="modbtnpp" class="text-left;" style="cursor: pointer; display: none;"
                                           data-toggle="modal" data-target="#modanamnesipatrec">Modifica patologie
                                            recenti</a>
                                    </tr>

                                    <tr>
                                           <textarea onclick="textAreaAdjust(this)" class="col-md-12"
                                                     id="testopatmodrec" name="testopatmodrec" cols="44" rows="5"
                                                     readonly="readonly"
                                                     style="resize:none; border: transparent; overflow-y: scroll; font-size: small; height: 20%;">

                                           </textarea>
                                    </tr>
                                    <!--<hr />-->
                                    <div class="panel-body;" style="text-align:left">
                                        <!--<a id="modbtnpp" class="text-left;" style="cursor: pointer; display: none;" data-toggle="modal" data-target="#modanamnesipatrec">Modifica patologie recenti</a>-->
                                    </div>


                                    </tbody>
                                </table>
                            </div>
                        </div> <!--panel-body-->
                        <!--bottone che apre il pannello per le modifiche informazioni ANAMNESI PATOLOGICA REMOTA-->


                        <div class="panel-footer clearfix">


                        </div>
                    </div> <!--panel danger-->
                </div><!--col-md-6 patologica prossima-->

            </div> <!--row-prossima e remota--->

            <!-- MODAL PER LE ANAMNESI-->

            <!--ANAMNESI FAMILIARE-->


            <!-- MODAL per l'inserimento di una anamnesi familiare -->

            <div class="modal fade" id="table_add_anamnesifam" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                    id="chiudianamnesifam">&times;
                            </button>
                            <h4 class="modal-title" id="H2">Aggiungi anamnesi familiare FHIR</h4>
                        </div>

                        <br>

                        <form id="formA" action="#" method="POST" class="form-horizontal">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Nome componente:</label>
                                    <div class="col-lg-6">
                                        <input id="nome_componenteA" type="text" class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Grado parentela:</label>
                                    <div class="col-lg-6">
                                        <select id="gradoParentela" class="form-control">
                                            <option value="fratello">Fratello</option>
                                            <option value="genitore">Genitore</option>
                                            <option value="nonno">Nonno/a</option>
                                            <option value="zio">Zio/a</option>
                                            <option value="nipote">Nipote</option>
                                            <option value="cugino">Cugino/a</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Sesso:</label>
                                    <div class="col-lg-6">
                                        <select id="sessoA" class="form-control">
                                            <option selected value="M">Uomo</option>
                                            <option value="F">Donna</option>
                                            <option value="O">Altro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Anni:</label>
                                    <div class="col-lg-6">
                                        <input id="anni_componenteA" type="text" class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Data decesso:</label>
                                    <div class="col-lg-6">
                                        <input type="date" name="data_morteA" id="data_morteA"
                                               class="form-control col-lg-6"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Annotazioni
                                        :</label>
                                    <div class="col-lg-6">
                                <textarea id="annotazioniA" type="text" class="form-control">
								</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="btn" class="btn btn-default" data-dismiss="modal">Annulla</button>
                            <button class="btn btn-primary" id="concludiA">Aggiungi</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- chiusura modal per l'aggiunta della nuova anamnesi -->

            <!-- modal per l'aggiornamento delle anamnesi familiari -->
            <div class="modal fade" id="table_update_anamnesifam" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                    id="chiudianamnesifam">&times;
                            </button>
                            <h4 class="modal-title" id="H2">Aggiorna anamnesi familiare FHIR</h4>
                        </div>
                        <br>


                        <!-- tabella per la visualizzazione delle anamnesi familiari -->


                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table" id="tableAnamnesiFam">
                                    <thead>
                                    <tr>
                                        <th>
                                            Componente
                                            <button id="buttonAdd" class="btn btn-default btn-success"
                                                    data-toggle="modal"
                                                    data-target="#table_add_anamnesifam" data-dismiss="modal"><i
                                                        class="icon-plus"></i></button>
                                        </th>
                                        <th>Sesso</th>
                                        <th>Anni</th>
                                        <th>Annotazioni</th>
                                        <th>Opzioni</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div><!--table responsive-->


                        </div><!--PANEL BODY -->
                    </div>
                </div>
            </div>

            <!-- chiusura modal per l'aggiornamento delle anamnesi familiari -->


            <!-- MODAL MODIFICA ANAMNESI FISIOLOGICA -->
            <div class="col-lg-12">
                <div class="modal fade" id="modanamnesifis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica informazioni</h4>
                            </div>
                            <form class="form-horizontal" id="modpatinfo">
                                <div class="modal-body">
                                    <div class="table-responsive">

                                        <div class="table-bordered">


                                            <div class="accordion ac" id="accordionUtility">
                                                <div class="accordion-group">
                                                    <div class="accordion-heading centered">
                                                        <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-lg-3">

                                                                    <a id="inf" class="accordion-toggle"
                                                                       data-toggle="collapse" href="#infanzia">
                                                                        <h5><i class="icon-pencil icon-white"></i>Infanzia
                                                                        </h5>
                                                                    </a>
                                                                </div>

                                                                <div class="col-lg-3">
                                                                    <a id="inf2" class="accordion-toggle"
                                                                       data-toggle="collapse" data-parent="#accordion"
                                                                       href="#scolaro">
                                                                        <h5><i class="icon-pencil icon-white"></i>Scolarit&#224;
                                                                        </h5>
                                                                    </a>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <a id="inf3" class="accordion-toggle"
                                                                       data-toggle="collapse"
                                                                       data-parent="#accordionUtility"
                                                                       href="#stilevita">
                                                                        <h5><i class="icon-pencil icon-white"></i>Stile
                                                                            di
                                                                            vita</h5>
                                                                    </a>
                                                                </div>

                                                                <div class="col-lg-3">
                                                                    <a id="inf4" class="accordion-toggle"
                                                                       data-toggle="collapse"
                                                                       data-parent="#accordionUtility"
                                                                       href="#gravidanze">
                                                                        <h5><i class="icon-pencil icon-white"></i>Gravidanze
                                                                        </h5>
                                                                    </a>
                                                                </div>

                                                            </div>

                                                            <!-- INFANZIA ---------------------->
                                                            <div id="infanzia" class="accordion-body collapse">

                                                                <div class="accordion-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="box dark">
                                                                                <header>
                                                                                    <h5>Infanzia</h5>
                                                                                    <div class="toolbar">
                                                                                        <ul class="nav">
                                                                                            <li><input type="button"
                                                                                                       value="Salva"
                                                                                                       id="prova"
                                                                                                       class="btn btn-success btn-sm"/>
                                                                                            </li>
                                                                                            <li><input type="button"
                                                                                                       value="Annulla"
                                                                                                       id="btnannullainfanzia"
                                                                                                       class="btn btn-danger btn-sm"/>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </header>
                                                                                <div class="accordion-body">
                                                                                    <br/>
                                                                                    <form class="form-horizontal"
                                                                                          id="form_infanzia">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-3"
                                                                                                   for="parto">Nato da
                                                                                                parto:</label>
                                                                                            <div class="col-lg-4">
                                                                                                <select class="form-control"
                                                                                                        name="parto"
                                                                                                        id="parto">
                                                                                                    <option></option>
                                                                                                    <option id="pretermine">
                                                                                                        pretermine
                                                                                                    </option>
                                                                                                    <option id="termine">
                                                                                                        termine
                                                                                                    </option>
                                                                                                    <option id="post-termine">
                                                                                                        post-termine
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-lg-5">
                                                                                                <select class="form-control"
                                                                                                        name="tipoparto"
                                                                                                        id="tipoparto">
                                                                                                    <option></option>
                                                                                                    <option id="eutocico">
                                                                                                        naturale
                                                                                                        eutocico
                                                                                                    </option>
                                                                                                    <option id="distocico">
                                                                                                        naturale
                                                                                                        distocito
                                                                                                    </option>
                                                                                                    <option id="cesareo">
                                                                                                        operatorio
                                                                                                        cesareo
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4"
                                                                                                   for="allattamento">Allattamento:</label>
                                                                                            <div class="col-lg-8">
                                                                                                <select class="form-control"
                                                                                                        name="allattamento"
                                                                                                        id="allattamento">
                                                                                                    <option></option>
                                                                                                    <option id="materno">
                                                                                                        materno
                                                                                                    </option>
                                                                                                    <option id="artificiale">
                                                                                                        artificiale
                                                                                                    </option>
                                                                                                    <option id="mercenario">
                                                                                                        mercenario
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4"
                                                                                                   for="sviluppoVegRel">Sviluppo
                                                                                                vegetativo e
                                                                                                relazionale:</label>
                                                                                            <div class="col-lg-8">
                                                                                                <select class="form-control"
                                                                                                        name="sviluppoVegRel"
                                                                                                        id="sviluppoVegRel">
                                                                                                    <option></option>
                                                                                                    <option id="normale">
                                                                                                        normale
                                                                                                    </option>
                                                                                                    <option id="patologico">
                                                                                                        patologico
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="noteinfanzia"
                                                                                                   class="control-label col-lg-4">Note
                                                                                                infanzia:</label>
                                                                                            <div class="col-lg-8">
                                                                                            <textarea id="noteinfanzia"
                                                                                                      name="noteinfanzia"
                                                                                                      class="form-control"></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!-- CHIUSURA INFANZIA ---------------------->


                                                            <!-- SCOLARITA' ---------------------->
                                                            <div id="scolaro" class="accordion-body collapse">
                                                                <div class="accordion-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="box dark">
                                                                                <header><h5>Scolarit&#224;</h5>
                                                                                    <div class="toolbar">
                                                                                        <ul class="nav">
                                                                                            <li><input type="button"
                                                                                                       value="Salva"
                                                                                                       id="btnsalvascolarita"
                                                                                                       class="btn btn-success btn-sm"/>
                                                                                            </li>
                                                                                            <li><input type="button"
                                                                                                       value="Annulla"
                                                                                                       id="btnannullascolarita"
                                                                                                       class="btn btn-danger btn-sm"/>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </header>
                                                                                <div class="accordion-body">
                                                                                    <br/>
                                                                                    <form class="form-horizontal"
                                                                                          id="formscolaro">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4"
                                                                                                   for="livelloScol">Livello
                                                                                                scolastico:</label>
                                                                                            <div class="col-lg-8">

                                                                                                <select class="form-control"
                                                                                                        name="livelloScol"
                                                                                                        id="livelloScol">
                                                                                                    <option></option>
                                                                                                    <option id="analfabeta">
                                                                                                        analfabeta
                                                                                                    </option>
                                                                                                    <option id="elementare">
                                                                                                        elementare
                                                                                                    </option>
                                                                                                    <option id="medie-inferiori">
                                                                                                        medie-inferiori
                                                                                                    </option>
                                                                                                    <option id="diploma">
                                                                                                        diploma
                                                                                                    </option>
                                                                                                    <option id="laurea">
                                                                                                        laurea
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!--CHIUSURA SCOLARITA'-->

                                                            <!-- STILE DI VITA ---------------------->
                                                            <div id="stilevita" class="accordion-body collapse">
                                                                <div class="accordion-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="box dark">
                                                                                <header><h5>Stile di vita</h5>
                                                                                    <div class="toolbar">
                                                                                        <ul class="nav">
                                                                                            <li><input type="button"
                                                                                                       value="Salva"
                                                                                                       id="btnsalvavita"
                                                                                                       class="btn btn-success btn-sm"/>
                                                                                            </li>
                                                                                            <li><input type="button"
                                                                                                       value="Annulla"
                                                                                                       id="btnannullavita"
                                                                                                       class="btn btn-danger btn-sm"/>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </header>
                                                                                <div class="accordion-body">
                                                                                    <br/>
                                                                                    <form class="form-horizontal"
                                                                                          id="formscolaro">
                                                                                        <div class="form-group">
                                                                                            <label for="attivitaFisica"
                                                                                                   class="control-label col-lg-4">Attivit&#224;
                                                                                                fisica:</label>
                                                                                            <div class="col-lg-8">
                                                                                            <textarea
                                                                                                    id="attivitaFisica"
                                                                                                    name="attivitaFisica"
                                                                                                    class="form-control"></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="abitudAlim"
                                                                                                   class="control-label col-lg-4">Abitudini
                                                                                                alimentari:</label>
                                                                                            <div class="col-lg-8">
                                                                                            <textarea id="abitudAlim"
                                                                                                      name="abitudAlim"
                                                                                                      class="form-control"></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="ritmoSV"
                                                                                                   class="control-label col-lg-4">Ritmo
                                                                                                sonno veglia:</label>
                                                                                            <div class="col-lg-8">
                                                                                            <textarea id="ritmoSV"
                                                                                                      name="ritmoSV"
                                                                                                      class="form-control"></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="autosize"
                                                                                                   class="control-label col-lg-3">Fumo:</label>
                                                                                            <div class="col-lg-3">
                                                                                                <select class="form-control"
                                                                                                        name="fumo"
                                                                                                        id="fumo">
                                                                                                    <option></option>
                                                                                                    <option id="nofumo">
                                                                                                        no
                                                                                                    </option>
                                                                                                    <option id="sifumo">
                                                                                                        si
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-lg-6">
                                                                                                <input type="text"
                                                                                                       name="freqFumo"
                                                                                                       id="freqFumo"
                                                                                                       class="form-control col-lg-6"
                                                                                                       placeholder="Quantit&#224;/Frequenza sigarette"
                                                                                                       value=""/>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="autosize"
                                                                                                   class="control-label col-lg-3">Alcool:</label>
                                                                                            <div class="col-lg-3">
                                                                                                <select class="form-control"
                                                                                                        name="alcool"
                                                                                                        id="alcool">
                                                                                                    <option></option>
                                                                                                    <option id="noalcool">
                                                                                                        no
                                                                                                    </option>
                                                                                                    <option id="sialcool">
                                                                                                        si
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-lg-6">
                                                                                                <input type="text"
                                                                                                       name="freqAlcool"
                                                                                                       id="freqAlcool"
                                                                                                       class="form-control col-lg-6"
                                                                                                       placeholder="Quantit&#224;/Frequenza alcolici"
                                                                                                       value=""/>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="autosize"
                                                                                                   class="control-label col-lg-3">Droghe:</label>
                                                                                            <div class="col-lg-3">
                                                                                                <select class="form-control"
                                                                                                        name="droghe"
                                                                                                        id="droghe">
                                                                                                    <option></option>
                                                                                                    <option id="nodroghe">
                                                                                                        no
                                                                                                    </option>
                                                                                                    <option id="sidroghe">
                                                                                                        si
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-lg-6">
                                                                                                <input type="text"
                                                                                                       name="freqDroghe"
                                                                                                       id="freqDroghe"
                                                                                                       class="form-control col-lg-6"
                                                                                                       placeholder="Quantit&#224;/Frequenza droghe"
                                                                                                       value=""/>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="noteStileVita"
                                                                                                   class="control-label col-lg-4">Note:</label>
                                                                                            <div class="col-lg-8">
                                                                                            <textarea id="noteStileVita"
                                                                                                      name="noteStileVita"
                                                                                                      class="form-control"></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!--STILE DI VITA------------>


                                                            <!-- GRAVIDANZE ---------------------->
                                                            <div id="gravidanze" class="accordion-body collapse">
                                                                <div class="accordion-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="box dark">
                                                                                <header><h5>Gravidanze</h5>
                                                                                    <div class="toolbar">
                                                                                        <ul class="nav">
                                                                                            <li><a id="btnsalva"><i
                                                                                                            class="icon-save"
                                                                                                            style="visibility: hidden;"></i></a>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </header>
                                                                                <div class="accordion-body">
                                                                                    <br/>

                                                                                    <div class="table-responsive">
                                                                                        <table id="tbl"
                                                                                               class="table table-striped table-bordered table-hover">
                                                                                            <thead>
                                                                                            <tr>
                                                                                                <th>#</th>
                                                                                                <th>Et&#224;</th>
                                                                                                <th>Inizio</th>
                                                                                                <th>Fine</th>
                                                                                                <th>Esito</th>
                                                                                                <th>Sesso</th>
                                                                                                <th>Note</th>
                                                                                                <th></th>
                                                                                            </tr>
                                                                                            </thead>
                                                                                            <tbody>


                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>

                                                                                    <!--inserisci gravidanza modal-->
                                                                                    <div class="col-lg-5">


                                                                                        <a id="insgrav"
                                                                                           class="accordion-toggle"
                                                                                           data-toggle="collapse"
                                                                                           data-parent="#accordion"
                                                                                           href="#nuovegrav">
                                                                                            <h5>
                                                                                                <i class="icon-plus"></i>Inserisci
                                                                                                nuova gravidanza</h5>
                                                                                        </a>
                                                                                    </div><!--fine inserisci modal-->

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!--GRAVIDANZE-------------->


                                                            <!-- GRAVIDANZE NUOVE---------------------->
                                                            <div id="nuovegrav" class="accordion-body collapse">
                                                                <div class="accordion-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="accordion-body">
                                                                                <br/>
                                                                                <form class="form-horizontal"
                                                                                      id="formgravidanze">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label col-lg-2"
                                                                                               for="esito">Esito:</label>
                                                                                        <div class="col-lg-4">

                                                                                            <select class="form-control"
                                                                                                    name="esito"
                                                                                                    id="esito">
                                                                                                <option></option>
                                                                                                <option id="Positivo">
                                                                                                    Positivo
                                                                                                </option>
                                                                                                <option id="Negativo">
                                                                                                    Negativo
                                                                                                </option>

                                                                                            </select>
                                                                                        </div>
                                                                                        <label for="etaGravidanza"
                                                                                               class="control-label col-lg-4">Et&#224;
                                                                                            gravidanza:</label>
                                                                                        <div class="col-lg-2">
                                                                                        <textarea id="etaGravidanza"
                                                                                                  name="etaGravidanza"
                                                                                                  class="form-control"
                                                                                                  onblur="isnum(this)"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="dataInizioGrav"
                                                                                               class="control-label col-lg-5">Data
                                                                                            inizio gravidanza:</label>
                                                                                        <div class="col-lg-6">
                                                                                            <input type="date"
                                                                                                   name="dataInizioGrav"
                                                                                                   id="dataInizioGrav"
                                                                                                   class="form-control col-lg-6"/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="dataFineGrav"
                                                                                               class="control-label col-lg-5">Data
                                                                                            fine gravidanza:</label>
                                                                                        <div class="col-lg-6">
                                                                                            <input type="date"
                                                                                                   name="dataFineGrav"
                                                                                                   id="dataFineGrav"
                                                                                                   class="form-control col-lg-6"/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">

                                                                                        <label class="control-label col-lg-5"
                                                                                               for="sessoBambino">Sesso
                                                                                            bambino:</label>
                                                                                        <div class="col-lg-6">

                                                                                            <select class="form-control"
                                                                                                    name="sessoBambino"
                                                                                                    id="sessoBambino">
                                                                                                <option></option>
                                                                                                <option id="Maschile">
                                                                                                    Maschio
                                                                                                </option>
                                                                                                <option id="Femminile">
                                                                                                    Femmina
                                                                                                </option>

                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div class="col-lg-1">
                                                                                        <textarea id="hiddenid"
                                                                                                  name="hiddenid"
                                                                                                  class="form-control"
                                                                                                  style="visibility: hidden;"></textarea>
                                                                                        </div>
                                                                                        <label for="noteGravidanza"
                                                                                               class="control-label col-lg-4">Note:</label>
                                                                                        <div class="col-lg-6">
                                                                                        <textarea id="noteGravidanza"
                                                                                                  name="noteGravidanza"
                                                                                                  class="form-control"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group; col-lg-11"
                                                                                         style="text-align:right">
                                                                                        <!--bottoni per la gestione delle modifiche-->
                                                                                        <input type="button"
                                                                                               value="Salva"
                                                                                               id="btnsalvagrav"
                                                                                               class="btn btn-success btn-sm"/>
                                                                                        <input type="button"
                                                                                               value="Annulla"
                                                                                               id="btnannullagrav"
                                                                                               class="btn btn-danger btn-sm"/>
                                                                                        <input type="button"
                                                                                               value="Salva"
                                                                                               id="btnsalvagrav2"
                                                                                               class="btn btn-success btn-sm"
                                                                                               style="display: none;"/>
                                                                                        <input type="button"
                                                                                               value="Annulla"
                                                                                               id="btnannullagrav2"
                                                                                               class="btn btn-danger btn-sm"
                                                                                               style="display: none;"/>


                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- GRAVIDANZE NUOVE -------------->

                                                            <div class="row">

                                                                <div class="col-lg-4">
                                                                    <a id="inf5" class="accordion-toggle"
                                                                       data-toggle="collapse"
                                                                       data-parent="#accordionUtility"
                                                                       href="#cicloMestruale">
                                                                        <h5><i class="icon-pencil icon-white"></i>Ciclo
                                                                            Mestruale</h5>
                                                                    </a>
                                                                </div>

                                                                <div class="col-lg-4">
                                                                    <a id="inf6" class="accordion-toggle"
                                                                       data-toggle="collapse"
                                                                       data-parent="#accordionUtility"
                                                                       href="#attivitaLavorativa">
                                                                        <h5><i class="icon-pencil icon-white"></i>Attivit&#224;
                                                                            lavorativa</h5>
                                                                    </a>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <a id="inf7" class="accordion-toggle"
                                                                       data-toggle="collapse"
                                                                       data-parent="#accordionUtility"
                                                                       href="#alvominzione">
                                                                        <h5><i class="icon-pencil icon-white"></i>Alvo e
                                                                            minzione</h5>
                                                                    </a>
                                                                </div>
                                                            </div>


                                                            <!-- CICLO MESTRUALE ---------------------->

                                                            <div id="cicloMestruale" class="accordion-body collapse">
                                                                <div class="accordion-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="box dark">
                                                                                <header><h5>Ciclo Mestruale</h5>
                                                                                    <div class="toolbar">
                                                                                        <ul class="nav">
                                                                                            <li><input type="button"
                                                                                                       value="Salva"
                                                                                                       id="btnsalvaciclo"
                                                                                                       class="btn btn-success btn-sm"/>
                                                                                            </li>
                                                                                            <li><input type="button"
                                                                                                       value="Annulla"
                                                                                                       id="btnannullaciclo"
                                                                                                       class="btn btn-danger btn-sm"/>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </header>
                                                                                <div class="accordion-body">
                                                                                    <br/>
                                                                                    <form class="form-horizontal"
                                                                                          id="formciclomestruale">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-3"
                                                                                                   for="etaMenarca">Et&#224;
                                                                                                menarca:</label>
                                                                                            <div class="col-lg-3">
                                                                                                <select class="form-control"
                                                                                                        name="etaMenarca"
                                                                                                        id="etaMenarca">
                                                                                                    <option></option>
                                                                                                    <option id="otto">
                                                                                                        8
                                                                                                    </option>
                                                                                                    <option id="nove">
                                                                                                        9
                                                                                                    </option>
                                                                                                    <option id="dieci">
                                                                                                        10
                                                                                                    </option>
                                                                                                    <option id="undici">
                                                                                                        11
                                                                                                    </option>
                                                                                                    <option id="dodici">
                                                                                                        12
                                                                                                    </option>
                                                                                                    <option id="tredici">
                                                                                                        13
                                                                                                    </option>
                                                                                                    <option id="quattordici">
                                                                                                        14
                                                                                                    </option>
                                                                                                    <option id="quindici">
                                                                                                        15
                                                                                                    </option>
                                                                                                    <option id="sedici">
                                                                                                        16
                                                                                                    </option>
                                                                                                    <option id="diciasette">
                                                                                                        17
                                                                                                    </option>
                                                                                                    <option id="diciotto">
                                                                                                        18
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <label class="control-label col-lg-2"
                                                                                                   for="ciclo">Ciclo:</label>
                                                                                            <div class="col-lg-4">
                                                                                                <select class="form-control"
                                                                                                        name="ciclo"
                                                                                                        id="ciclo">
                                                                                                    <option></option>
                                                                                                    <option value="regolare">
                                                                                                        regolare
                                                                                                    </option>
                                                                                                    <option value="irregolare">
                                                                                                        irregolare
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="etaMenopausa"
                                                                                                   class="control-label col-lg-3">Et&#224;
                                                                                                Menopausa:</label>
                                                                                            <div class="col-lg-2">
                                                                                            <textarea id="etaMenopausa"
                                                                                                      name="etaMenopausa"
                                                                                                      placeholder="Et&#224;"
                                                                                                      class="form-control"
                                                                                                      onblur="isnum(this)"></textarea>
                                                                                            </div>
                                                                                            <label class="control-label col-lg-3"
                                                                                                   for="menopausa">Menopausa:</label>
                                                                                            <div class="col-lg-4">
                                                                                                <select class="form-control"
                                                                                                        name="menopausa"
                                                                                                        id="menopausa">
                                                                                                    <option></option>
                                                                                                    <option value="fisiologica">
                                                                                                        fisiologica
                                                                                                    </option>
                                                                                                    <option value="chirurgica">
                                                                                                        chirurgica
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="noteStileVita"
                                                                                                   class="control-label col-lg-3">Note:</label>
                                                                                            <div class="col-lg-9">
                                                                                            <textarea id="noteCicloMes"
                                                                                                      name="noteCicloMes"
                                                                                                      class="form-control"></textarea>
                                                                                            </div>
                                                                                        </div>

                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!--CICLO MESTRUALE-------------->


                                                            <!-- ATTIVITA' LAVORATIVA ---------------------->
                                                            <div id="attivitaLavorativa"
                                                                 class="accordion-body collapse">
                                                                <div class="accordion-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="box dark">
                                                                                <header><h5>Attivit&#224;
                                                                                        lavorativa</h5>
                                                                                    <div class="toolbar">
                                                                                        <ul class="nav">
                                                                                            <li><input type="button"
                                                                                                       value="Salva"
                                                                                                       id="btnsalvalavoro"
                                                                                                       class="btn btn-success btn-sm"/>
                                                                                            </li>
                                                                                            <li><input type="button"
                                                                                                       value="Annulla"
                                                                                                       id="btnannullalavoro"
                                                                                                       class="btn btn-danger btn-sm"/>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </header>
                                                                                <div class="accordion-body">
                                                                                    <br/>
                                                                                    <form class="form-horizontal"
                                                                                          id="formattivitalavorativa">
                                                                                        <div class="form-group">
                                                                                            <label for="professione"
                                                                                                   class="control-label col-lg-4">Professione:</label>
                                                                                            <div class="col-lg-8">
                                                                                            <textarea id="professione"
                                                                                                      name="professione"
                                                                                                      class="form-control"></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="noteAttLav"
                                                                                                   class="control-label col-lg-4">Note:</label>
                                                                                            <div class="col-lg-8">
                                                                                            <textarea id="noteAttLav"
                                                                                                      name="noteAttLav"
                                                                                                      class="form-control"></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!--ATTIVITA' LAVORATIVA------------>

                                                            <!-- ALVO E MINZIONE ---------------------->
                                                            <div id="alvominzione" class="accordion-body collapse">
                                                                <div class="accordion-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="box dark">
                                                                                <header><h5>Alvo e minzione</h5>
                                                                                    <div class="toolbar">
                                                                                        <ul class="nav">
                                                                                            <li><input type="button"
                                                                                                       value="Salva"
                                                                                                       id="btnsalvaminzione"
                                                                                                       class="btn btn-success btn-sm"/>
                                                                                            </li>
                                                                                            <li><input type="button"
                                                                                                       value="Annulla"
                                                                                                       id="btnannullaminzione"
                                                                                                       class="btn btn-danger btn-sm"/>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </header>
                                                                                <div class="accordion-body">
                                                                                    <br/>
                                                                                    <form class="form-horizontal"
                                                                                          id="formalvominzione">
                                                                                        <div class="form-group">

                                                                                            <label for="alvo"
                                                                                                   class="control-label col-lg-4">Alvo:</label>
                                                                                            <div class="col-lg-8">
                                                                                                <select class="form-control"
                                                                                                        name="alvo"
                                                                                                        id="alvo">
                                                                                                    <option></option>
                                                                                                    <option id="alvoregolare">
                                                                                                        regolare
                                                                                                    </option>
                                                                                                    <option id="alvostitico">
                                                                                                        stitico
                                                                                                    </option>
                                                                                                    <option id="alvodiarroico">
                                                                                                        diarroico
                                                                                                    </option>
                                                                                                    <option id="alvoalterno">
                                                                                                        alterno
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="minzione"
                                                                                                   class="control-label col-lg-4">Minzione:</label>
                                                                                            <div class="col-lg-8">
                                                                                                <select class="form-control"
                                                                                                        name="minzione"
                                                                                                        id="minzione">
                                                                                                    <option></option>
                                                                                                    <option id="minzionenellanorma">
                                                                                                        nella norma
                                                                                                    </option>
                                                                                                    <option id="minzionepatologica">
                                                                                                        patologica
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="noteAlvoMinz"
                                                                                                   class="control-label col-lg-4">Note:</label>
                                                                                            <div class="col-lg-8">
                                                                                            <textarea id="noteAlvoMinz"
                                                                                                      name="noteAlvoMinz"
                                                                                                      class="form-control"></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!--ALVO E MINZIONE------------>


                                                        </div><!--col-lg-12-->
                                                    </div><!--accordion- group heading centered-->


                                                </div><!--chiusura accordion-group-->
                                            </div><!--chiusura accordion ac-->
                                        </div><!--chiusura table-bordered-->
                                    </div><!--chiusura table-responsive-->
                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!--MODAL MODIFICA PATOLOGIE PREGRESSE-->
            <div class="col-md-4">
                <div class="modal fade" id="modanamnesipat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica patologie pregresse</h4>
                            </div>
                            <form class="form-horizontal" id="modpatinfo">
                                <div class="modal-body">
                                    <label style="font: bold;">Seleziona uno o pi&#249; gruppi di patologie</label>


                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button type="button" onclick="checkprova()" class="btn btn-primary"
                                            data-dismiss="modal">Salva
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!--fine del modal modifica patologie pregresse-->


            <!--MODAL MODIFICA PATOLOGIE RECENTI-->
            <div class="col-md-4">
                <div class="modal fade" id="modanamnesipatrec" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica patologie recenti</h4>
                            </div>
                            <form class="form-horizontal" id="modpatinfo">
                                <div class="modal-body">
                                    <label style="font: bold;">Seleziona uno o pi&#249; gruppi di patologie</label>


                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button type="button" onclick="checkprovapros()" class="btn btn-primary"
                                            data-dismiss="modal">Salva
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!--MODAL SPOSTA da prossima a remota-->
            <div class="col-md-4">
                <div class="modal fade" id="modansposta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Conferma spostamento ad Anamnesi patologica remota</h4>
                            </div>
                            <form class="form-horizontal" id="modspostainfo">
                                <div class="modal-body form-gr">
                                    <label style="font: bold;">Modifica</label>
                                    <hr/>
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                        <textarea class="form-control" id="testosposta" name="testosposta" cols="44"
                                                  rows="15"
                                                  style="resize:none; border: transparent; overflow-y: visible; height: 100%; max-height: 200px;"></textarea>
                                        </tbody>
                                        </tr></table>
                                    <label style="font: bold;">Seleziona i gruppi di patologie recenti da spostare in
                                        patologie pregresse</label>


                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button type="button" id="btnspostamodal" onclick="checksposta()"
                                            class="btn btn-primary" data-dismiss="modal">Salva
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- &#224; -->
            <!------------------------- JAVASCRIPT UTILIZZATI ----------------------------------->

            <!-- VERIFICA CAMPO CON NUMERI -->
            <script language="Javascript">
                function isnum(obj) {
                    if (isNaN(obj.value) || parseInt(obj.value) < 10 || parseInt(obj.value) > 99) {
                        alert('Nel campo \u00E8 possibile immettere solo numeri a due cifre!');
                        obj.value = "";
                        obj.focus();
                    }
                }
            </script>
            <script language="Javascript">
                function isgrav(obj) {
                    if (isNaN(obj.value) || parseInt(obj.value) < 1 || parseInt(obj.value) > 99) {
                        alert('Nel campo \u00E8 possibile immettere solo numeri a due cifre!');
                        obj.value = "";
                        obj.focus();
                    }
                }
            </script>

            <!-- RIDIMENSIONA TEXTAREA IN BASE AL CONTENUTO AL CLICK -->
            <script>
                function textAreaAdjust(o) {
                    o.style.height = "1px";
                    o.style.height = (25 + o.scrollHeight) + "px";
                }
            </script>
            <!-- COPIA TESTO DA TEXTVIEW A MODAL IN PATOLOGIE PREGRESSE -->
            <script type="text/javascript">
                function InserisciTesto() {
                    var testo = document.getElementById("testopatpp").value;
                    document.getElementById("testosposta").value = testo;
                }</script>
            <!-- SPOSTA DA CHECKLIST A TEXTAREA -->

            <script type="text/javascript">
                function checkprova2() {
                    if (document.getElementById('testopatmodrec').value != null) {
                        document.getElementById('testopatmodrec').value = '';
                    }
                    var checkedValue = null;
                    var inputElements = document.getElementsByClassName('ck2');
                    for (var i = 0; inputElements[i]; ++i) {
                        if (inputElements[i].checked) {
                            checkedValue = inputElements[i].value;
                            document.getElementById('testopatmodrec').value += '-' + checkedValue;
                        }
                    }
                }</script>
            <!--DELETE GRAVIDANZE-->
            <script>
                function delGrav(valor) {
                    if (confirm('Eliminare la gravidanza selezionata?') == true) {

                        $.post("formscripts/testofis.php",
                            {

                                valor: valor,

                            },

                            function (status) {

                                alert("Status: " + "Eliminazione avvenuta correttamente");
                                window.location.reload();

                            });
                    }
                }
            </script>
            <!--PASSAGGIO DATI PER MODIFICA GRAVIDANZA-->
            <script>
                function passDati(i, idy) {
                    if (confirm('Modificare la gravidanza selezionata?') == true) {
                        $('#nuovegrav').collapse('show');
                        $('#btnsalvagrav').hide()
                        $('#btnannullagrav').hide()
                        $('#btnsalvagrav2').show()
                        $('#btnannullagrav2').show()
                        $('#insgrav').prop('class', "hidden")
                        $('#hiddenid').prop('value', idy);
                        $('#esito').prop('value', document.getElementById("tbl").rows[i].cells[4].innerHTML);
                        $('#etaGravidanza').prop('value', document.getElementById("tbl").rows[i].cells[1].innerHTML);
                        $('#sessoBambino').prop('value', document.getElementById("tbl").rows[i].cells[5].innerHTML);
                        $('#dataInizioGrav').prop('value', document.getElementById("tbl").rows[i].cells[2].innerHTML);
                        $('#dataFineGrav').prop('value', document.getElementById("tbl").rows[i].cells[3].innerHTML);
                        $('#noteGravidanza').prop('value', document.getElementById("tbl").rows[i].cells[6].innerHTML);


                    }

                }
            </script>

            <script type="text/javascript">
                function checkprova() {
                    if (document.getElementById('testopatmod').value != null) {
                        document.getElementById('testopatmod').value = '';
                    }
                    var checkedValue = null;
                    var somma = [];
                    var inputElements = document.getElementsByClassName('ck');
                    for (var i = 0; inputElements[i]; ++i) {
                        if (inputElements[i].checked) {
                            checkedValue = inputElements[i].value;
                            somma.push(checkedValue);

                        }
                    }

                    $.post("formscripts/testopat.php",
                        {

                            checkedVal: somma,

                        },
                        function (status) {

                            alert("Status: " + "Modifica effettuata");
                            window.location.reload();

                        });

                }</script>
            <script type="text/javascript">
                function checkprovapros() {
                    if (document.getElementById('testopatmodrec').value != null) {
                        document.getElementById('testopatmodrec').value = '';
                    }
                    var checkedValue2 = null;
                    var somma2 = [];
                    var inputElements2 = document.getElementsByClassName('ck2');
                    for (var i = 0; inputElements2[i]; ++i) {
                        if (inputElements2[i].checked) {
                            checkedValue2 = inputElements2[i].value;
                            somma2.push(checkedValue2);
//alert("Status: " + somma2);
//$('#testopatmodrec').prop('value', somma2);
                        }
                    }

                    $.post("formscripts/testopat.php",
                        {

                            checkedVal2: somma2,

                        },
                        function (status) {

                            alert("Status: " + "Modifica effettuata");
                            window.location.reload();
                        });


                }</script>
            <script type="text/javascript">
                function checksposta() {
                    var checkedValue3 = null;
                    var somma3 = [];
                    var inputElements3 = document.getElementsByClassName('cksposta');
                    for (var i = 0; inputElements3[i]; ++i) {
                        if (inputElements3[i].checked) {
                            checkedValue3 = inputElements3[i].value;
                            somma3.push(checkedValue3);
                        }
                    }
                    if (confirm('Spostare testo da patologia prossima a remota?') == true) {
                        $.post("formscripts/testopat.php",
                            {
                                testosposta: $("#testosposta").val(),
                                testopatsposta: $("#testopat").val(),
                                checkedVal3: somma3,

                            },
                            function (status) {

                                alert("Status: " + "Modifica effettuata correttamente");
                                window.location.reload();
                            });

                    }


                }</script>


        </div>
    </div><!--content-->
    <!--END PAGE CONTENT -->

@endsection