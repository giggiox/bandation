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
