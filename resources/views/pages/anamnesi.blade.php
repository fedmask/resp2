@extends( 'layouts.app' )
@extends( 'includes.template_head' )
@section( 'pageTitle', 'Anamnesi' )
@section( 'content' )

    <script type="text/javascript" src="{{ asset('js/formscripts/anamnesi.js') }}"></script>
    <div id="content">
        <div class="inner">
            <div class="row">
                <div class="col-lg-8">
                    <h2> Anamnesi </h2>
                </div>
            </div>
            <hr>
            <div class="row">
                <!-- TABELLA RELATIVA ALL'ANAMNESI FAMILIARE-->
                <div class="col-md-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <center><h4>Familiare </h4></center>
                            <!--bottoni per la gestione delle modifiche-->
                            <div class="btn-group" style="text-align: left;">
                                <a id="buttonUpdateFam" class="btn btn-success btn-sm btn-line"><i
                                            class="icon-pencil icon-white"></i>Aggiorna</a>
                                <!--sostituir� il successivo aggiorna-->

                                <!----	<a id="buttonHiddenfam" class="btn btn-success btn-sm btn-line"><i class="icon-pencil icon-white"></i>Aggiorna</a> -->
                                <a type="submit" class="btn btn-info btn-sm" id="buttonCodiciFam" style="display: none;"
                                   data-toggle="modal" data-target="#table_update_anamnesifam"><i class="icon-flag"></i>
                                    Codifica</a>

                                <a type="submit" class="btn btn-warning btn-sm" id="btn_salvafam"
                                   style="display: none;"><i class="icon-save"></i>Salva</a>
                                <!--buttonAnnullaFam--	<a class="btn btn-danger btn-sm" id="btn_annullafam" style="display: none;"><i class="icon-trash"></i> Annulla</a> -->
                                <a class="btn btn-danger btn-sm" id="buttonAnnullaFam" style="display: none;"><i
                                            class="icon-trash"></i> Annulla</a>
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
                                        <textarea class="col-md-12" id="testofam" name="testofam" cols="44" rows="10"
                                                  readonly="true"
                                                  style="resize:none; border: transparent; overflow-y: scroll; max-height: 200px;"
                                                  placeholder="qui puoi inserire il tuo testo..."> </textarea>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!--bottone che permette le modifiche ANAMNESI FAMILIARE-->
                        <div class="panel-footer" style="text-align:right;">
                        </div>
                    </div>
                </div><!--CHIUSURA ANAMNESI FAMILIARE-->

                <!-- TABELLA RELATIVA ALL'ANAMNESI FISIOLOGICA -->
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <center><h4>Fisiologica</h4></center>
                            <div class="btn-group" style="text-align: left;">
                                <a id="btnfisio" class="btn btn-primary btn-sm btn-line" data-toggle="modal"
                                        data-target="#modanamnesifis"><i class="icon-pencil icon-white"></i> Aggiorna
                                </a>
                                <button class="btn btn-success btn-sm" style="visibility: hidden;"></i>Salva</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table>">
                                    <thead>
                                    <tr></tr>
                                    </thead>


                                    <tbody>
                                    <tr>
                                           <textarea class="col-md-12" id="testofam" name="testofam" cols="44" rows="10"
                                                     readonly="true"
                                                     style="resize:none; border: transparent; overflow-y: scroll; max-height: 200px;">

                                           </textarea>
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
            </div>
            <div class="row">

                <!-- TABELLA RELATIVA ALL'ANAMNESI PATOLOGICA REMOTA-->
                <div class="col-md-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <center><h4>Patologica remota</h4></center>
                            <div class="btn-group" style="text-align: left;">
                                <!--bottoni per la gestione delle modifiche-->
                                <a type="submit" class="btn btn-success btn-sm" id="btn_salvapatrem"
                                   style="display: none;"><i class="icon-save"></i>Salva</a>
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
                                        <textarea onclick="textAreaAdjust(this)" class="col-md-12" id="testopatmod"
                                                  name="testopatmod" cols="44" rows="5" readonly="readonly"
                                                  style="resize:none; border: transparent; overflow-y: scroll; font-size: small; height: 20%;">

                                        </textarea>
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
                                            class="icon-hand-left"></i> Sposta
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
                                   <textarea class="col-md-12" id="testopatpp" name="testopatpp" cols="44" rows="10"
                                             readonly="true"
                                             style="resize:none; border: transparent; overflow-y: scroll; max-height: 200px;">


                                   </textarea>
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
                                   <textarea onclick="//TODO" class="col-md-12" id="testopatmodrec"
                                             name="testopatmodrec" cols="44" rows="5" readonly="readonly"
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

        </div><!--div inner-->
    </div><!--div content-->
@endsection
