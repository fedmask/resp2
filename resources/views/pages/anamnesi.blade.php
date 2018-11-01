@extends( 'layouts.app' )
@extends( 'includes.template_head' )
@section( 'pageTitle', 'Anamnesi' )
@section( 'content' )

    <div id="content">
        <div class="inner">
            <div class="row">
                <div class="col-lg-8">
                    <h2> Anamnesi </h2>
                </div>
                <div class="col-lg-2" style="text-align:right">
                    <a class="quick-btn" data-toggle="modal" data-target="#Print"><i class="icon-print icon-2x"></i><span>Stampa</span></a>
                </div>
            </div><!--row-->
            <hr/>

            <div class="modal fade" tabindex="-1" role="dialog" id="Print">
                <div class="modal-dialog" role="document" style="width:90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Anteprima di stampa</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @include('pages.anamnesi_print')
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                            <a href="{{url('/anamnesiprint')}}" target="_blank" type="button" class="btn btn-primary">Stampa</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- script per la manipolazione delle anamnesi familiari-->
            <script src="{{url('https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js')}}"></script>
            <script src="{{asset('js/formscripts/jquery.js')}}"></script>
            <script src="{{asset('js/formscripts/jquery-ui.js')}}"></script>
            <script type="text/javascript" src="{{ url('/js/formscripts/anamnesi.js') }}"></script>
            <script type="text/javascript" src="{{ url('js/formscripts/modanamfam.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/formscripts/modanamnesifis.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/formscripts/modanamnesipat.js') }}"></script>

            <div class="row">

                <!-- TABELLA RELATIVA ALL'ANAMNESI FAMILIARE-->
                <div class="col-6">
                    <form action="{{ action('AnamnesiController@store') }}" method="post" class="form-horizontal">
                        <input name="input_name" value="Familiare" hidden />
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
                                              placeholder="qui puoi inserire il tuo testo...">@foreach($anamnesiFamiliare as $a){{ $a->anamnesi_contenuto }}@endforeach</textarea>
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
                </div>

                <!-- TABELLA RELATIVA ALL'ANAMNESI FISIOLOGICA -->
                <div class="col-6">
                    <form action="#" class="form-horizontal">
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
                                                     style="resize:none; border: transparent; overflow-y: scroll; max-height: 200px;">@if($anamnesiFisiologica->tempoParto != null)- Nato da parto: {{$anamnesiFisiologica->tempoParto}},@endif @if($anamnesiFisiologica->tipoParto != null){{$anamnesiFisiologica->tipoParto}}.@endif @if($anamnesiFisiologica->allattamento != null)&#13;- Allattamento: {{$anamnesiFisiologica->allattamento}}@endif @if($anamnesiFisiologica->sviluppoVegRel != null)&#13;- Sviluppo vegetativo e relazionale: {{$anamnesiFisiologica->sviluppoVegRel}}.@endif @if($anamnesiFisiologica->noteInfanzia != null)&#13;- Note infanzia: {{$anamnesiFisiologica->noteInfanzia}}.@endif @if($anamnesiFisiologica->livelloScol != null)&#13;- Livello scolastico: {{$anamnesiFisiologica->livelloScol}}.@endif @if($anamnesiFisiologica->attivitaFisica != null)&#13;- Attività fisica: {{$anamnesiFisiologica->attivitaFisica}}.@endif @if($anamnesiFisiologica->abitudAlim != null)&#13;- Abitudini alimentari: {{$anamnesiFisiologica->abitudAlim}}.@endif @if($anamnesiFisiologica->ritmoSV != null)&#13;- Ritmo sonno veglia: {{$anamnesiFisiologica->ritmoSV}}.@endif @if($anamnesiFisiologica->fumo != null)&#13;- Fumo: {{$anamnesiFisiologica->fumo}}.@endif @if($anamnesiFisiologica->freqFumo != null)&#13;- Frequenza fumo: {{$anamnesiFisiologica->freqFumo}}.@endif @if($anamnesiFisiologica->alcool != null)&#13;- Alcool: {{$anamnesiFisiologica->alcool}}.@endif @if($anamnesiFisiologica->freqAlcool != null)&#13;- Frequenza alcool: {{$anamnesiFisiologica->freqAlcool}}.@endif @if($anamnesiFisiologica->droghe != null)&#13;- Droghe: {{$anamnesiFisiologica->droghe}}.@endif @if($anamnesiFisiologica->freqDroghe != null)&#13;- Frequenza droghe: {{$anamnesiFisiologica->freqDroghe}}.@endif @if($anamnesiFisiologica->noteStileVita != null)&#13;- Note stile di vita: {{$anamnesiFisiologica->noteStileVita}}.@endif @if($anamnesiFisiologica->etaMenarca != null)&#13;- Età menarca: {{$anamnesiFisiologica->etaMenarca}}.@endif @if($anamnesiFisiologica->ciclo != null)&#13;- Ciclo: {{$anamnesiFisiologica->ciclo}}.@endif @if($anamnesiFisiologica->etaMenopausa != null)&#13;- Età menopausa: {{$anamnesiFisiologica->etaMenopausa}}.@endif @if($anamnesiFisiologica->menopausa != null)&#13;- Menopausa: {{$anamnesiFisiologica->menopausa}}.@endif @if($anamnesiFisiologica->noteCicloMes != null)&#13;- Note ciclo mestruale: {{$anamnesiFisiologica->noteCicloMes}}.@endif @if($anamnesiFisiologica->professione != null)&#13;- Professione: {{$anamnesiFisiologica->professione}}.@endif @if($anamnesiFisiologica->noteAttLav != null)&#13;- Note attività lavorative: {{$anamnesiFisiologica->noteAttLav}}.@endif @if($anamnesiFisiologica->alvo != null)&#13;- Alvo: {{$anamnesiFisiologica->alvo}}.@endif @if($anamnesiFisiologica->minzione != null)&#13;- Minzione: {{$anamnesiFisiologica->minzione}}.@endif @if($anamnesiFisiologica->noteAlvoMinz != null)&#13;- Note alvo, minzione: {{$anamnesiFisiologica->noteAlvoMinz}}.@endif</textarea>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--bottone che fa comparire un menu con tutte le voci della FISIOLOGICA-->

                                <div class="panel-footer" style="text-align:right">
                                </div>
                            </div><!--row familiare e fisiologica-->

                        </div>
                    </form>
                </div>
                <!--inner-->

            </div><!--content-->

            <div class="row">

                <!-- TABELLA RELATIVA ALL'ANAMNESI PATOLOGICA REMOTA-->
                <div class="col-6">
                    <form action="{{ action('AnamnesiController@store') }}" method="post" class="form-horizontal">

                        <input name="input_name" value="PatologicaRemota" hidden />
                        {{csrf_field()}}
                        <div class="col-md-6">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <center><h4>Patologica remota</h4></center>
                                    <div class="btn-group" style="text-align: left;">
                                        <!--bottoni per la gestione delle modifiche-->
                                        <button type="submit" class="btn btn-success btn-sm" id="btn_salvapatrem"
                                                style="display: none;"><i
                                                    class="icon-save"></i>Salva</button>
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
                                              style="resize:none; border: transparent; overflow-y: scroll; max-height: 200px;" placeholder="qui puoi inserire il tuo testo...">@foreach($anamnesiPatologicaRemota as $apr){{ $apr->anamnesi_remota_contenuto }}@endforeach</textarea>
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
												<div style="resize:none; border: transparent; overflow-y: scroll; font-size: small; height: 20%;">@foreach($anamnesiPatologicaRemota as $apr) @if($apr->icd9_group_code != null)- {!! str_replace("_", "." . "<br>" . "- ", rtrim($apr->icd9_group_code, "_")) . "." !!}@endif @endforeach</div>
                                            </tr>
                                            <div class="panel-body;" style="text-align:left">

                                            </div>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="panel-footer" style="text-align:right">
                                </div>
                            </div><!--panel warning-->
                        </div><!--col-md-6-->
                    </form>
                </div>

                <!-- TABELLA RELATIVA ALL'ANAMNESI PATOLOGICA PROSSIMA-->
                <div class="col-6">
                    <form action="{{ action('AnamnesiController@store') }}" method="post" class="form-horizontal">
                        <input name="input_name" value="PatologicaProssima" hidden />
                        {{csrf_field()}}
                        <div class="col-md-6">
                            <!--	<div class="panel panel-primary">-->
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <center><h4>Patologica prossima</h4></center>

                                    <!--bottoni per la gestione delle modifiche-->
                                    <div class="btn-group" style="text-align: left;">
                                        <a id="buttonHiddenpp" class="btn btn-danger btn-sm btn-line pull-right"><i
                                                    class="icon-pencil icon-white"></i>Aggiorna</a>
                                        <button class="btn btn-info btn-sm pull-left" id="btnsposta" data-toggle="modal"
                                                data-target="#modansposta" onclick="InserisciTesto()"><i
                                                    class="icon-hand-left"></i>
                                            Sposta
                                        </button>

                                        <button type="submit" class="btn btn-success btn-sm" id="btn_salvapp" style="display: none;"><i
                                                    class="icon-save"></i>Salva</button>
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
                                                     style="resize:none; border: transparent; overflow-y: scroll; max-height: 200px;" placeholder="qui puoi inserire il tuo testo...">@foreach($anamnesiPatologicaProssima as $app){{ $app->anamnesi_prossima_contenuto }}@endforeach</textarea>
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
                                           <div contenteditable  style="resize:none; border: transparent; overflow-y: scroll; font-size: small; height: 20%;">@foreach($anamnesiPatologicaProssima as $app) @if($app->icd9_group_code != null)- {!! str_replace("_", "." . "<br>" . "- ", rtrim($app->icd9_group_code, "_")) . "." !!}@endif @endforeach</div>
                                            </tr>
                                            <!--<hr />-->
                                            <div class="panel-body;" style="text-align:left">

                                            </div>


                                            </tbody>
                                        </table>
                                    </div>
                                </div> <!--panel-body-->
                                <!--bottone che apre il pannello per le modifiche informazioni ANAMNESI PATOLOGICA REMOTA-->


                                <div class="panel-footer clearfix">


                                </div>
                            </div> <!--panel danger-->
                        </div>
                    </form><!--col-md-6 patologica prossima-->
                </div>
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

                        <form id="formA" action="{{ action('AnamnesiController@store') }}" method="post" class="form-horizontal">
                            <input name="input_name" value="Parente" hidden />
                            {{csrf_field()}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Nome componente:</label>
                                    <div class="col-lg-6">
                                        <input id="nome_componenteA" name="nome_componente" type="text" class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Grado parentela:</label>
                                    <div class="col-lg-6">
                                        <select id="gradoParentela" name="grado_parentela" class="form-control">
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
                                        <select id="sessoA" name="sesso" class="form-control">
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
                                        <input id="anni_componenteA" type="text" name="età" class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Data decesso:</label>
                                    <div class="col-lg-6">
                                        <input type="date" name="data_decesso" id="data_morteA"
                                               class="form-control col-lg-6" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Annotazioni:</label>
                                    <div class="col-lg-6">
                                        <textarea id="annotazioni" name="annotazioni" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="btn" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                <button type="submit" class="btn btn-primary" id="concludiA">Aggiungi</button>
                            </div>
                        </form>


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

                                    @foreach($parente as $p)
                                        <tr>
                                            <td>{{$p->nome}}</td>
                                            <td>{{$p->sesso}}</td>
                                            <td>{{$p->età}}</td>
                                            <td>{{$p->annotazioni}}</td>
                                            @if($p->id_paziente == $userid)
                                                <td>
                                                    <div id="row">
                                                        <div id="col-lg-12">
                                                            <div id="btn-group">
                                                                <form action="{{ route('Delete', ['id' => $p->id_parente]) }}" method="post"
                                                                      class="form-horizontal">
                                                                    {{csrf_field()}}
                                                                    {{ method_field('DELETE') }}
                                                                    <input name="input_name" value="DeleteParente" hidden />
                                                                    <input class="form-control hidden" type="text" name="ids[]" value="{{ $p->id_parente }}" disabled>
                                                                    <button class="btn btn-primary" data-toggle="modal" id="{{$p->id_parente}}"
                                                                            data-target="#edit-{{ $p->id_parente }}" data-dismiss="modal"><i class="icon-pencil icon-white"></i></button>
                                                                    <button type="submit" class="elimina btn btn-danger"><i class="icon-remove icon-white"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div><!--table responsive-->


                        </div><!--PANEL BODY -->
                    </div>
                </div>
            </div>

            @foreach($parente as $p)
                <form action="{{ route('Update', ['id' => $p->id_parente]) }}" method="post"
                      class="form-horizontal">
                    {{csrf_field()}}
                    {{ method_field('PATCH') }}
                    <input name="input_name" value="UpdateParente" hidden />
                    <input class="form-control hidden" type="text" name="ids[]" value="{{ $p->id_parente }}" disabled>
                    <div class="modal fade" id="edit-{{ $p->id_parente }}" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                            id="chiudianamnesifam">&times;
                                    </button>
                                    <h4 class="modal-title" id="H2">Modifica anamnesi familiare FHIR</h4>
                                </div>

                                <br>


                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Nome componente:</label>
                                        <div class="col-lg-6">
                                            <input id="nome_componenteA" name="nome_componente" type="text"
                                                   class="form-control" value="{{$p->nome}}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Grado :</label>
                                        <div class="col-lg-6">
                                            <select id="gradoParentela" name="grado_parentela" class="form-control">
                                                <option @if( $p->grado_parentela == "fratello") value="{{$p->grado_parentela}}" selected="selected" @else value="fratello" @endif>Fratello</option>
                                                <option @if( $p->grado_parentela == "genitore") value="{{$p->grado_parentela}}" selected="selected" @else value="genitore" @endif>Genitore</option>
                                                <option @if( $p->grado_parentela == "nonno") value="{{$p->grado_parentela}}" selected="selected" @else value="nonno" @endif>Nonno/a</option>
                                                <option @if( $p->grado_parentela == "zio") value="{{$p->grado_parentela}}" selected="selected" @else value="zio" @endif>Zio/a</option>
                                                <option @if( $p->grado_parentela == "nipote") value="{{$p->grado_parentela}}" selected="selected" @else value="nipote" @endif>Nipote</option>
                                                <option @if( $p->grado_parentela == "cugino") value="{{$p->grado_parentela}}" selected="selected" @else value="cugino" @endif>Cugino/a</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Sesso:</label>
                                        <div class="col-lg-6">
                                            <select id="sessoA" name="sesso" class="form-control">
                                                <option @if( $p->sesso == "M") value="{{$p->sesso}}" selected="selected" @else value="M" @endif>Uomo</option>
                                                <option @if( $p->sesso == "F") value="{{$p->sesso}}" selected="selected" @else value="F" @endif>Donna</option>
                                                <option @if( $p->sesso == "O") value="{{$p->sesso}}" selected="selected" @else value="O" @endif>Altro</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Anni:</label>
                                        <div class="col-lg-6">
                                            <input  value="{{$p->età}}"  id="anni_componenteA" type="text" name="età" class="form-control"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Data decesso:</label>
                                        <div class="col-lg-6">
                                            <input type="date" name="data_decesso" value="{{$p->data_decesso}}" id="data_morteA"
                                                   class="form-control col-lg-6"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4"> Annotazioni:</label>
                                        <div class="col-lg-6">
                                            <textarea id="annotazioni" name="annotazioni"
                                                      class="form-control">{{$p->annotazioni}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="btn" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button type="submit" class="btn btn-primary" id="concludiA">Modifica</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        @endforeach
        <!-- chiusura modal per l'aggiornamento delle anamnesi familiari -->




            <!-- MODAL MODIFICA ANAMNESI FISIOLOGICA -->
            <div class="col-lg-12">



                <div class="modal fade" id="modanamnesifis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" style="width: 60%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica informazioni</h4>
                            </div>

                            <form id="modpatinfo" action="{{ action('AnamnesiController@store') }}" method="post" class="form-horizontal">
                                {{csrf_field()}}
                                <input name="input_name" value="Fisiologica" hidden />
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
                                                                @if($user->paziente_sesso == "female" or $user->paziente_sesso == "F")
                                                                    <div class="col-lg-3">
                                                                        <a id="inf4" class="accordion-toggle"
                                                                           data-toggle="collapse"
                                                                           data-parent="#accordionUtility"
                                                                           href="#gravidanze">
                                                                            <h5><i class="icon-pencil icon-white"></i>Gravidanze
                                                                            </h5>
                                                                        </a>
                                                                    </div>
                                                                @endif
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
                                                                                            <li><input type="submit"
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
                                                                                    <div class="form-group">
                                                                                        <label class="control-label col-lg-3"
                                                                                               for="parto">Nato da
                                                                                            parto:</label>
                                                                                        <div class="col-lg-4">
                                                                                            <select class="form-control"
                                                                                                    name="parto"
                                                                                                    id="parto" >
                                                                                                <option  @if( $anamnesiFisiologica->tempoParto == "") value="{{$anamnesiFisiologica->tempoParto}}" selected="selected" @endif></option>
                                                                                                <option  @if( $anamnesiFisiologica->tempoParto == "pretermine") value="{{$anamnesiFisiologica->tempoParto}}" selected="selected" @endif id="pretermine">
                                                                                                    pretermine
                                                                                                </option>
                                                                                                <option  @if( $anamnesiFisiologica->tempoParto == "termine") value="{{$anamnesiFisiologica->tempoParto}}" selected="selected" @endif id="termine">
                                                                                                    termine
                                                                                                </option>
                                                                                                <option  @if( $anamnesiFisiologica->tempoParto == "post-termine") value="{{$anamnesiFisiologica->tempoParto}}" selected="selected" @endif id="post-termine">
                                                                                                    post-termine
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-lg-5">
                                                                                            <select class="form-control"
                                                                                                    name="tipoparto"
                                                                                                    id="tipoparto">
                                                                                                <option @if( $anamnesiFisiologica->tipoParto == "") value="{{$anamnesiFisiologica->tipoParto}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->tipoParto == "naturale eutocico") value="{{$anamnesiFisiologica->tipoParto}}" selected="selected" @endif id="eutocico">
                                                                                                    naturale
                                                                                                    eutocico
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->tipoParto == "naturale distocito") value="{{$anamnesiFisiologica->tipoParto}}" selected="selected" @endif id="distocico">
                                                                                                    naturale
                                                                                                    distocito
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->tipoParto == "operatorio cesareo") value="{{$anamnesiFisiologica->tipoParto}}" selected="selected" @endif id="cesareo">
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
                                                                                                <option @if( $anamnesiFisiologica->allattamento == "") value="{{$anamnesiFisiologica->allattamento}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->allattamento == "materno") value="{{$anamnesiFisiologica->allattamento}}" selected="selected" @endif id="materno">
                                                                                                    materno
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->allattamento == "artificiale") value="{{$anamnesiFisiologica->allattamento}}" selected="selected" @endif id="artificiale">
                                                                                                    artificiale
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->allattamento == "mercenario") value="{{$anamnesiFisiologica->allattamento}}" selected="selected" @endif id="mercenario">
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
                                                                                                <option @if( $anamnesiFisiologica->sviluppoVegRel == "") value="{{$anamnesiFisiologica->sviluppoVegRel}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->sviluppoVegRel == "normale") value="{{$anamnesiFisiologica->sviluppoVegRel}}" selected="selected" @endif id="normale">
                                                                                                    normale
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->sviluppoVegRel == "patologico") value="{{$anamnesiFisiologica->sviluppoVegRel}}" selected="selected" @endif id="patologico">
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
                                                                                                      class="form-control">{{$anamnesiFisiologica->noteInfanzia}}</textarea>
                                                                                        </div>
                                                                                    </div>

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
                                                                                            <li><input type="submit"
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
                                                                                    <div class="form-group">
                                                                                        <label class="control-label col-lg-4"
                                                                                               for="livelloScol">Livello
                                                                                            scolastico:</label>
                                                                                        <div class="col-lg-8">

                                                                                            <select class="form-control"
                                                                                                    name="livelloScol"
                                                                                                    id="livelloScol">
                                                                                                <option @if( $anamnesiFisiologica->livelloScol == "") value="{{$anamnesiFisiologica->livelloScol}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->livelloScol == "analfabeta") value="{{$anamnesiFisiologica->livelloScol}}" selected="selected" @endif id="analfabeta">
                                                                                                    analfabeta
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->livelloScol == "elementare") value="{{$anamnesiFisiologica->livelloScol}}" selected="selected" @endif id="elementare">
                                                                                                    elementare
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->livelloScol == "medie-inferiori") value="{{$anamnesiFisiologica->livelloScol}}" selected="selected" @endif id="medie-inferiori">
                                                                                                    medie-inferiori
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->livelloScol == "diploma") value="{{$anamnesiFisiologica->livelloScol}}" selected="selected" @endif id="diploma">
                                                                                                    diploma
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->livelloScol == "laurea") value="{{$anamnesiFisiologica->livelloScol}}" selected="selected" @endif id="laurea">
                                                                                                    laurea
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>

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
                                                                                            <li><input type="submit"
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

                                                                                    <div class="form-group">
                                                                                        <label for="attivitaFisica"
                                                                                               class="control-label col-lg-4">Attivit&#224;
                                                                                            fisica:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <textarea
                                                                                                    id="attivitaFisica"
                                                                                                    name="attivitaFisica"
                                                                                                    class="form-control">{{$anamnesiFisiologica->attivitaFisica}}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="abitudAlim"
                                                                                               class="control-label col-lg-4">Abitudini
                                                                                            alimentari:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <textarea id="abitudAlim"
                                                                                                      name="abitudAlim"
                                                                                                      class="form-control">{{$anamnesiFisiologica->abitudAlim}}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="ritmoSV"
                                                                                               class="control-label col-lg-4">Ritmo
                                                                                            sonno veglia:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <textarea id="ritmoSV"
                                                                                                      name="ritmoSV"
                                                                                                      class="form-control">{{$anamnesiFisiologica->ritmoSV}}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="autosize"
                                                                                               class="control-label col-lg-3">Fumo:</label>
                                                                                        <div class="col-lg-3">
                                                                                            <select class="form-control"
                                                                                                    name="fumo"
                                                                                                    id="fumo">
                                                                                                <option @if( $anamnesiFisiologica->fumo == "") value="{{$anamnesiFisiologica->fumo}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->fumo == "no") value="{{$anamnesiFisiologica->fumo}}" selected="selected" @endif id="nofumo">
                                                                                                    no
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->fumo == "si") value="{{$anamnesiFisiologica->fumo}}" selected="selected" @endif id="sifumo">
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
                                                                                                   value="{{$anamnesiFisiologica->freqFumo}}" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="autosize"
                                                                                               class="control-label col-lg-3">Alcool:</label>
                                                                                        <div class="col-lg-3">
                                                                                            <select class="form-control"
                                                                                                    name="alcool"
                                                                                                    id="alcool">
                                                                                                <option @if( $anamnesiFisiologica->alcool == "") value="{{$anamnesiFisiologica->alcool}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->fumo == "no") value="{{$anamnesiFisiologica->alcool}}" selected="selected" @endif id="noalcool">
                                                                                                    no
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->fumo == "si") value="{{$anamnesiFisiologica->alcool}}" selected="selected" @endif id="sialcool">
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
                                                                                                   value="{{$anamnesiFisiologica->freqAlcool}}"/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="autosize"
                                                                                               class="control-label col-lg-3">Droghe:</label>
                                                                                        <div class="col-lg-3">
                                                                                            <select class="form-control"
                                                                                                    name="droghe"
                                                                                                    id="droghe">
                                                                                                <option @if( $anamnesiFisiologica->droghe == "") value="{{$anamnesiFisiologica->droghe}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->droghe == "no") value="{{$anamnesiFisiologica->droghe}}" selected="selected" @endif id="nodroghe">
                                                                                                    no
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->droghe == "si") value="{{$anamnesiFisiologica->droghe}}" selected="selected" @endif id="sidroghe">
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
                                                                                                   value="{{$anamnesiFisiologica->freqDroghe}}"/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="noteStileVita"
                                                                                               class="control-label col-lg-4">Note:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <textarea id="noteStileVita"
                                                                                                      name="noteStileVita"
                                                                                                      class="form-control">{{$anamnesiFisiologica->noteStileVita}}</textarea>
                                                                                        </div>
                                                                                    </div>
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
                                                                                                <th>Opzioni</th>
                                                                                            </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                            @foreach($gravidanza as $key => $g)

                                                                                                <tr>
                                                                                                    <td>{{$key+1}}</td>
                                                                                                    <td>{{$g->eta}}</td>
                                                                                                    <td>@if($g->inizio_gravidanza == null) @else{{date('d/m/Y', strtotime($g->inizio_gravidanza))}}@endif</td>
                                                                                                    <td>@if($g->fine_gravidanza == null) @else{{date('d/m/Y', strtotime($g->fine_gravidanza))}}@endif</td>
                                                                                                    <td>{{$g->esito}}</td>
                                                                                                    <td>{{$g->sesso_bambino}}</td>
                                                                                                    <td>{{$g->note_gravidanza}}</td>
                                                                                                    <td><a class="btn btn-primary" data-toggle="modal" data-target="#Updategravidanze-{{$g->id_gravidanza}}" data-dismiss="modal"><i class="icon-pencil icon-white"></i></a>
                                                                                                        <a class="elimina btn btn-danger" data-toggle="modal" data-target="#Deletegravidanze-{{$g->id_gravidanza}}" data-dismiss="modal"><i class="icon-remove icon-white"></i></a></td>
                                                                                                </tr>
                                                                                            @endforeach

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
                                                                                               id="datepicker"
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
                                                                                               id="datepicker"
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
                                                                                    <input type="submit"
                                                                                           value="Salva"
                                                                                           id="btnsalvagrav"
                                                                                           class="btn btn-success btn-sm"/>
                                                                                    <input type="button"
                                                                                           value="Annulla"
                                                                                           id="btnannullagrav"
                                                                                           class="btn btn-danger btn-sm"/>



                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- GRAVIDANZE NUOVE -------------->



                                                            <div class="row">

                                                                @if($user->paziente_sesso == "female" or $user->paziente_sesso == "F")
                                                                    <div class="col-lg-4">
                                                                        <a id="inf5" class="accordion-toggle"
                                                                           data-toggle="collapse"
                                                                           data-parent="#accordionUtility"
                                                                           href="#cicloMestruale">
                                                                            <h5><i class="icon-pencil icon-white"></i>Ciclo
                                                                                Mestruale</h5>
                                                                        </a>
                                                                    </div>
                                                                @endif
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
                                                                                            <li><input type="submit"
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

                                                                                    <div class="form-group">
                                                                                        <label class="control-label col-lg-3"
                                                                                               for="etaMenarca">Et&#224;
                                                                                            menarca:</label>
                                                                                        <div class="col-lg-3">
                                                                                            <select class="form-control"
                                                                                                    name="etaMenarca"
                                                                                                    id="etaMenarca">
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "8") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="otto">
                                                                                                    8
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "9") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="nove">
                                                                                                    9
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "10") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="dieci">
                                                                                                    10
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "11") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="undici">
                                                                                                    11
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "12") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="dodici">
                                                                                                    12
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "13") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="tredici">
                                                                                                    13
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "14") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="quattordici">
                                                                                                    14
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "15") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="quindici">
                                                                                                    15
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "16") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="sedici">
                                                                                                    16
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "17") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="diciasette">
                                                                                                    17
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "18") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="diciotto">
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
                                                                                                <option @if( $anamnesiFisiologica->ciclo == "") value="{{$anamnesiFisiologica->ciclo}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->ciclo == "regolare") value="{{$anamnesiFisiologica->ciclo}}" selected="selected" @endif value="regolare">
                                                                                                    regolare
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->ciclo == "irregolare") value="{{$anamnesiFisiologica->ciclo}}" selected="selected" @endif value="irregolare">
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
                                                                                                      onblur="isnum(this)">{{$anamnesiFisiologica->etaMenopausa}}</textarea>
                                                                                        </div>
                                                                                        <label class="control-label col-lg-3"
                                                                                               for="menopausa">Menopausa:</label>
                                                                                        <div class="col-lg-4">
                                                                                            <select class="form-control"
                                                                                                    name="menopausa"
                                                                                                    id="menopausa">
                                                                                                <option @if( $anamnesiFisiologica->menopausa == "") value="{{$anamnesiFisiologica->menopausa}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->menopausa == "fisiologica") value="{{$anamnesiFisiologica->menopausa}}" selected="selected" @endif value="fisiologica">
                                                                                                    fisiologica
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->menopausa == "chirurgica") value="{{$anamnesiFisiologica->menopausa}}" selected="selected" @endif value="chirurgica">
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
                                                                                                      class="form-control">{{$anamnesiFisiologica->noteCicloMes}}</textarea>
                                                                                        </div>
                                                                                    </div>


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
                                                                                            <li><input type="submit"
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

                                                                                    <div class="form-group">
                                                                                        <label for="professione"
                                                                                               class="control-label col-lg-4">Professione:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <textarea id="professione"
                                                                                                      name="professione"
                                                                                                      class="form-control">{{$anamnesiFisiologica->professione}}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="noteAttLav"
                                                                                               class="control-label col-lg-4">Note:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <textarea id="noteAttLav"
                                                                                                      name="noteAttLav"
                                                                                                      class="form-control">{{$anamnesiFisiologica->noteAttLav}}</textarea>
                                                                                        </div>
                                                                                    </div>
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
                                                                                            <li><input type="submit"
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

                                                                                    <div class="form-group">

                                                                                        <label for="alvo"
                                                                                               class="control-label col-lg-4">Alvo:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <select class="form-control"
                                                                                                    name="alvo"
                                                                                                    id="alvo">
                                                                                                <option @if( $anamnesiFisiologica->alvo == "") value="{{$anamnesiFisiologica->alvo}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->alvo == "regolare") value="{{$anamnesiFisiologica->alvo}}" selected="selected" @endif id="alvoregolare">
                                                                                                    regolare
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->alvo == "stitico") value="{{$anamnesiFisiologica->alvo}}" selected="selected" @endif id="alvostitico">
                                                                                                    stitico
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->alvo == "diarroico") value="{{$anamnesiFisiologica->alvo}}" selected="selected" @endif id="alvodiarroico">
                                                                                                    diarroico
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->alvo == "alterno") value="{{$anamnesiFisiologica->alvo}}" selected="selected" @endif id="alvoalterno">
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
                                                                                                <option @if( $anamnesiFisiologica->minzione == "") value="{{$anamnesiFisiologica->minzione}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->minzione == "nella norma") value="{{$anamnesiFisiologica->minzione}}" selected="selected" @endif id="minzionenellanorma">
                                                                                                    nella norma
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->minzione == "patologica") value="{{$anamnesiFisiologica->minzione}}" selected="selected" @endif id="minzionepatologica">
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
                                                                                                      class="form-control">{{$anamnesiFisiologica->noteAlvoMinz}}</textarea>
                                                                                        </div>
                                                                                    </div>

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


            <!--MODAL EDIT GRAVIDANZE-->
            @foreach($gravidanza as $g)
            <form action="{{ route('Update', ['id' => $g->id_gravidanza]) }}" method="post"
                  class="form-horizontal">
                {{csrf_field()}}
                {{ method_field('PATCH') }}
                <input name="input_name" value="UpdateGravidanze" hidden />
                <input class="form-control hidden" type="text" name="ids[]" value="{{ $g->id_gravidanza }}" disabled>
                <div class="modal fade" tabindex="-1" role="dialog" id="Updategravidanze-{{$g->id_gravidanza}}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Modifica gravidanze</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>



                            <div class="accordion-inner">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="accordion-body">
                                            <br/>

                                            <div class="form-horizontal">
                                                <label class="control-label col-lg-2"
                                                       for="esito">Esito:</label>
                                                <div class="col-lg-4">

                                                    <select class="form-control"
                                                            name="esito"
                                                            id="esito">
                                                        <option @if( $g->esito == "") value="{{$g->esito}}" selected="selected" @else value="" @endif></option>
                                                        <option @if( $g->esito == "Positivo") value="{{$g->esito}}" selected="selected" @else value="Positivo" @endif id="Positivo">
                                                            Positivo
                                                        </option>
                                                        <option @if( $g->esito == "Negativo") value="{{$g->esito}}" selected="selected" @else value="Negativo" @endif id="Negativo">
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
                                                          onblur="isnum(this)">{{$g->eta}}</textarea>
                                                </div>
                                            </div><div class="form-group"></div>
                                            <div class="form-group">
                                                <label for="dataInizioGrav"
                                                       class="control-label col-lg-5">Data
                                                    inizio gravidanza:</label>
                                                <div class="col-lg-6">
                                                    <input type="date"
                                                           name="dataInizioGrav"
                                                           value="{{$g->inizio_gravidanza}}"
                                                           id="datepicker"
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
                                                           value="{{$g->fine_gravidanza}}"
                                                           id="datepicker"
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
                                                        <option @if( $g->sesso_bambino == "") value="{{$g->sesso_bambino}}" selected="selected" @else value="" @endif></option>
                                                        <option @if( $g->sesso_bambino == "Maschio") value="{{$g->sesso_bambino}}" selected="selected" @else value="Maschio" @endif id="Maschile">
                                                            Maschio
                                                        </option>
                                                        <option @if( $g->sesso_bambino == "Femmina") value="{{$g->sesso_bambino}}" selected="selected" @else value="Femmina" @endif id="Femminile">
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
                                                          class="form-control">{{$g->note_gravidanza}}</textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                            <button type="submit" class="btn btn-primary">Modifica</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            @endforeach
            <!--CHIUSURA MODAL EDIT GRAVIDANZE-->

            <!--MODAL DELETE GRAVIDANZE-->
            @foreach($gravidanza as $g)
            <form action="{{ route('Delete', ['id' => $g->id_gravidanza]) }}" method="post"
                  class="form-horizontal">
                {{csrf_field()}}
                {{ method_field('DELETE') }}
                <input name="input_name" value="DeleteGravidanze" hidden />
                <div id="Deletegravidanze-{{$g->id_gravidanza}}" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Eliminare gravidanza</h4>
                            </div>
                            <div class="modal-body">
                                <p>Eliminare gravidanza selezionata?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Elimina</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
            @endforeach
            <!--CHIUSURA MODAL DELETE GRAVIDANZE-->

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
                            <form action="{{ action('AnamnesiController@store') }}" method="post" class="form-horizontal">
                                <input name="input_name" value="icd9groupcodeRemota" hidden />
                                {{csrf_field()}}
                                <div class="modal-body">
                                    <label style="font: bold;">Seleziona uno o pi&#249; gruppi di patologie</label>
                                    @foreach($icd9groupcode as $g)
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="icd9groupcode[]"@foreach($anamnesiPatologicaRemota as $apr)
                                                {{strstr($apr->icd9_group_code, $g->gruppo_descrizione)? "checked": ""}}
                                                @endforeach value="{{$g->gruppo_descrizione}}"> {{$g->gruppo_descrizione}}</label>

                                        </div>
                                    @endforeach
                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button type="submit" onclick="checkprova()" class="btn btn-primary">Salva
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
                            <form action="{{ action('AnamnesiController@store') }}" method="post" class="form-horizontal">
                                <input name="input_name" value="icd9groupcodeProssima" hidden />
                                {{csrf_field()}}
                                <div class="modal-body">
                                    <label style="font: bold;">Seleziona uno o pi&#249; gruppi di patologie</label>
                                    @foreach($icd9groupcode as $g)
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="icd9groupcode[]"@foreach($anamnesiPatologicaProssima as $app)
                                                {{strstr($app->icd9_group_code, $g->gruppo_descrizione)? "checked": ""}}
                                                @endforeach value="{{$g->gruppo_descrizione}}"> {{$g->gruppo_descrizione}}</label>

                                        </div>
                                    @endforeach
                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button type="submit" onclick="checkprovapros()" class="btn btn-primary">Salva
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
                            <form action="{{ action('AnamnesiController@store') }}" method="post" class="form-horizontal" id="modspostainfo">
                                <input name="input_name" value="SpostaPatologicaProssima" hidden />
                                {{csrf_field()}}
                                <div class="modal-body form-gr">
                                    <label style="font: bold;">Modifica</label>
                                    <hr/>
                                    <table class="table">
                                        <tbody>

                                        <textarea class="form-control" id="testosposta" name="testoSposta" cols="44"
                                                  rows="15"
                                                  style="resize:none; border: transparent; overflow-y: visible; height: 100%; max-height: 200px;"></textarea>
                                        </tbody>
                                    </table>
                                    <label style="font: bold;">Seleziona i gruppi di patologie recenti da spostare in
                                        patologie pregresse</label><br>
                                    @foreach($icd9groupcode as $g)
                                        @if(strstr($app->icd9_group_code, $g->gruppo_descrizione))
                                            <input type="checkbox" name="icd9groupcode[]" value="{{$g->gruppo_descrizione}}"> {{$g->gruppo_descrizione}}<br>
                                        @endif
                                    @endforeach
                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="submit" id="btnspostamodal" onclick="checksposta()"
                                            class="btn btn-primary" >Salva
                                    </button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
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
                        $.post(
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
