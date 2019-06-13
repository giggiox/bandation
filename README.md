# BANDATION   eventi e band musicali

l'obiettivo del progetto è creare una piattaforma che consenta a chiunque  di cercare e localizzare eventi musicali e, per gli utenti registrati, di creare sia band che eventi.

l'obiettivo del progetto è creare una piattaforma che consenta a chiunque  di cercare e localizzare eventi musicali e, per gli utenti registrati, di creare sia band che eventi.
<p align="center"><img src="https://github.com/giggiox/bandation/blob/master/foto/1.PNG"></p>

Un utente loggato può creare gruppi o chiedere di essere ammesso ad altri gruppi. 
Come nel caso dell’utente anche il gruppo ha le coordinate geografiche relative alla sede indicata in  modo che sia possibile visualizzarlo su una mappa. 
Queste informazioni sono memorizzate nella tabella Group. 
Un gruppo ha più utenti. 
La relazione tra utente e gruppo è memorizzato nella tabella Group_user.
<p align="center"><img src="https://github.com/giggiox/bandation/blob/master/foto/2.PNG"></p>

La tabella Group_users tiene le informazioni relative a i ruoli di un utente all’interno del gruppo stesso. 

Il creator del gruppo può ricevere delle richieste di iscrizione da parte dei singoli utenti(“request”) e può decidere di accettarli (“accepted”) o di rifiutarli (“refused”).  

<p align="center"><img src="https://github.com/giggiox/bandation/blob/master/foto/3.PNG"></p>

Il creatore del gruppo può creare degli eventi per il gruppo stesso. 
Ogni evento sarà caratterizzato da un titolo, una descrizione, una data, l’ora di inizio e di fine , luogo (sempre tramite API google) per permettere di mostrarlo sulla mappa. 
<p align="center"><img src="https://github.com/giggiox/bandation/blob/master/foto/4.PNG"></p>

Ogni utente può migliorare la sua biografia e aggiungere uno o più strumenti che suona e una descrizione dell’esperienza con essi. 
Nella tabella Instruments ci sono già presenti i possibili strumenti selezionabili. 
La tabella Instrument_users tiene conto delle informazioni date dall’utente sullo strumento che sa suonare. 

<p align="center"><img src="https://github.com/giggiox/bandation/blob/master/foto/5.PNG"></p>

Immagini di profilo e descrizioni sono previste sia per gli utenti che per i gruppi. 
<p align="center"><img src="https://github.com/giggiox/bandation/blob/master/foto/6.PNG"><img src="https://github.com/giggiox/bandation/blob/master/foto/7.PNG"></p>

Inoltre per il sistema di reset delle password il progetto si appoggia sempre sul servizio mail, in questo modo nel database è presente una tabella che tiene conto del momento nel quale la richiesta è stata inviata per far sì che abbia una decadenza. 

<p align="center"><img src="https://github.com/giggiox/bandation/blob/master/foto/8.PNG"></p>


## indirizzo sito: http://bandation.it

# ACCESSO AL PORTALE:
Molte volte quando si sviluppano sistemi utilizzando php non si tiene nella dovuta considerazione l'aspetto sicurezza mentre i framework di sviluppo offrono già nativamente delle soluzioni.

Infatti la versione che ho sviluppato con il framework Laravel (http://github.com/giggiox/bandation_laravel)  ha già integrate determinate funzionalità che in questa versione sviluppata in php ho docuto replicare scrivendone il relativo codice.

## LOGIN

tutte le password fornite dall'utente durante la fase di registrazione o successive variazioni vengono memorizzate all'interno del database in modo criptato.

Questo garantisce che, anche riuscendo ad accedere al database le credenziali memorizzate non sarebbero utilizzabili per eseguire il login.

L'algoritmo che ho usato è il __BCRYPT__.

Questo algoritmo di hashing, sviluppato nel 1999 da Niels Provos e David Mazières, due professori universitari, è largamente utilizzato nei sistemi BSD e Linux.

BCRYPT a differenza di altri algoritmi spesso utilizzati tipo md5, sha e derivati ha la caratteristica di essere complesso da calcolare, pertanto richiede molto più tempo degli altri riducendo così la possibilità di attacchi bruteforce.
<p align="center"><img src="https://github.com/giggiox/bandation/blob/master/foto/9.png"></p>
ma anche se con questo algoritmo gli attachi bruteforce sono più lenti, sono comunque possibili sia con un esecuzione per tentativi che tramite dizionario, come ho potuto verificare codificando uno script in python: www.github.com/giggiox/bruteforce_bandation


Per annullare la possibilità di attacchi bruteforce nel login ho implementato una protezione CSRF(Cross-site request forgery) implementando uno script lato server:

###### nella form di login:
```php
$token=bin2hex(openssl_random_pseudo_bytes(30));
$_SESSION["_token"]=$token;
<input type="hidden" name="_token" value="<?=$token?>">
```

###### lato server quando la richiesta viene inviata:
```php
if(!isset($_SESSION["_token"]) || $_SESSION["_token"] != $_POST["_token"]){
	header("location:../../user/login.php");
} 
unset($_SESSION["_token"]);
```
in questo modo non è possibile creare algoritmi di bruteforce poichè  quando invieremo la richiesta al server questa sarà così formata:
<p align="center"><img src="https://github.com/giggiox/bandation/blob/master/foto/10.PNG"></p>

e siccome il token csrf è impossibile da indovinare poichè generato in modo random, qualsiasi algoritmo di bruteforce sarà così inutile.


Tuttavia un altro attacco che si potrebbe verificare è il Mysql Injection. Si tratta di un attacco per il quale viene "iniettato" del codice SQL all'interno del database.
<p align="center"><img src="https://github.com/giggiox/bandation/blob/master/foto/11.PNG"></p>

eseguendo questo semplice script nella form di login infatti saremo direttamente autenticati come amministratori.

La query lato server risulterà così 
```sql
SELECT * FROM users WHERE email='' OR 1=1 ---
```
Questa query  da come risultato la prima riga della tabella users che oltretutto di solito è l'amministratore.

per ovviare a questo problema si ricorre alla tecnica di sanitizzazione di una stringa.

In questo modo PHP rimuove tutti i caratteri speciali contenuti in una stringa e elimina la possibilità di injection:
```php
$query = $mysqli->real_escape_string($query);
```

Per evitare spam/dos nelle form di registrazione e di reset della password ho usufruito delle API di google per inserire un recaptcha sicuro.

La versione 2 del recaptcha google si avvale di un sistema simile a RSA con chiave pubblica e privata.

Ho creato una classe Google che contiene tutti i metodi relativi alle API utilizzate.

Per quanto riguarda il recaptcha ho implementato questo metodo:
```php
static function isRecaptchaValid($captcha) {
        $url="https://www.google.com/recaptcha/api/siteverify?secret=". self::$secret_recaptcha_key."&response=".$captcha;
        $verifyResponse = file_get_contents($url);
        $responseData = json_decode($verifyResponse);
        return $responseData->success;
}
```

# COLLEGAMENTI CON ALTRI SERVIZI
## geolocalizzazione
per validare un luogo inserito dall'utente ho dovuto implementare questo metodo all'interno della classe Google.

inizialmente invio una richiesta ai server di google con il luogo inserito dall'utente.

```php
static function ValidatePlace($place) {
        $place = str_replace(' ', '', $place); //geocode accetta solo address senza spazi
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$place}&key=" . self::$gmaps_key;
}
```
ne leggo la risposta inviata dai server di google in formato JSON  che ci informa dell'esistenza o meno del luogo inserito indicando eventualmente il nome corretto, la latitudine e la longitudine.

```php
$resp_json = file_get_contents(urldecode($url));
$resp = json_decode($resp_json, true);
```
per ottenere le informazioni richieste ho dovuto codificare l'interpretazione del JSON che è arrivato e fare il parsing
```php
if ($resp['status'] == 'OK') {
    $lat = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
    $lng = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
    $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";
    if ($lat && $lng && $formatted_address) {
        $data_arr = ["lat" => $lat, "lng" => $lng, "place" => $formatted_address];
        return $data_arr;
    }
} else {
    return false
}
```










