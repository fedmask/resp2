<script type="text/javascript">
    $(document).ready(function ( e) {
        $(document).on("click", "#editPrint", function (e) {
            $(':input').attr("disabled", false);

        })
    });

</script>

<script>
    function cancel() {
        if (confirm('Sei sicuro di annullare le modifiche effettuate in precedenza? Tutte le modifiche andranno perse!')) {

            @foreach($anamnesiFamiliare as $aFam)
                @if($aFam->anamnesi_contenuto != null)
                    document.getElementById('anamFamiliare').value = "{!! $aFam->anamnesi_contenuto !!}";
                @endif
            @endforeach

            @foreach($parente as $p)
                @if($p->nome != null)
                    document.getElementById("anamComponente" + "{!! $p->id_parente !!}").value = "{!! $p->nome !!}";
                @endif
                @if($p->sesso)
                    document.getElementById("anamSesso" + "{!! $p->id_parente !!}").value = "{!! $p->sesso !!}";
                @endif
                @if($p->età)
                    document.getElementById("anamEta" + "{!! $p->id_parente !!}").value = "{!! $p->età !!}";
                @endif
                @if($p->annotazioni)
                    document.getElementById("anamAnnotazioni" + "{!! $p->id_parente !!}").value = "{!! $p->annotazioni !!}";
                @endif
            @endforeach

            @if($anamnesiFisiologica->tempoParto!= null)
                document.getElementById("Parto").value = "{!! $anamnesiFisiologica->tempoParto !!}";
            @endif
            @if($anamnesiFisiologica->tipoParto != null)
                document.getElementById("tipoParto").value = "{!! $anamnesiFisiologica->tipoParto !!}";
            @endif
            @if($anamnesiFisiologica->allattamento != null)
                document.getElementById("Allattamento").value = "{!! $anamnesiFisiologica->allattamento !!}";
            @endif
            @if($anamnesiFisiologica->sviluppoVegRel !=null)
                document.getElementById("sviluppoVegRel").value = "{!! $anamnesiFisiologica->sviluppoVegRel !!}";
            @endif
            @if($anamnesiFisiologica->noteInfanzia != null)
                document.getElementById("noteInfanzia").value = "{!! $anamnesiFisiologica->noteInfanzia !!}";
            @endif
            @if($anamnesiFisiologica->livelloScol != null)
                document.getElementById("livScol").value = "{!! $anamnesiFisiologica->livelloScol !!}";
            @endif
            @if($anamnesiFisiologica->attivitaFisica != null)
                document.getElementById("attivitaFisica").value = "{!! $anamnesiFisiologica->attivitaFisica !!}";
            @endif
            @if($anamnesiFisiologica->abitudAlim != null)
                document.getElementById("abitudAlim").value = "{!! $anamnesiFisiologica->abitudAlim !!}";
            @endif
            @if($anamnesiFisiologica->fumo != null)
                document.getElementById("fumo").value = "{!! $anamnesiFisiologica->fumo !!}";
            @endif
            @if($anamnesiFisiologica->freqFumo != null)
                document.getElementById("freqFumo").value = "{!! $anamnesiFisiologica->freqFumo !!}";
            @endif
            @if($anamnesiFisiologica->alcool != null)
                document.getElementById("alcool").value = "{!! $anamnesiFisiologica->alcool !!}";
            @endif
            @if($anamnesiFisiologica->freqAlcool != null)
                document.getElementById("freqAlcool").value = "{!! $anamnesiFisiologica->freqAlcool !!}";
            @endif
            @if($anamnesiFisiologica->droghe != null)
                document.getElementById("droghe").value = "{!! $anamnesiFisiologica->droghe !!}";
            @endif
            @if($anamnesiFisiologica->freqDroghe != null)
                document.getElementById("freqDroghe").value = "{!! $anamnesiFisiologica->freqDroghe !!}";
            @endif
            @if($anamnesiFisiologica->noteStileVita != null)
                document.getElementById("noteStileVita").value = "{!! $anamnesiFisiologica->noteStileVita !!}";
            @endif
            @if($anamnesiFisiologica->professione != null)
                document.getElementById("professione").value = "{!! $anamnesiFisiologica->professione !!}";
            @endif
            @if($anamnesiFisiologica->noteAttLav != null)
                document.getElementById("noteAttLav").value = "{!! $anamnesiFisiologica->noteAttLav !!}";
            @endif
            @if($anamnesiFisiologica->alvo != null)
                document.getElementById("alvo").value = "{!! $anamnesiFisiologica->alvo !!}";
            @endif
            @if($anamnesiFisiologica->minzione != null)
                document.getElementById("minzione").value = "{!! $anamnesiFisiologica->minzione !!}";
            @endif
            @if($anamnesiFisiologica->noteAlvoMinz != null)
                document.getElementById("noteAlvoMinz").value = "{!! $anamnesiFisiologica->noteAlvoMinz !!}";
            @endif
            @if($anamnesiFisiologica->etaMenarca != null)
                document.getElementById("etaMenarca").value = "{!! $anamnesiFisiologica->etaMenarca !!}";
            @endif
            @if($anamnesiFisiologica->ciclo != null)
                document.getElementById("ciclo").value = "{!! $anamnesiFisiologica->ciclo !!}";
            @endif
            @if($anamnesiFisiologica->etaMenopausa != null)
                document.getElementById("etaMenopausa").value = "{!! $anamnesiFisiologica->etaMenopausa !!}";
            @endif
            @if($anamnesiFisiologica->menopausa != null)
                document.getElementById("menopausa").value = "{!! $anamnesiFisiologica->menopausa !!}";
            @endif
            @if($anamnesiFisiologica->noteCicloMes != null)
                document.getElementById("noteCiclo").value = "{!! $anamnesiFisiologica->noteCicloMes !!}";
            @endif


            @foreach($gravidanza as $g)
                @if($g->esito != null)
                    document.getElementById("esitoGrav" + "{!! $g->id_gravidanza !!}").value = "{!! $g->esito !!}";
                @endif
                @if($g->eta != null)
                    document.getElementById("etaGrav" + "{!! $g->id_gravidanza !!}").value = "{!! $g->eta !!}";
                @endif
                @if($g->inizio_gravidanza != null)
                    document.getElementById("inizioGrav" + "{!! $g->id_gravidanza !!}").value = "{!! date('d/m/Y', strtotime($g->inizio_gravidanza)) !!}";
                @endif
                @if($g->fine_gravidanza != null)
                    document.getElementById("fineGrav" + "{!! $g->id_gravidanza !!}").value = "{!! date('d/m/Y', strtotime($g->fine_gravidanza)) !!}";
                @endif
                @if($g->sesso_bambino != null)
                    document.getElementById("sessoBambinoGrav" + "{!! $g->id_gravidanza !!}").value = "{!! $g->sesso_bambino !!}";
                @endif
                @if($g->note_gravidanza != null)
                    document.getElementById("noteGrav" + "{!! $g->id_gravidanza !!}").value = "{!! $g->note_gravidanza !!}";
                @endif
            @endforeach

            @foreach($anamnesiPatologicaRemota as $apr)
                    @if($apr->anamnesi_remota_contenuto != null)
                        document.getElementById("anamPatRemota").value = "{!! $apr->anamnesi_remota_contenuto !!}";
                    @endif
            @endforeach

            @foreach($anamnesiPatologicaRemota as $apr)
                @if($apr->icd9_group_code != null)
                    document.getElementById("icd9PatRemota").value = "{!! str_replace("_", ", ", rtrim($apr->icd9_group_code,"_")) !!}";
                @endif
            @endforeach

            @foreach($anamnesiPatologicaProssima as $app)
                @if($app->anamnesi_prossima_contenuto != null)
                    document.getElementById("anamPatProssima").value = "{!! $app->anamnesi_prossima_contenuto !!}";
                @endif
            @endforeach

            @foreach($anamnesiPatologicaProssima as $app)
                @if($app->icd9_group_code != null)
                    document.getElementById("icd9PatProssima").value = "{!! str_replace("_", ", ", rtrim($app->icd9_group_code,"_")) !!}";
                @endif
            @endforeach
        }
    }
</script>
<div class="modal-header">
    <img src="{{url('/img/logo.png')}}">

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="{{url('/anamnesiprint')}}" method="post" target="_blank" class="form-horizontal">
    {{csrf_field()}}
        <div class="modal-header">
            <div class="row">
                <div class="col-md-9">
                    <br>
                    <h3 class="modal-title">Anteprima di stampa</h3>

                </div>
                <br>
                <div class="col-md-3">

                    <button type="submit" id="editPrint" class="btn btn-primary" >Stampa</button>
                    <button type="button" name="editPrint" id="editPrint" class="btn btn-success">Modifica</button>
                    <button type="button" name="cancelPrint" id="cancelPrint" onclick="cancel()" class="btn btn-default" >Annulla</button>
                </div>

            </div>
        </div>
        @if($user->paziente_sesso == "female" or $user->paziente_sesso == "F")
            <div class="col-md-6"><br><h1> Sig.ra {{$user->paziente_nome}} {{$user->paziente_cognome}}</h1></div>
        @else
        <div class="col-md-6"><br><h1> Sig. {{$user->paziente_nome}} {{$user->paziente_cognome}}</h1></div>
        @endif
        <div class="modal-body" style="height:600px;width:97%;position:relative; margin: auto; padding: 10px; overflow-y: scroll">
            <h2>Anamnesi familiare</h2>
            <hr>
            @foreach($anamnesiFamiliare as $aFam)
                <input type="text" name="anamFamiliare" id="anamFamiliare" value="{{$aFam->anamnesi_contenuto}}" size="100" style="border: transparent;" disabled>
            @endforeach

            <br>

            <h3>Anamnesi familiare FHIR</h3>
            @foreach($parente as $p)
                <label>Componente: <input type="text" name="anamComponente{{$p->id_parente}}" id="anamComponente{{$p->id_parente}}" value="{{$p->nome}}" size="100" style="border: transparent;" disabled></label>
                <label>Sesso: <input type="text" name="anamSesso{{$p->id_parente}}" id="anamSesso{{$p->id_parente}}" value="{{$p->sesso}}" size="100" style="border: transparent;" disabled></label>
                <label>Anni: <input type="text" name="anamEta{{$p->id_parente}}" id="anamEta{{$p->id_parente}}" value="{{$p->età}}" size="100" style="border: transparent;" disabled></label>
                <label>Annotazioni: <input type="text" name="anamAnnotazioni{{$p->id_parente}}" id="anamAnnotazioni{{$p->id_parente}}" value="{{$p->annotazioni}}" size="100" style="border: transparent;" disabled></label>
                <br><br>
            @endforeach
            <h2>Anamnesi fisiologica</h2>
            <hr>
            @if($anamnesiFisiologica->tempoParto != null or $anamnesiFisiologica->tipoParto != null or $anamnesiFisiologica->allattamento != null or $anamnesiFisiologica->sviluppoVegRel != null or $anamnesiFisiologica->noteInfanzia != null)
                <h3>Infanzia</h3>
            @endif
            @if($anamnesiFisiologica->tempoParto != null) <label>Nato da parto: <input type="text" name="Parto" id="Parto" value="{{$anamnesiFisiologica->tempoParto}}" size="100" style="border: transparent;" disabled></label> @endif
            @if($anamnesiFisiologica->tipoParto != null) <label>Tipo parto: <input type="text" name="tipoParto" id="tipoParto" value="{{$anamnesiFisiologica->tipoParto}}" size="100" style="border: transparent;" disabled></label> @endif
            @if($anamnesiFisiologica->allattamento != null) <label>Allattamento: <input type="text" name="Allattamento" id="Allattamento" value="{{$anamnesiFisiologica->allattamento}}" size="100" style="border: transparent;" disabled></label> @endif
            @if($anamnesiFisiologica->sviluppoVegRel != null) <label>Sviluppo vegetativo e relazionale: <input type="text" name="sviluppoVegRel" id="sviluppoVegRel" value="{{$anamnesiFisiologica->sviluppoVegRel}}" size="100" style="border: transparent;" disabled></label> @endif
            @if($anamnesiFisiologica->noteInfanzia != null) <label>Note: <input type="text" name="noteInfanzia" id="noteInfanzia" value="{{$anamnesiFisiologica->noteInfanzia}}" size="100" style="border: transparent;" disabled></label> <br>@endif


            @if($anamnesiFisiologica->livelloScol != null)
                <h3>Scolarità</h3>
            @endif
            @if($anamnesiFisiologica->livelloScol != null) <label>Livello scolastico: <input type="text" name="livScol" id="livScol" value="{{$anamnesiFisiologica->livelloScol}}" size="100" style="border: transparent;" disabled></label>@endif

            @if($anamnesiFisiologica->attivitaFisica != null or $anamnesiFisiologica->abitudAlim != null or $anamnesiFisiologica->fumo != null or $anamnesiFisiologica->freqFumo != null or $anamnesiFisiologica->alcool != null or $anamnesiFisiologica->freqAlcool != null or $anamnesiFisiologica->droghe != null or $anamnesiFisiologica->freqDroghe != null or $anamnesiFisiologica->noteStileVita != null)
                <h3>Stile di vita</h3>
            @endif
            @if($anamnesiFisiologica->attivitaFisica != null) <label>Attività fisica: <input type="text" name="attivitaFisica" id="attivitaFisica" value="{{$anamnesiFisiologica->attivitaFisica}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->abitudAlim != null) <label>Abitudini alimentari: <input type="text" name="abitudAlim" id="abitudAlim" value="{{$anamnesiFisiologica->abitudAlim}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->fumo != null) <label>Fumo: <input type="text" name="fumo" id="fumo" value="{{$anamnesiFisiologica->fumo}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->freqFumo != null) <label>Frequenza fumo: <input type="text" name="freqFumo" id="freqFumo" value="{{$anamnesiFisiologica->freqFumo}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->alcool != null) <label>Alcool: <input type="text" name="alcool" id="alcool" value="{{$anamnesiFisiologica->alcool}}" size="100" style="border: transparent; " disabled></label>@endif
            @if($anamnesiFisiologica->freqAlcool != null) <label>Frequenza alcool: <input type="text" name="freqAlcool" id="freqAlcool" value="{{$anamnesiFisiologica->freqAlcool}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->droghe != null) <label>Droghe: <input type="text" name="droghe" id="droghe" value="{{$anamnesiFisiologica->droghe}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->freqDroghe != null) <label>Frequenza droghe: <input type="text" name="freqDroghe" id="freqDroghe" value="{{$anamnesiFisiologica->freqDroghe}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->noteStileVita != null) <label>Note: <input type="text" name="noteStileVita" id="noteStileVita" value="{{$anamnesiFisiologica->noteStileVita}}" size="100" style="border: transparent;" disabled></label>@endif

            @if($anamnesiFisiologica->professione or $anamnesiFisiologica->noteAttLav)
                <h3>Attività lavorativa</h3>
            @endif
            @if($anamnesiFisiologica->professione != null) <label>Professione: <input type="text" name="professione" id="professione" value="{{$anamnesiFisiologica->professione}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->noteAttLav != null) <label>Note: <input type="text" name="noteAttLav" id="noteAttLav" value="{{$anamnesiFisiologica->noteAttLav}}" size="100" style="border: transparent;" disabled></label>@endif

            @if($anamnesiFisiologica->alvo or $anamnesiFisiologica->minzione or $anamnesiFisiologica->noteAlvoMinz)
                <h3>Alvo e minzione</h3>
            @endif
            @if($anamnesiFisiologica->alvo != null) <label>Alvo: <input type="text" name="alvo" id="alvo" value="{{$anamnesiFisiologica->alvo}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->minzione != null) <label>Minzione: <input type="text" name="minzione" id="minzione" value="{{$anamnesiFisiologica->minzione}}" size="100" style="border: transparent;" disabled></label>@endif
            @if($anamnesiFisiologica->noteAlvoMinz != null) <label>Note: <input type="text" name="noteAlvoMinz" id="noteAlvoMinz" value="{{$anamnesiFisiologica->noteAlvoMinz}}" size="100" style="border: transparent;" disabled></label>@endif

            @if($user->paziente_sesso=="F" or $user->paziente_sesso=="female")

                @if($anamnesiFisiologica->etaMenarca != null or $anamnesiFisiologica->ciclo or $anamnesiFisiologica->etaMenopausa or $anamnesiFisiologica->menopausa or $anamnesiFisiologica->noteCicloMes)
                    <h3>Ciclo mestruale</h3>
                @endif
                @if($anamnesiFisiologica->etaMenarca != null) <label>Età menarca: <input type="text" name="etaMenarca" id="etaMenarca" value="{{$anamnesiFisiologica->etaMenarca}}" size="100" style="border: transparent;" disabled></label>@endif
                @if($anamnesiFisiologica->ciclo != null) <label>Ciclo: <input type="text" name="ciclo" id="ciclo" value="{{$anamnesiFisiologica->ciclo}}" size="100" style="border: transparent;" disabled></label>@endif
                @if($anamnesiFisiologica->etaMenopausa != null) <label>Età menopausa: <input type="text" name="etaMenopausa" id="etaMenopausa" value="{{$anamnesiFisiologica->etaMenopausa}}" size="100" style="border: transparent;" disabled></label>@endif
                @if($anamnesiFisiologica->menopausa != null) <label>Menopausa: <input type="text" name="menopausa" id="menopausa" value="{{$anamnesiFisiologica->menopausa}}" size="100" style="border: transparent;" disabled></label>@endif
                @if($anamnesiFisiologica->noteCicloMes != null) <label>Note: <input type="text" name="noteCiclo" id="noteCiclo" value="{{$anamnesiFisiologica->noteCicloMes}}" size="100" style="border: transparent;" disabled></label>@endif

                <h3>Gravidanze</h3>
                @foreach($gravidanza as $g)
                    <label>Esito gravidanza: <input type="text" name="esitoGrav{{$g->id_gravidanza}}" id="esitoGrav{{$g->id_gravidanza}}" value="{{$g->esito}}" size="100" style="border: transparent;" disabled></label>
                    <label>Età gravidanza: <input type="text" name="etaGrav{{$g->id_gravidanza}}" id="etaGrav{{$g->id_gravidanza}}" value="{{$g->eta}}" size="100" style="border: transparent;" disabled></label>
                    <label>Inizio gravidanza: <input type="text" name="inizioGrav{{$g->id_gravidanza}}" id="inizioGrav{{$g->id_gravidanza}}" @if($g->inizio_gravidanza != null) value="{{date('d/m/Y', strtotime($g->inizio_gravidanza))}}" @else value=" " @endif size="100" style="border: transparent;" disabled></label>
                    <label>Fine gravidanza: <input type="text" name="fineGrav{{$g->id_gravidanza}}" id="fineGrav{{$g->id_gravidanza}}" @if($g->fine_gravidanza != null) value="{{date('d/m/Y', strtotime($g->fine_gravidanza))}}" @else value=" " @endif size="100" style="border: transparent;" disabled></label>
                    <label>Sesso bambino: <input type="text" name="sessoBambinoGrav{{$g->id_gravidanza}}" id="sessoBambinoGrav{{$g->id_gravidanza}}" value="{{$g->sesso_bambino}}" size="100" style="border: transparent;" disabled></label>
                    <label>Note: <input type="text" name="noteGrav{{$g->id_gravidanza}}" id="noteGrav{{$g->id_gravidanza}}" value="{{$g->note_gravidanza}}" size="100" style="border: transparent;" disabled></label>
                    <br><br>
                @endforeach
            @endif

            <br><br>
            <h2>Anamnesi patologica remota</h2>
            <hr>
            @foreach($anamnesiPatologicaRemota as $apr)
                <input type="text" name="anamPatRemota" id="anamPatRemota" value="{{$apr->anamnesi_remota_contenuto}}" size="100" style="border: transparent;" disabled>
            @endforeach

            <br><h4>Patologie remote raggruppate per Categorie Diagnostiche (MDC):</h4>
                <textarea name="icd9PatRemota" id="icd9PatRemota" style="resize:none; border: transparent; overflow-y: scroll; font-size: small; width:100%;" disabled>@foreach($anamnesiPatologicaRemota as $apr){{str_replace("_", ", ", rtrim($apr->icd9_group_code,"_"))}} @endforeach</textarea>

            <br><br>
            <h2>Anamnesi patologica prossima</h2>
            <hr>
            @foreach($anamnesiPatologicaProssima as $app)
                <input type="text" name="anamPatProssima" id="anamPatProssima" value="{{$app->anamnesi_prossima_contenuto}}" size="100" style="border: transparent;" disabled>
            @endforeach

            <br><h4>Patologie prossime raggruppate per Categorie Diagnostiche (MDC):</h4>
            <textarea name="icd9PatProssima" id="icd9PatProssima" style="resize:none; border: transparent; overflow-y: scroll; font-size: small; width:100%;" disabled>@foreach($anamnesiPatologicaProssima as $app){{str_replace("_", ", ", rtrim($app->icd9_group_code,"_"))}} @endforeach</textarea>

        </div>
        <div class="modal-footer"></div>
    </form>





