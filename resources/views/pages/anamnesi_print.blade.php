<script type="text/javascript">
    $(document).ready(function ( e) {
        $(document).on("click", "#editStampa", function (e) {
            $(':input').removeAttr('disabled');
        })
    })
</script>
<img src="{{url('/img/logo.png')}}"><br>
<form action="{{url('/anamnesiprint')}}" method="post" target="_blank" class="form-horizontal">
    {{csrf_field()}}
        <div class="modal-header">
            <div class="row">
                <div class="col-md-9">
                    <h3 class="modal-title">Anteprima di stampa</h3>
                </div>
                <div class="col-md-3">
                    <button type="submit" id="editStampa" class="btn btn-primary">Stampa</button>
                    <button type="button" name="editStampa" id="editStampa" class="btn btn-success">Modifica</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                </div>

            </div>
        </div>
        <div class="modal-body" style="height:600px;width:97%;position:relative; margin: auto; padding: 10px; overflow-y: scroll">
            <h2>Anamnesi familiare</h2>
            <hr>
            @foreach($anamnesiFamiliare as $aFam)
                <input type="text" name="anamFamiliare" id="anamFamiliare" value="{{$aFam->anamnesi_contenuto}}" size="100" style="border: transparent;" disabled>
            @endforeach

            <br>
            <h3>Anamnesi familiare FHIR</h3>
            @foreach($parente as $p)
                <label>Componente: <input type="text" name="anamComponente{{$p->id_parente}}" value="{{$p->nome}}" size="100" style="border: transparent;" disabled></label>
                <label>Sesso: <input type="text" name="anamSesso{{$p->id_parente}}" value="{{$p->sesso}}" size="100" style="border: transparent;" disabled></label>
                <label>Anni: <input type="text" name="anamEta{{$p->id_parente}}" value="{{$p->età}}" size="100" style="border: transparent;" disabled></label>
                <label>Annotazioni: <input type="text" name="anamAnnotazioni{{$p->id_parente}}" value="{{$p->annotazioni}}" size="100" style="border: transparent;" disabled></label>
                <br><br>
            @endforeach
            <h2>Anamnesi fisiologica</h2>
            <hr>

            <h3>Infanzia</h3>
            @if($anamnesiFisiologica->tempoParto != null) <label>Nato da parto: <input type="text" name="Parto" value="{{$anamnesiFisiologica->tempoParto}}" size="100" style="border: transparent;" disabled></label> @endif
            @if($anamnesiFisiologica->tipoParto != null) <label>Tipo parto: <input type="text" name="tipoParto" value="{{$anamnesiFisiologica->tipoParto}}" size="100" style="border: transparent;" disabled></label> @endif
            @if($anamnesiFisiologica->allattamento != null) <label>Allattamento: <input type="text" name="Allattamento" value="{{$anamnesiFisiologica->allattamento}}" size="100" style="border: transparent;" disabled></label> @endif
            @if($anamnesiFisiologica->sviluppoVegRel != null) <label>Sviluppo vegetativo e relazionale: <input type="text" name="sviluppoVegRel" value="{{$anamnesiFisiologica->sviluppoVegRel}}" size="100" style="border: transparent;" disabled></label> @endif
            @if($anamnesiFisiologica->noteInfanzia != null) <label>Note: <input type="text" name="noteInfanzia" value="{{$anamnesiFisiologica->noteInfanzia}}" size="100" style="border: transparent;" disabled></label> @endif

            <br>
            <h3>Scolarità</h3>
            @if($anamnesiFisiologica->livelloScol != null) <label>Livello scolastico: <input type="text" name="livScol" value="{{$anamnesiFisiologica->livelloScol}}" size="100" style="border: transparent;" disabled></label>@endif

            <br>
            <h3>Stile di vita</h3>
            @if($anamnesiFisiologica->attivitaFisica != null) <label>Attività fisica: <input type="text" name="attivitaFisica" value="{{$anamnesiFisiologica->attivitaFisica}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->abitudAlim != null) <label>Abitudini alimentari: <input type="text" name="abitudAlim" value="{{$anamnesiFisiologica->abitudAlim}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->fumo != null) <label>Fumo: <input type="text" name="fumo" value="{{$anamnesiFisiologica->fumo}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->freqFumo != null) <label>Frequenza fumo: <input type="text" name="freqFumo" value="{{$anamnesiFisiologica->freqFumo}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->alcool != null) <label>Alcool: <input type="text" name="alcool" value="{{$anamnesiFisiologica->alcool}}" size="100" style="border: transparent; " disabled></label>@endif
            @if($anamnesiFisiologica->freqAlcool != null) <label>Frequenza alcool: <input type="text" name="freqAlcool" value="{{$anamnesiFisiologica->freqAlcool}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->droghe != null) <label>Droghe: <input type="text" name="droghe" value="{{$anamnesiFisiologica->droghe}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->freqDroghe != null) <label>Frequenza droghe: <input type="text" name="freqDroghe" value="{{$anamnesiFisiologica->freqDroghe}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->noteStileVita != null) <label>Note: <input type="text" name="noteStileVita" value="{{$anamnesiFisiologica->noteStileVita}}" size="100" style="border: transparent;" disabled></label>@endif

            <br>
            <h3>Attività lavorativa</h3>
            @if($anamnesiFisiologica->professione != null) <label>Professione: <input type="text" name="professione" value="{{$anamnesiFisiologica->professione}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->noteAttLav != null) <label>Note: <input type="text" name="noteAttLav" value="{{$anamnesiFisiologica->noteAttLav}}" size="100" style="border: transparent;" disabled></label>@endif

            <br>
            <h3>Alvo e minzione</h3>
            @if($anamnesiFisiologica->alvo != null) <label>Alvo: <input type="text" name="alvo" value="{{$anamnesiFisiologica->alvo}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->minzione != null) <label>Minzione: <input type="text" name="minzione" value="{{$anamnesiFisiologica->minzione}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->noteAlvoMinz != null) <label>Note: <input type="text" name="noteAlvoMinz" value="{{$anamnesiFisiologica->noteAlvoMinz}}" size="100" style="border: transparent;" disabled></label>@endif

            @if($user->paziente_sesso=="F" or $user->paziente_sesso=="female")
                <br>
                <h3>Ciclo mestruale</h3>
                @if($anamnesiFisiologica->etaMenarca != null) <label>Età menarca: <input type="text" name="etaMenarca" value="{{$anamnesiFisiologica->etaMenarca}}" size="100" style="border: transparent;" disabled></label>@endif
                @if($anamnesiFisiologica->ciclo != null) <label>Ciclo: <input type="text" name="ciclo" value="{{$anamnesiFisiologica->ciclo}}" size="100" style="border: transparent;" disabled></label>@endif
                @if($anamnesiFisiologica->etaMenopausa != null) <label>Età menopausa: <input type="text" name="etaMenopausa" value="{{$anamnesiFisiologica->etaMenopausa}}" size="100" style="border: transparent;" disabled></label>@endif
                @if($anamnesiFisiologica->noteCicloMes != null) <label>Note: <input type="text" name="noteCiclo" value="{{$anamnesiFisiologica->noteCicloMes}}" size="100" style="border: transparent;" disabled></label>@endif

                <br>
                <h3>Gravidanze</h3>
                @foreach($gravidanza as $g)
                    <label>Esito gravidanza: <input type="text" name="esitoGrav{{$g->id_gravidanza}}" value="{{$g->esito}}" size="100" style="border: transparent;" disabled></label>
                    <label>Età gravidanza: <input type="text" name="etaGrav{{$g->id_gravidanza}}" value="{{$g->eta}}" size="100" style="border: transparent;" disabled></label>
                    <label>Inizio gravidanza: <input type="text" name="inizioGrav{{$g->id_gravidanza}}" @if($g->inizio_gravidanza != null) value="{{date('d/m/Y', strtotime($g->inizio_gravidanza))}}" @else value=" " @endif size="100" style="border: transparent;" disabled></label>
                    <label>Fine gravidanza: <input type="text" name="fineGrav{{$g->id_gravidanza}}" @if($g->fine_gravidanza != null) value="{{date('d/m/Y', strtotime($g->fine_gravidanza))}}" @else value=" " @endif size="100" style="border: transparent;" disabled></label>
                    <label>Sesso bambino: <input type="text" name="sessoBambinoGrav{{$g->id_gravidanza}}" value="{{$g->sesso_bambino}}" size="100" style="border: transparent;" disabled></label>
                    <label>Note: <input type="text" name="noteGrav{{$g->id_gravidanza}}" value="{{$g->note_gravidanza}}" size="100" style="border: transparent;" disabled></label>
                    <br><br>
                @endforeach
            @endif

            <br><br>
            <h2>Anamnesi patologica remota</h2>
            <hr>
            @foreach($anamnesiPatologicaRemota as $apr)
                <input type="text" name="anamPatRemota" value="{{$apr->anamnesi_remota_contenuto}}" size="100" style="border: transparent;" disabled>
            @endforeach

            <br><h4>Patologie remote raggruppate per Categorie Diagnostiche (MDC):</h4>
                <textarea name="icd9PatRemota" style="resize:none; border: transparent; overflow-y: scroll; font-size: small; width:100%;" disabled>@foreach($anamnesiPatologicaRemota as $apr){{str_replace("_", ", ", rtrim($apr->icd9_group_code,"_"))}} @endforeach</textarea>

            <br><br>
            <h2>Anamnesi patologica prossima</h2>
            <hr>
            @foreach($anamnesiPatologicaProssima as $app)
                <input type="text" name="anamPatProssima" value="{{$app->anamnesi_prossima_contenuto}}" size="100" style="border: transparent;" disabled>
            @endforeach

            <br><h4>Patologie prossime raggruppate per Categorie Diagnostiche (MDC):</h4>
            <textarea name="icd9PatProssima" style="resize:none; border: transparent; overflow-y: scroll; font-size: small; width:100%;" disabled>@foreach($anamnesiPatologicaProssima as $app){{str_replace("_", ", ", rtrim($app->icd9_group_code,"_"))}} @endforeach</textarea>

        </div>
        <div class="modal-footer"></div>
    </form>





