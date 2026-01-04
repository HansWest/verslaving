# Installatie Instructies - Xalcohol HTM Versie

## Stap 1: Bestanden verzamelen

Je hebt de volgende bestanden nodig uit de originele Xalcohol map:

### Van `/IntegrativeAddictionManagement/Xalcohol/`:

1. **pics/** folder - Alle afbeeldingen
   - Kopieer de hele folder naar `Xalcohol-htm/pics/`

2. **assets/sma.css** (optioneel, er zit al een basis CSS in de htm versie)
   - Als je de originele styling wilt behouden

3. **Andere assets** die je wilt gebruiken

## Stap 2: Basis Test

1. Open `index.htm` in een moderne browser
2. Je zou de hoofdpagina moeten zien

## Stap 3: Account aanmaken

1. Klik op "INLOGGEN / AANMELDEN"
2. Klik op "Nog geen account? Registreer hier"
3. Vul in:
   - Gebruikersnaam (bijv: demo_user)
   - Email (bijv: demo@example.com)
   - Wachtwoord (minimaal 6 tekens)
   - Herhaal wachtwoord
   - Optioneel: voor- en achternaam
4. Klik "registreer"

## Stap 4: Inloggen

1. Na registratie wordt je doorgestuurd naar login
2. Vul je gebruikersnaam en wachtwoord in
3. Klik "nu inloggen"
4. Je wordt doorgestuurd naar het hoofdmenu

## Stap 5: Test de functionaliteit

1. Open het demo formulier (demo-formulier.htm)
2. Vul wat velden in
3. Klik op 's' om op te slaan
4. Ververs de pagina (F5)
5. Klik op 'r' om te herstellen
6. Je velden zouden gevuld moeten zijn met je opgeslagen data

## Stap 6: Integreer met bestaande formulieren

Om de bestaande formulieren uit `/htm-version/` te gebruiken met localStorage:

### Optie A: Directe links (simpelst)

Gebruik de menu optie "formulieren" in main.htm, deze linkt naar `../htm/index.htm`

De bestaande formulieren werken al met cookies via praatmethans.js!

### Optie B: Voeg database support toe

Voeg in elk formulier toe (in de `<head>` sectie):

```html
<script type="text/javascript" src="../Xalcohol-htm/js/database.js"></script>
<script type="text/javascript" src="../Xalcohol-htm/js/praatmethans.js"></script>
```

En pas de path naar praatmethans.js aan van:
```html
<script type="text/javascript" src="../skripts/praatmethans.js"></script>
```

naar:
```html
<script type="text/javascript" src="../Xalcohol-htm/js/praatmethans.js"></script>
```

## Stap 7: Afbeeldingen toevoegen

Zorg ervoor dat je de volgende afbeeldingen hebt in `pics/`:

- macmanup.gif (groen mannetje)
- macmandwn.gif (rood mannetje)
- macmanvraag.gif (vraagteken mannetje)
- macsmiley.gif (smiley)
- grijs.gif (klein grijs bolletje)
- flag_nl.gif (Nederlandse vlag)
- logogrey100.jpg (logo)
- vraagtekentje.gif (klein vraagteken)

Als deze afbeeldingen ontbreken, kun je ze kopiëren van de originele Xalcohol folder.

## Veelvoorkomende Problemen

### Probleem: "Geen formulier gevonden om op te slaan"

**Oplossing:** Zorg dat je formulier een `name` attribuut heeft:
```html
<form name="mijn_formulier">
```

### Probleem: Data wordt niet opgeslagen tussen sessies

**Oplossing:** 
- Check of localStorage werkt in je browser (Console: `localStorage.setItem('test', 'test')`)
- Check of je browser localStorage niet blokkeert
- Check of je niet in Incognito/Private modus bent

### Probleem: Na registratie kan ik niet inloggen

**Oplossing:**
- Open Browser Console (F12)
- Type: `DB.select('users')`
- Check of je gebruiker bestaat
- Probeer opnieuw met een ander wachtwoord

### Probleem: "Cannot read property of undefined"

**Oplossing:**
- Zorg dat database.js en praatmethans.js geladen zijn
- Check de browser console voor errors
- Reload de pagina (Ctrl+F5 voor hard reload)

### Probleem: Afbeeldingen worden niet getoond

**Oplossing:**
- Check of de `pics/` folder bestaat en de juiste afbeeldingen bevat
- Check de browser console voor 404 errors
- Pas de paths in de HTML aan indien nodig

## Testing

### Handmatige Test Checklist

- [ ] Index pagina laadt correct
- [ ] Login pagina laadt correct
- [ ] Nieuwe account kan aangemaakt worden
- [ ] Inloggen werkt
- [ ] Hoofdmenu wordt getoond na login
- [ ] Uitloggen werkt
- [ ] Demo formulier laadt
- [ ] Formulier opslaan werkt (s knop)
- [ ] Formulier herstellen werkt (r knop)
- [ ] Data blijft bewaard na browser refresh
- [ ] Wachtwoord wijzigen werkt
- [ ] Wachtwoord vergeten werkt
- [ ] Data export werkt

### Browser Console Tests

Open Browser Console (F12) en run:

```javascript
// Test 1: Check localStorage
localStorage.setItem('test', 'hello');
console.log(localStorage.getItem('test')); // Should show: hello

// Test 2: Check database
DB.init();
console.log(DB.tableExists('users')); // Should show: true

// Test 3: Check authenticatie
console.log(Auth.isLoggedIn()); // Should show: true (if logged in)

// Test 4: Check current user
console.log(Auth.getCurrentUser()); // Should show user object

// Test 5: Check user data
console.log(UserData.getAll()); // Should show saved form data
```

## Browser Ondersteuning

✅ **Werkt in:**
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

❌ **Werkt NIET in:**
- Internet Explorer (geen localStorage support)
- Zeer oude browsers
- Browsers met localStorage uitgeschakeld

## Volgende Stappen

1. Test alle functionaliteit
2. Pas CSS aan naar jouw voorkeur
3. Voeg extra formulieren toe
4. Configureer voor productie gebruik

## Productie Deployment

Voor gebruik in productie:

1. **Beveilig wachtwoorden beter:**
   - Gebruik bcrypt.js of een andere sterke hash functie
   - Voeg salt toe aan wachtwoorden

2. **Voeg HTTPS toe:**
   - Gebruik altijd HTTPS voor productie
   - localStorage is niet beveiligd over HTTP

3. **Test grondig:**
   - Test in verschillende browsers
   - Test op mobiele apparaten
   - Test met echte gebruikers

4. **Maak backups:**
   - Educeer gebruikers over backup functie
   - Test import/export functionaliteit

5. **Privacy:**
   - Voeg privacy policy toe
   - Leg uit dat data lokaal wordt opgeslagen
   - Geef instructies voor data verwijdering

## Support

Voor vragen of problemen:
- Email: HansRJWest@Gmail.com
- Of open een issue in de repository

## Licentie

Zie hoofdproject voor licentie informatie.
