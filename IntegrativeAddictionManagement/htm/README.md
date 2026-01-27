# Xalcohol HTM Versie

## Overzicht

Dit is een volledig client-side (browser-based) versie van het Xalcohol Self-Management systeem. Alle PHP-functionaliteit is vervangen door JavaScript met localStorage.

## Belangrijkste verschillen met PHP versie

### Database
- **Was:** MySQL database op server
- **Nu:** localStorage in browser (IndexedDB simulatie via JavaScript)

### Authenticatie
- **Was:** Server-side sessies en cookies
- **Was:** Wachtwoorden opgeslagen in MySQL
- **Nu:** Lokale authenticatie met localStorage
- **Nu:** Alle data blijft op het apparaat van de gebruiker

### Email functionaliteit
- **Was:** PHP mail() functie voor wachtwoord reset en uitnodigingen
- **Nu:** Gesimuleerd (toont het nieuwe wachtwoord direct aan gebruiker)
- **Opmerking:** Voor echte email zou een server-side component nodig zijn

## Bestandsstructuur

```
Xalcohol-htm/
├── index.htm              - Hoofdpagina (landing page)
├── login.htm              - Login en registratie
├── main.htm               - Hoofdmenu na login
├── README.md              - Deze documentatie
├── js/
│   ├── database.js        - localStorage database simulatie
│   └── praatmethans.js    - Formulier opslag en utilities
├── assets/                - CSS en afbeeldingen (kopieer van origineel)
└── pics/                  - Afbeeldingen (kopieer van origineel)
```

## Database Structuur (localStorage)

### Tabellen

#### users
- id (auto increment)
- user_name (string, uniek)
- password (gehashed)
- emailadres (string, uniek)
- voornaam (string)
- achternaam (string)
- gebjaar, gebmaand, gebdag
- created (timestamp)

#### sessions
- id (auto increment)
- user_id (foreign key naar users)
- session_token (unieke string)
- created (timestamp)
- expires (timestamp)

#### userdata
- id (auto increment)
- user_id (foreign key naar users)
- key (string)
- value (JSON)
- updated (timestamp)

## JavaScript API

### Database (DB object)

```javascript
// Basis operaties
DB.insert(tableName, data)
DB.select(tableName, whereClause, orderBy, limit)
DB.selectOne(tableName, whereClause)
DB.update(tableName, data, whereClause)
DB.delete(tableName, whereClause)
DB.count(tableName, whereClause)

// Voorbeelden
DB.insert('users', { user_name: 'jan', password: 'hash123', emailadres: 'jan@example.com' });
DB.select('users', { user_name: 'jan' });
DB.update('users', { password: 'newhash' }, { id: 1 });
```

### Authenticatie (Auth object)

```javascript
// Registratie
Auth.register({
    user_name: 'gebruiker',
    password: 'wachtwoord',
    emailadres: 'email@example.com',
    voornaam: 'Jan',
    achternaam: 'Jansen'
});

// Login
Auth.login(username, password);

// Check login status
Auth.isLoggedIn();

// Huidige gebruiker
Auth.getCurrentUser();

// Uitloggen
Auth.logout();

// Wachtwoord wijzigen
Auth.changePassword(userId, newPassword);

// Wachtwoord vergeten
Auth.resetPassword(emailadres);
```

### Gebruikersdata (UserData object)

```javascript
// Data opslaan
UserData.set('formulier_naam', { veld1: 'waarde', veld2: 'waarde' });

// Data ophalen
UserData.get('formulier_naam', defaultValue);

// Alle data ophalen
UserData.getAll();

// Data verwijderen
UserData.remove('formulier_naam');
```

### Formulieren (praatmethans.js)

```javascript
// Formulier opslaan
saveSelections(document.forms[0]);

// Formulier herstellen
loadSelections(document.forms[0]);

// Auto-save inschakelen (om de 30 seconden)
enableAutoSave(document.forms[0], 30000);

// Data exporteren
exportFormData(document.forms[0]);

// Validatie
validateEmail(email);
validateRequired(form, ['veld1', 'veld2']);
```

## Gebruik

### 1. Bestanden klaarzetten

Kopieer de volgende mappen van de originele Xalcohol naar Xalcohol-htm:
- `assets/` (CSS bestanden)
- `pics/` (afbeeldingen)

### 2. Openen in browser

Open `index.htm` in een moderne browser (Chrome, Firefox, Safari, Edge).

### 3. Account aanmaken

1. Klik op "INLOGGEN / AANMELDEN"
2. Klik op "Nog geen account? Registreer hier"
3. Vul de gegevens in
4. Klik op "registreer"

### 4. Inloggen

1. Vul gebruikersnaam en wachtwoord in
2. Klik op "nu inloggen"

### 5. Formulieren gebruiken

1. Klik op "formulieren" in het menu
2. Vul formulieren in
3. Klik op 's' om op te slaan
4. Klik op 'r' om te herstellen

## Privacy & Veiligheid

### Voordelen
- **100% Lokaal:** Alle data blijft op het apparaat van de gebruiker
- **Geen Server:** Geen risico op data lekken via server
- **Geen Internet Nodig:** Werkt volledig offline (na eerste laden)
- **Volledige Controle:** Gebruiker heeft volledige controle over eigen data

### Beperkingen
- **Geen Synchronisatie:** Data wordt niet gesynchroniseerd tussen apparaten
- **Browser Gebonden:** Data is gebonden aan browser en apparaat
- **Geen Backup:** Als browser data wordt gewist, is alles weg
  - **Oplossing:** Gebruik export functie om backup te maken

### Veiligheid
- Wachtwoorden worden gehashed (basis implementatie)
- Voor productie: gebruik een sterker hash algoritme (bcrypt, scrypt)
- Sessies verlopen na 7 dagen
- Geen SQL injection mogelijk (geen SQL database)

## Browser Compatibiliteit

Vereisten:
- localStorage ondersteuning (alle moderne browsers)
- JavaScript enabled
- Cookies niet vereist

Getest op:
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Migratie van PHP naar HTM

### Wat werkt hetzelfde
- Formulieren (alle bestaande htm formulieren blijven werken)
- Opslaan en herstellen van data
- Gebruikersaccounts
- Privacy (zelfs beter omdat alles lokaal is)

### Wat anders werkt
- Geen email verzending (moet handmatig)
- Geen multi-device sync
- Data export/import handmatig

### Wat beter werkt
- Sneller (geen server roundtrips)
- Werkt offline
- Geen server kosten
- Volledige privacy
- Geen afhankelijkheid van PHP/MySQL

## Ontwikkeling

### Testing

Open de browser console (F12) om debug informatie te zien:

```javascript
// Bekijk alle opgeslagen data
console.log(localStorage);

// Bekijk alle gebruikers
console.log(DB.select('users'));

// Bekijk huidige gebruiker
console.log(Auth.getCurrentUser());

// Bekijk alle userdata
console.log(UserData.getAll());
```

### Database Reset

Om de database leeg te maken (voor testing):

```javascript
// In browser console
DB.dropTable('users');
DB.dropTable('sessions');
DB.dropTable('userdata');
DB.init();
```

Of:

```javascript
// Verwijder alles
localStorage.clear();
location.reload();
```

## Export/Import

### Data Exporteren

```javascript
// Export alle database data
var backup = DB.exportAll();
// Save to file via download

// Export gebruikersdata
var userData = UserData.getAll();
```

### Data Importeren

```javascript
// Import database backup
DB.importAll(jsonString);
```

Via UI:
- Login naar account
- Klik op "backup data" in menu
- JSON bestand wordt gedownload

## Integratie met bestaande formulieren

De bestaande HTM formulieren uit `../htm-version/` kunnen gebruikt worden:

```html
<!-- In elk formulier, voeg toe in <head> -->
<script type="text/javascript" src="../Xalcohol-htm/js/database.js"></script>
<script type="text/javascript" src="../Xalcohol-htm/js/praatmethans.js"></script>
```

De bestaande save/restore knoppen blijven werken!

## Licentie

Zie originele project voor licentie informatie.

## Contact

Voor vragen of suggesties: HansRJWest@Gmail.com

## Changelog

### Versie 1.0 (2026-01-04)
- Initiële conversie van PHP naar HTM
- localStorage database implementatie
- Client-side authenticatie
- Formulier opslag systeem
- Export/import functionaliteit
