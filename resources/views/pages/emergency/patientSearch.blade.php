@extends( 'layouts.app' )
@extends( 'includes.template_head' )

@section( 'pageTitle', 'Cerca Paziente' )
@section( 'content' )

<!--PAGE CONTENT -->

<!--PAGE CONTENT -->

<div id="content"> <!--MODCN-->
    <div class="inner" style="min-height:600px;">
        <div class="row">
            <div class="col-lg-8">
                <h2> Cerca paziente <small>versione 1</small></h2>
            </div>
        </div>
        <!------------------------- Versione 1 ----------------------------->
        <form name="cerca_paziente" action="" method="GET">
            <div class="row">
                <div class="col-lg-3 text-center">
                    <button type="submit" class="btn btn-lg btn-primary">Cerca</button>
                    <a href="/search-patient" class="btn btn-sm btn-danger" >Reset</a>
                </div>
                <div class="col-lg-9">
                    <label for="Gender">Sesso</label><br>
                    <div class="form-check form-check-inline radio-inline">
                        <input class="form-check-input" type="radio" name="Gender" id="Gender_M" value="male" {{ $gender === "male" ? "checked" : "" }}>
                        <label class="form-check-label" for="Gender_M">M</label>
                    </div>
                    <div class="form-check form-check-inline radio-inline">
                        <input class="form-check-input" type="radio" name="Gender" id="Gender_F" value="female" {{ $gender === "female" ? "checked" : "" }}>
                        <label class="form-check-label" for="Gender_F">F</label>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <!-- <label for="cognome_paziente">Cognome paziente</label>-->
                        <input type="text" class="form-control" id="cognome_paziente" name="cognome_paziente" aria-describedby="cognomeHelp" value="{{$cognome_paziente}}" placeholder="Inserisci cognome paziente">
                        <!--<small id="cognomeHelp" class="form-text text-muted"></small>-->
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <!--<label for="Nome_paziente">Nome paziente</label>-->
                        <input type="text" class="form-control" id="nome_paziente" name="nome_paziente" aria-describedby="nomeHelp" value="{{$nome_paziente}}" placeholder="Inserisci nome paziente">
                        <!--<small id="nomeHelp" class="form-text text-muted"></small>-->
                    </div>
                </div>
            </div>
        </form>
        <!---------------------------- FINE VERSIONE 1-------------------------------->
        <hr>
        <!-------------------------------- VERSIONE 2--------------------------------->
        <div class="row">
            <div class="col-lg-8">
                <h2> Cerca paziente <small>versione 2</small></h2>
            </div>
        </div>
        <form name="cerca_paziente" action="" method="GET">
            <div class="row align-items-center">
                <div class="col col-lg-4">
                    <div class="form-group">
                        <label for="cognome_paziente">Cognome</label>
                        <input type="text" class="form-control" id="cognome_paziente" name="cognome_paziente" aria-describedby="cognomeHelp" value="{{$cognome_paziente}}">
                        <!--<small id="cognomeHelp" class="form-text text-muted"></small>-->
                    </div>
                </div>
                <div class="col col-lg-4">
                    <div class="form-group">
                        <label for="Nome_paziente">Nome</label>
                        <input type="text" class="form-control" id="nome_paziente" name="nome_paziente" aria-describedby="nomeHelp" value="{{$nome_paziente}}">
                        <!--<small id="nomeHelp" class="form-text text-muted"></small>-->
                    </div>
                </div>
                <div class="col col-lg-2">
                    <label for="Gender">Sesso </label><br>
                    <div class="form-check form-check-inline radio-inline">
                        <input class="form-check-input" type="radio" name="Gender" id="Gender_M" value="male" {{ $gender === "male" ? "checked" : "" }}>
                        <label class="form-check-label" for="Gender_M">M</label>
                    </div>
                    <div class="form-check form-check-inline radio-inline">
                        <input class="form-check-input" type="radio" name="Gender" id="Gender_F" value="female" {{ $gender === "female" ? "checked" : "" }}>
                        <label class="form-check-label" for="Gender_F">F</label>
                    </div>
                </div>
                <div class="col col-lg-2">
                    <a href="/search-patient" class="btn btn-sm btn-danger" >Reset</a>
                    <button type="submit" class="btn btn-lg btn-primary">Cerca</button>
                </div>
            </div>



        </form>
        <!------------------------FINE VERSIONE 2----------------------->
        <div class="row">
            <div class="col-lg-12">
                <div class="box dark">
                    <header>
                        <h2> Elenco Pazienti</h2>
                    </header>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-elencopaz">
                                <thead>
                                <tr>
                                    <th>Registro</th>
                                    <th>Cognome</th>
                                    <th>Nome</th>
                                    <th>Età</th>
                                    <th>Codice Fiscale</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($patients as $patient)
                                    <tr>
                                        <td><button class='btn btn-default btn-success ' type = 'submit' onclick = 'APRIFINESTRA'><i class='icon-check'></i></button></td>
                                        <td>{{$patient->user()->first()->getSurname()}}</td>
                                        <td>{{$patient->user()->first()->getName()}}</td>
                                        <td>{{$patient->getAge()}}</td>
                                        <td>{{$patient->user()->first()->getFiscalCode()}}</td>
                                    </tr>
                                @endforeach
                                @empty($patients)
                                    <p>Nessun paziente presente.</p>
                                @endempty
                                </tbody>
                            </table>
                        </div><!--table-responsive-->
                    </div ><!--body-->
                </div><!--box dark-->
            </div><!--class="col-lg-12-->
        </div><!--class="row"-->
    </div><!--class inner--->
</div><!--nomenu-->



<!-- formscripts/admin.js da modificare con elencoPz.js-->
<!--<script src="formscripts/admin.js"></script>-->
<!-- MODCN -->
<!--<script src="formscripts/modcentercp.js"></script>-->
<!-- Jquery Autocomplete -->
<!--<script src="assets/plugins/autocomplete/typeahead.bundle.js"></script>-->

<!-- Script notifice tooltip -->
<!--<script src="formscripts/elencoPz.js"></script>-->

<!--END PAGE CONTENT -->

<!--END PAGE CONTENT -->

@endsection