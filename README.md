# BoolBnb - TEAM #2
>Back-End environment

Realizzazione di un progetto in Team per lo sviluppo di una webapp che permette di trovare e gestire l’affitto di appartamenti.

I proprietari di appartamenti, registrandosi a BoolBnB, possono inserire le informazioni delle loro proprietà e decidere se sponsorizzarle per avere una posizione evidenziata nelle ricerche e in home page.

Gli utenti interessati ad affittare, senza registrazione, possono cercare e visualizzare gli appartamenti. Una volta scelto l’appartamento di interesse, possono inviare un messaggio al proprietario tramite la piattaforma, per chiedere maggiori dettagli.

## Project Setup
installare le dipendenze 
```
composer install
```
```
npm install
```
in due terminali splittati
```
npm run dev
```
```
php artisan serve
```
duplicare il file .env-example, rinominarlo .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1 --- CAMBIARLA ALL'OCCORRENZA
DB_PORT=3306 --- CAMBIARLA ALL'OCCORRENZA
DB_DATABASE=NOME_DB
DB_USERNAME=
DB_PASSWORD=

FILESYSTEM_DISK=public
```
aggiungere in fondo 
```
API_IT_KEY = "la tua api key tomtom"

BRAINTREE_ENV = "sandbox"
BRAINTREE_MERCHANT_ID = "generata alla registrazione su braintree"
BRAINTREE_PUBLIC_KEY = "generata alla registrazione su braintree"
BRAINTREE_PRIVATE_KEY = "la tua key braintree"
```

## Contributors
- <a href="https://github.com/DavidC1103">Calaiò David Salvatore</a>
- <a href="https://github.com/marcocnc">Cancelliere Marco</a>
- <a href="https://github.com/raffaele-catalano">Catalano Raffaele</a>
- <a href="https://github.com/mirkettinho">Di Franco Mirko</a>
- <a href="https://github.com/mcspe">Spezzaferro Marco</a>
