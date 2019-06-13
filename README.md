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

