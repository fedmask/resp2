@include('layouts.cookiescript')
@if(\Illuminate\Support\Facades\Cookie::get('consent') === null ||
\Illuminate\Support\Facades\Cookie::get('consent') === "")


<div id="cookiescript_in"
	style="background-color: rgba(238, 238, 238, 0.5); z-index: 999999; position: fixed; padding: 15px 0px 5px; width: 100%; font-size: 13px; font-weight: normal; text-align: left; letter-spacing: normal; color: rgb(0, 0, 0); font-family: Arial, sans-serif; left: 0px; top: 0px; right: 0px; bottom: 0px;">
	<div id="cookiescript_wrapper"
		style="width: 50%; margin: 0px auto; font-size: 13px; font-weight: normal; text-align: center; color: rgb(0, 0, 0); font-family: Arial, sans-serif; line-height: 18px; letter-spacing: normal; position: relative; top: 50%; transform: translateY(-50%); padding: 20px; background-color: rgb(238, 238, 238); box-shadow: rgb(0, 0, 0) 0px 0px 8px; border-radius: 5px;">

		<h4 id="cookiescript_header"
			style="z-index: 999999; padding: 0px 0px 7px; text-align: center; color: rgb(0, 0, 0); font-family: Arial, sans-serif; display: block; font-size: 15px; font-weight: bold; margin: 0px;">Questo
			sito web utilizza i cookie</h4>


		RESP utilizza i cookie per migliorare la user expirience.
		Accettando i nosti cookie accetti la nostra <a href="/cookies_s">Cookie
			Policy</a></span> <br>
		<div style="width: 100%; text-align: left;">
			<ul>
				<li style="color: black"><span style="font-weight: bold">consent</span>
					- Consente al sistema di memorizzare le informazioni temporali di
					accettzione.</li>
				<li style="color: black"><span style="font-weight: bold">XSRF-TOKEN</span>
					- Il sistema genera automaticamente un "token" CSRF per ogni
					sessione utente attiva gestita dall'applicazione. Questo token
					viene utilizzato per verificare che l'utente autenticato sia quello
					che sta effettivamente effettuando le richieste all'applicazione.</li>
				<li style="color: black"><span style="font-weight: bold">laravel_session</span>
					- le sessioni forniscono un modo per archiviare le informazioni
					sull'utente attraverso le richieste.</li>
				<li style="color: black"><span style="font-weight: bold">Google
						analytics cookies</span> - Google Analytics e' uno strumento
					semplice e di facile utilizzo che aiuta i proprietari di siti web a
					misurare il modo in cui gli utenti interagiscono con i contenuti
					del sito web.</li>
			</ul>
		</div>
		<div id="cookiescript_buttons" onclick="accept();"
			style="margin: 5px auto; font-size: 13px; font-weight: normal; text-align: center; font-family: Arial, sans-serif;">
			<div id="cookiescript_accept"
				style="border-radius: 5px; border: 0px; padding: 6px 10px; font-weight: bold; font-size: 13px; cursor: pointer; margin: 0px 20px 0px 0px; transition: all 0.25s ease 0s; text-shadow: rgb(0, 0, 0) 0px 0px 2px; display: inline-block; background-color: rgb(91, 183, 91); color: rgb(255, 255, 255);">Accetto
			</div>
			<div id="cookiescript_reject" onclick="refuse();"
				style="border-radius: 5px; border: 0px; padding: 6px 10px; font-weight: bold; font-size: 13px; cursor: pointer; margin: 0px 20px 0px 0px; transition: all 0.25s ease 0s; text-shadow: rgb(0, 0, 0) 0px 0px 2px; display: inline-block; background-color: rgb(183, 91, 91); color: rgb(255, 255, 255);">Non
				accetto</div>
			<div id="cookiescript_readmore" onclick="close();"
				style="border-radius: 5px; border: 0px; padding: 6px 10px; font-weight: bold; font-size: 13px; cursor: pointer; margin: 0px 20px 0px 0px; transition: all 0.25s ease 0s; text-shadow: rgb(0, 0, 0) 0px 0px 2px; display: inline-block; background-color: rgb(54, 152, 194); color: rgb(255, 255, 255);">Chiudi
			</div>
			<div style="clear: both"></div>
		</div>

		<div id="cookiescript_pixel"
			style="width: 1px; height: 1px; float: left;"></div>
	</div>
</div>


@endif
