﻿# GUIDA PER L&#39;INSTALLAZIONE E LA CONFIGURAZIONE DI LARAVEL

(USANDO LARAVEL HOMESTEAD)



## Software richiesti:

- Un ambiente di sviluppo come EASYPHP, XAMPP o WAMP che abbia PHP 7.0 o superiore
- Composer ( [https://getcomposer.org/download/](https://getcomposer.org/download/)) Nota: specificare in fase di installazione la directory in cui si trova il file php.exe ovvero la directory di installazione di PHP 7.0 o superiore
- Git ( [https://git-scm.com/download/win](https://git-scm.com/download/win)) - Ovviamente ci sarà bisogno di settare username, email e password, ma per questo si rimanda ad ad altri fonti disponibili in rete.
- Oracle VirtualBox ( [https://www.virtualbox.org/wiki/Downloads](https://www.virtualbox.org/wiki/Downloads))
- Vagrant ( [https://www.vagrantup.com/downloads.html](https://www.vagrantup.com/downloads.html))

## Installazione
Una volta scaricati tutti i software richiesti procedere con i seguenti passi:

- Creare una cartella denominata Laravel, la quale andrà a contenere in una cartella la Vagrant Box di Homestead ed in un&#39;altra il codice effettivo della web application.
- Aprire il terminale e digitare il comando &quot;vagrant box add laravel/homestead&quot;; al prompt che verrà richiesto digitare il numero corrispondente alla voce Virtualbox (l&#39;operazione potrebbe richiedere vari minuti).
- Aprire il terminale Git Bash e tramite il comando &quot;cd&quot; spostare la working directory alla directory Laravel precedentemente creata (ricordarsi che in Git Bash i perocrsi utilizzano &#39;/&#39; come separatore);  digitare il comando &quot;git clone https://github.com/laravel/homestead.git Homestead&quot;
- All&#39;interno della cartella Laravel se ne dovrebbe ora avere una nuova denominata Homestead, aprirla e tenendo premuto il tasto Maiusc cliccare con il tasto destro del mouse e selezionare &quot;Apri finestra terminale qui&quot;; nella finestra terminale inserire il comando &quot; .\init.bat&quot;

Con questi passi l&#39;installazione di Homestead è terminata. Adesso si tratta semplicemente di modificare le parti del file Homestead.yaml per effettuare la configurazione.

## Configurazione
- Per prima cosa generare delle chiavi ssh aprendo il terminale Git Bash e digitando &quot;ssh-keygen -t rsa -C &quot;yourname@homestead&quot; &quot;, in questa maniera verrà creato un file id\_rsa.pub nella cartella .ssh di sistema.
- Ora nella cartella Laravel aprire il terminale Git Bash ed inserire il seguente comando &quot;git clone https://gitlab.com/antoniodemarco95/laravel-resp.git&quot; creando così una nuova directory denominata laravel-resp contenente tutti i file di RESP in laravel.
- Aprire il file Homestead.yaml presente nella cartella Homestead e sostituire nella sezione &quot;folders&quot; modificare l&#39;attributo map con il percorso della nostra directory Laravel; nella sezione &quot;sites&quot; modificare  l&#39;attributo map con la dicitura &quot;resp.local&quot;; nella sezione database modificare la parola homestead con resp.
- Modificare il file hosts ( [https://support.rackspace.com/how-to/modify-your-hosts-file/](https://support.rackspace.com/how-to/modify-your-hosts-file/)) aggiungendo la riga &quot;192.168.10.10  resp.local&quot;.

In questa maniera anche la configurazione è terminata.

## Daily Use
Ora, ogni volta che avremo bisogno di sviluppare in RESP, non ci resta che avviare o spegnere la macchina virtuale Homestead, dalla cartella omonima, tramite il comando &quot;vagrant up&quot; per farla partire (al primo avvio ci metterà del tempo) e &quot;vagrant halt&quot; per arrestare la macchina. Per vedere il sito, una volta che la macchina virtuale è up, basterà digitare nel browser http://resp.local