@include('layouts.cookiescript')
@if(\Illuminate\Support\Facades\Cookie::get('consent') === null || \Illuminate\Support\Facades\Cookie::get('consent') === "")
<div id="cookies" style="position: fixed;bottom: 0;width: 100%;/*height: 50%;*/background: rgba(0,0,0,0.5);z-index: 99999;padding: 1%; max-height:100%; overflow: auto;" class="container-fluid">
    <div class="row" style="padding:5%">
        <h1 style="color:white" class="text-center">Noi utilizziamo i cookie.</h1>
        <h2  style="color:white">Se accetti i cookie utilizzerai i seguenti:</h2>
        <ul>
            <li  style="color:white"><span style="font-weight: bold">consent</span> - Consente al sistema di memorizzare le informazioni temporali di accettzione.</li>
            <li  style="color:white"><span style="font-weight: bold">XSRF-TOKEN</span> - Il sistema genera automaticamente un "token" CSRF per ogni sessione utente attiva gestita dall'applicazione. Questo token viene utilizzato per verificare che l'utente autenticato sia quello che sta effettivamente effettuando le richieste all'applicazione.</li>
            <li  style="color:white"><span style="font-weight: bold">laravel_session</span> - le sessioni forniscono un modo per archiviare le informazioni sull'utente attraverso le richieste.</li>
            <li  style="color:white"><span style="font-weight: bold">Google analytics cookies</span> - Google Analytics e' uno strumento semplice e di facile utilizzo che aiuta i proprietari di siti web a misurare il modo in cui gli utenti interagiscono con i contenuti del sito web.</li>
        </ul>
        <p style="font-weight: bold;color:white">Puoi sempre cambiare idea accedendo alla nostra pagina <a href="/cookies_s">cookies</a>.</p>
        <table style="margin: auto">
            <tr>
                <td><button class="btn btn-info" onclick="accept()">Accetto</button></td>
                <td><button class="btn btn-danger" onclick="refuse()">Non accetto</button></td>
            </tr>
        </table>
    </div>
</div>
@endif