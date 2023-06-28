# multistep-registration

## Apraksts
Projekts ir veidots izmantojot Laravel v10.13.5 (PHP v8.2.7), view izveidoti izmantojot Blade templating engine, CSS (pusceļā) izveidots izmantojot Tailwind CSS framework.
### Reģistrācija & autorizācija
Lietotāja reģistrācijas forma sastāv no vairākiem soļiem. Lietotāja ievadītie dati tiek verificēti pa soļiem - izmantojot fetch() API izsaucot reģistrācijas controller `RegisterController` atbilstošās metodes, atgriežot rezultātu kā JSONRequest.

### Lietotāja profils
Lietotāja profila lapa ir pieejama tikai autorizētam lietotājam. Lietotājs var rediģēt savu profila informāciju, kā arī mainīt savu paroli. Lietotājs var arī dzēst savu profilu, kas izdzēsīs arī visus lietotāja ierakstus datubāzē.

### JS spēle
Izveidota izmantojot JS Phaser 3 framework.  
Spēles mērķis ir lidot ar lidmašīnu un, izmantojot piederošos ieročus, attīrīt laukumu no baktērijām. Spēles laikā tiek uzkrāti punkti un tiek parādīti spēles kreisajā augšējā stūrī.
Iznīcinot baktērijas, ir 50% iespēja ka tā vairosies un sadalīsies divās baktērijās. Ir aptuveni 5% iespēja, ka baktērija sadalīsies 20 baktērijās.
Spēle domāta tīri laika nosišanai, tāpēc nav ieviestas nekādas uzvaras vai zaudējuma mehānikas.
#### Kontroles
+ `Arrow up` - uz augšu
+ `Arrow left` - pa kreisi
+ `Arrow down` - uz leju
+ `Arrow right` - pa labi
+ `SPACE` - šaut ar ložmetēju
+ `Ctrl` - nomest bumbu
+ `Shift` - palaist raķetes

### Inventāra lapa
Inventāra lapā iespējams pievienot produktus ar nosaukumiem, paskaidrojumiem un citiem atribūtiem. Lapā ir pāris datu apstrādes iespējas, piemēram, pievienot, rediģēt, dzēst, apskatīt, meklēt un kārtot produktus. Lapa nav pilnveidota, tāpēc dažas funkcijas var nedarboties korekti, var būt pāris ievades kļūdas produkta izveidošanas formā.  
TLDR: aptrūkās laika.

## Instalācija
### Prasības
Lai varētu izpildīt instalāciju nepieciešams:
+ Node package manager (npm)
+ PHP 8.1.0 (vai lielāks)
+ Composer 2.2.0 (vai lielāks)
+ MySQL (vai cita datubāze, bet tad .env failā jāmaina datubāzes tips un cita informācija)

### Composer
```bash
composer install
```

### .env fails
```bash
copy .env.example .env
php artisan key:generate
```

### Datubāze
Pēc noklusējuma datubāze ir mysql ar nosaukumu `laravel`, bet to var mainīt .env failā zem rindas `DB_DATABASE=laravel`. Turpat arī iespējams mainīt datubāzes lietotāju un paroli.

Pēc tam jāizveido datubāzes tabulas ar komandu:
```bash
php artisan migrate
```
Pēc pieprasījuma jāizvēlas `yes` lai izveidotu datubāzi.

### NPM
```bash
npm install
npm run dev
```

### Palaišana
```bash
php artisan serve
```
Pēc komandu izpildes lapa pieejama localhost:8000

## Piederošie linki
+ `localhost/register` - reģistrācijas forma
+ `localhost/login` - autorizācijas forma
+ `localhost/` - sākuma lapa
+ `localhost/profile` - lietotāja profila lapa
+ `localhost/logout` - izlogoties
+ `localhost/shooter` - šaušanas spēles lapa
+ `localhost/inventory` - inventāra lapa

