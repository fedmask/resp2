# GUIDA PER L&#39;INSTALLAZIONE E LA CONFIGURAZIONE DI LARAVEL-RESP

(USANDO LARAVEL HOMESTEAD)

Nota: La seguente guida d'installazione per lo sviluppo di RESP in locale è da intendersi per utenti Windows. Per lo sviluppo in MacOS o Linux i passi da seguire sono analoghi ma potrebbero subire qualche variazione. Gli utenti MacOS, potrebbero inoltre valutare l'utilizzo di Valet al posto della Vagrant Box Homestead.


## Software richiesti:

- Un ambiente di sviluppo come EASYPHP, XAMPP o WAMP che abbia PHP 7.0 o superiore
- Composer ( [https://getcomposer.org/download/](https://getcomposer.org/download/)) Nota: specificare in fase di installazione la directory in cui si trova il file php.exe ovvero la directory di installazione di PHP 7.0 o superiore
- Git ( [https://git-scm.com/download/win](https://git-scm.com/download/win)) - Ovviamente ci sarà bisogno di settare username, email e password, ma per questo si rimanda ad ad altri fonti disponibili in rete.
- Oracle VirtualBox ( [https://www.virtualbox.org/wiki/Downloads](https://www.virtualbox.org/wiki/Downloads))
- Vagrant ( [https://www.vagrantup.com/downloads.html](https://www.vagrantup.com/downloads.html))

Inoltre è essenziale che sia abilitato l'hardware virtualization (VT-x). In molti computer è abilitato di default, in altri bisogna attivarlo dal BIOS.

## Installazione
Una volta scaricati tutti i software richiesti procedere con i seguenti passi:

- Creare una cartella denominata Laravel, la quale andrà a contenere in una cartella la Vagrant Box di Homestead ed in un&#39;altra il codice effettivo della web application.
- Aprire il terminale e digitare il comando ```vagrant box add laravel/homestead``` al prompt che verrà richiesto digitare il numero corrispondente alla voce Virtualbox (l&#39;operazione potrebbe richiedere vari minuti).
- Aprire il terminale Git Bash e tramite il comando ```cd``` spostare la working directory alla directory Laravel precedentemente creata (ricordarsi che in Git Bash i percorsi utilizzano &#39;/&#39; come separatore);  digitare il comando ```git clone https://github.com/laravel/homestead.git Homestead```
- All&#39;interno della cartella Laravel se ne dovrebbe ora avere una nuova denominata Homestead, aprirla e tenendo premuto il tasto Maiusc cliccare con il tasto destro del mouse e selezionare &quot;Apri finestra terminale qui&quot;; nella finestra terminale inserire il comando ```.\init.bat```

Con questi passi l&#39;installazione di Homestead è terminata. Adesso si tratta semplicemente di modificare le parti del file Homestead.yaml per effettuare la configurazione.

## Configurazione
- Per prima cosa generare delle chiavi ssh aprendo il terminale Git Bash e digitando ```ssh-keygen -t rsa -C "yourname@homestead" ```, in questa maniera verrà creato un file id\_rsa.pub nella cartella .ssh di sistema.
- Ora nella cartella Laravel aprire il terminale Git Bash ed inserire il seguente comando ```git clone https://gitlab.com/antoniodemarco95/laravel-resp.git``` creando così una nuova directory denominata laravel-resp contenente tutti i file di RESP in laravel.
- Aprire il file Homestead.yaml presente nella cartella Homestead e sostituire nella sezione &quot;folders&quot; modificare l&#39;attributo 'map' con il percorso della nostra directory Laravel e l'attributo 'to' con '/home/vagrant/Laravel''; nella sezione &quot;sites&quot; modificare  l&#39;attributo 'map' con la dicitura &quot;resp.local&quot; e l'attributo 'to' con '/home/vagrant/Laravel/laravel-resp/public'; nella sezione database modificare la parola homestead con resp.
- Modificare il file hosts ( [https://support.rackspace.com/how-to/modify-your-hosts-file/](https://support.rackspace.com/how-to/modify-your-hosts-file/)) aggiungendo la riga ```192.168.10.10  resp.local```.

In questa maniera anche la configurazione è terminata.

## Caricamento Dati Di Prova
Resp viene fornito con un set di dati di prova che è possibile installare seguendo questi passi:
- Aprire il terminale e spostarsi nella cartella "Homestead".
- Lanciare il comando ```vagrant up ``` ed attendere che la macchina virtuale venga lanciata con successo.
- Aprire il terminale e spostarsi nella cartella "laravel-resp".
- Lanciare il comando ```php artisan migrate:fresh```
- Lanciare il comando ```php artisan db:seed```

Ciò permette di potersi loggare come care provider utilizzando lo username "Bob Kelso" e la password "test1234" (attualmente dopo il login si riscontra un errorre in quanto il lato care provider non è ancora conlcuso) o come paziente con username "Janitor Jan" e password "test1234".

## Daily Use
Ora, ogni volta che avremo bisogno di sviluppare in RESP, non ci resta che avviare o spegnere la macchina virtuale Homestead, dalla cartella omonima, tramite il comando ```vagrant up``` per farla partire (al primo avvio ci metterà del tempo) e ```vagrant halt``` per arrestare la macchina. Per vedere il sito, una volta che la macchina virtuale è up, basterà digitare nel browser http://resp.local

Inoltre ogni qualvolta verranno effettuati dei cambiamenti al database, sarà necessario eseguire i comandi già citati:
```php artisan migrate:fresh``` e ```php artisan db:seed``` 

## Consigli contro vari ed eventuali
- Eseguire ogni applicazione chiamata in causa come amministratore;
- Se vagrant.msi genera errori del tipo 2503 o/e 2502 seguire questa guida http://techubber.blogspot.com/2016/03/how-to-fix-error-2502-and-2503-uninstall-msi.html


Per tutta la documentazione relativa a Laravel si rimanda al sito ufficiale: [https://laravel.com/](https://laravel.com/)

## Settare il file .env per consentire l'invio delle mail al sistema:
Per consentire l'invio di mail al sistema utilizzare un account gmail e seguire i seguenti passi:
- Impostare ad ON l'accesso alle app meno sicure nel proprio account gmail al seguente link [https://myaccount.google.com/lesssecureapps](https://myaccount.google.com/lesssecureapps)
- Nel file .env settare i seguenti campi:

    MAIL_DRIVER=smtp
    
    MAIL_HOST=smtp.googlemail.com
    
    MAIL_PORT=465
    
    MAIL_USERNAME= LA_MAIL_DEL_VOSTRO_ACCOUNT_GMAIL
    
    MAIL_PASSWORD= LA PASSWORD DEL VOSTRO ACCOUNT GMAIL
    
    MAIL_ENCRYPTION=ssl 
