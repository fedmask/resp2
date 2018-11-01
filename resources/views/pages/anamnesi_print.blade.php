@if($printthis == true)
    <img src="{{public_path('/img/logo.png')}}"><br>
@else
    <img src="{{url('/img/logo.png')}}"><br>
@endif
<div style="height:600px;width:97%;position:relative; margin: auto; padding: 10px; overflow-y: scroll">
    <h2>Anamnesi familiare</h2>
    <hr>
    <p style="font-size: 18px;">@foreach($anamnesiFamiliare as $aFam)
            - {{$aFam->anamnesi_contenuto}}
        @endforeach</p>
    <br>
    <h3>Anamnesi familiare FHIR</h3>
    <table style="width: 60%; font-size: 18px;">
        <tr>
            <th>Componente</th>
            <th>Sesso</th>
            <th>Anni</th>
            <th>Annotazioni</th>
        </tr>
        @foreach($parente as $p)
            <tr>
                <td>{{$p->nome}}</td>
                <td>{{$p->sesso}}</td>
                <td>{{$p->età}}</td>
                <td>{{$p->annotazioni}}</td>
            </tr>
        @endforeach
    </table>
    <br><br>
    <h2>Anamnesi fisiologica</h2>
    <hr>

    <h3>Infanzia</h3>
    @if($anamnesiFisiologica->tempoParto != null)<p style="font-size: 18px;"><b>Nato da
            parto: </b>{{$anamnesiFisiologica->tempoParto}}</p>@endif
    @if($anamnesiFisiologica->tipoParto != null)<p style="font-size: 18px;"><b>Tipo
            parto: </b>{{$anamnesiFisiologica->tipoParto}}</p>@endif
    @if($anamnesiFisiologica->allattamento != null)<p style="font-size: 18px;"><b>Allattamento: </b>{{$anamnesiFisiologica->allattamento}}
    </p>@endif
    @if($anamnesiFisiologica->sviluppoVegRel != null)<p style="font-size: 18px;"><b>Sviluppo
            vegetativo e relazionale: </b>{{$anamnesiFisiologica->sviluppoVegRel}}</p>@endif
    @if($anamnesiFisiologica->noteInfanzia != null)<p style="font-size: 18px;">
        <b>Note: </b>{{$anamnesiFisiologica->noteInfanzia}}</p>@endif
    <br>
    <h3>Scolarità</h3>
    @if($anamnesiFisiologica->livelloScol != null)<p style="font-size: 18px;"><b>Livello
            scolastico: </b>{{$anamnesiFisiologica->livelloScol}}</p>@endif
    <br>
    <h3>Stile di vita</h3>
    @if($anamnesiFisiologica->attivitaFisica != null)<p style="font-size: 18px;"><b>Attività
            fisica: </b>{{$anamnesiFisiologica->attivitaFisica}}</p>@endif
    @if($anamnesiFisiologica->abitudAlim != null)<p style="font-size: 18px;"><b>Abitudini
            alimentari: </b>{{$anamnesiFisiologica->abitudAlim}}</p>@endif
    @if($anamnesiFisiologica->fumo != null)<p style="font-size: 18px;">
        <b>Fumo: </b>{{$anamnesiFisiologica->fumo}}</p>@endif
    @if($anamnesiFisiologica->freqFumo != null)<p style="font-size: 18px;"><b>Frequenza
            fumo: </b>{{$anamnesiFisiologica->freqFumo}}</p>@endif
    @if($anamnesiFisiologica->alcool != null)<p style="font-size: 18px;">
        <b>Alcool: </b>{{$anamnesiFisiologica->alcool}}</p>@endif
    @if($anamnesiFisiologica->freqAlcool != null)<p style="font-size: 18px;"><b>Frequenza
            alcool: </b>{{$anamnesiFisiologica->freqAlcool}}</p>@endif
    @if($anamnesiFisiologica->droghe != null)<p style="font-size: 18px;">
        <b>Droghe: </b>{{$anamnesiFisiologica->droghe}}</p>@endif
    @if($anamnesiFisiologica->freqDroghe != null)<p style="font-size: 18px;"><b>Frequenza
            droghe: </b>{{$anamnesiFisiologica->freqDroghe}}</p>@endif
    @if($anamnesiFisiologica->noteStileVita != null)<p style="font-size: 18px;">
        <b>Note: </b>{{$anamnesiFisiologica->noteStileVita}}</p>@endif
    <br>
    <h3>Ciclo mestruale</h3>
    @if($anamnesiFisiologica->etaMenarca != null)<p style="font-size: 18px;"><b>Età
            menarca: </b>{{$anamnesiFisiologica->etaMenarca}}</p>@endif
    @if($anamnesiFisiologica->ciclo != null)<p style="font-size: 18px;">
        <b>Ciclo: </b>{{$anamnesiFisiologica->ciclo}}</p>@endif
    @if($anamnesiFisiologica->etaMenopausa != null)<p style="font-size: 18px;"><b>Età
            menopausa: </b>{{$anamnesiFisiologica->etaMenopausa}}</p>@endif
    @if($anamnesiFisiologica->noteCicloMes != null)<p style="font-size: 18px;">
        <b>Note: </b>{{$anamnesiFisiologica->noteCicloMes}}</p>@endif
    <br>
    <h3>Gravidanze</h3>
    @foreach($gravidanza as $g)
        @if($g->esito != null)<p style="font-size: 18px;"><b>Esito
                gravidanza: </b>{{$g->esito}}</p>@endif
        @if($g->eta != null)<p style="font-size: 18px;"><b>Età gravidanza: </b>{{$g->eta}}
        </p>@endif
        @if($g->inizio_gravidanza != null)<p style="font-size: 18px;"><b>Inizio
                gravidanza: </b>{{date('d/m/Y', strtotime($g->inizio_gravidanza))}}</p>@endif
        @if($g->fine_gravidanza != null)<p style="font-size: 18px;"><b>Fine
                gravidanza: </b>{{date('d/m/Y', strtotime($g->fine_gravidanza))}}</p>@endif
        @if($g->sesso_bambino != null)<p style="font-size: 18px;"><b>Sesso
                bambino: </b>{{$g->sesso_bambino}}</p>@endif
        @if($g->note_gravidanza != null)<p style="font-size: 18px;">
            <b>Note: </b>{{$g->note_gravidanza}}</p>@endif
<br>
    @endforeach
    <br>
    <h3>Attività lavorativa</h3>
    @if($anamnesiFisiologica->professione != null)<p style="font-size: 18px;"><b>Attività
            lavorativa: </b>{{$anamnesiFisiologica->professione}}</p>@endif
    @if($anamnesiFisiologica->noteAttLav != null)<p style="font-size: 18px;">
        <b>Note: </b>{{$anamnesiFisiologica->noteAttLav}}</p>@endif
    <br>
    <h3>Alvo e minzione</h3>
    @if($anamnesiFisiologica->alvo != null)<p style="font-size: 18px;">
        <b>Alvo: </b>{{$anamnesiFisiologica->alvo}}</p>@endif
    @if($anamnesiFisiologica->minzione != null)<p style="font-size: 18px;">
        <b>Minzione: </b>{{$anamnesiFisiologica->minzione}}</p>@endif
    @if($anamnesiFisiologica->noteAlvoMinz != null)<p style="font-size: 18px;">
        <b>Note: </b>{{$anamnesiFisiologica->noteAlvoMinz}}</p>@endif
    <br><br>
    <h2>Anamnesi patologica remota</h2>
    <hr>
    <p style="font-size: 18px;">@foreach($anamnesiPatologicaRemota as $apr)
            - {{$apr->anamsi_remota_contenuto}}@endforeach</p>
    <br><h4>Patologie remote raggruppate per Categorie Diagnostiche (MDC):</h4>
    <p style="font-size: 16px;">@foreach($anamnesiPatologicaRemota as $apr)
            @if($apr->icd9_group_code != null)- {!! str_replace("_", "." . "<br>" . "- ", rtrim($apr->icd9_group_code, "_")) . "." !!}@endif @endforeach</p>
    <br><br>
    <h2>Anamnesi patologica prossima</h2>
    <hr>
    <p style="font-size: 18px;">@foreach($anamnesiPatologicaProssima as $app)
            - {{$app->anamsi_prossima_contenuto}}@endforeach</p>
    <br><h4>Patologie prossime raggruppate per Categorie Diagnostiche (MDC):</h4>
    <p style="font-size: 16px;">@foreach($anamnesiPatologicaProssima as $app)
            @if($app->icd9_group_code != null)- {!! str_replace("_", "." . "<br>" . "- ", rtrim($app->icd9_group_code, "_")) . "." !!}@endif @endforeach</p>
</div>
