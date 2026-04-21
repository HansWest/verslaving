# Taalharmonisatie Naar Volledig Nederlands: Mogelijkheden

Doel van deze notitie: opties in kaart brengen om IAM volledig Nederlandstalig te maken, zonder functionele regressies.

## Uitgangspunten

- Alleen zichtbare tekst aanpassen (labels, knoppen, meldingen, helptekst).
- Geen wijziging van data-keys, form-namen, routes, id-attributen of JS-logica.
- Gefaseerde aanpak: eerst kernflow, daarna uitbreidingen, daarna legacy.
- Elke fase afsluiten met korte functionele check.

## Wat valt onder taalharmonisatie

- Paginatitels en koppen.
- Knoppen en call-to-actions.
- Formulierlabels, placeholders en validatiemeldingen.
- Feedback- en statusberichten.
- Tooltiptekst en modale bevestigingen.
- Export/print-teksten en voortgangslabels.
- Teksten die via PHP worden gerenderd (server-side output).
- Teksten in JavaScript (alerts, confirm-dialogen, dynamische labels, toast/feedback).

## Uitgebreide scope (op verzoek): legacy HTM + PHP + JS

Deze harmonisatie neemt expliciet mee:

- Actieve IAM HTML: `iam/htm/*.htm`.
- Legacy HTML-varianten: `htm-version/*.htm` en oudere HTML in `IntegrativeAddictionManagement/htm/*`.
- PHP-bestanden met zichtbare UI-tekst: bijvoorbeeld `IntegrativeAddictionManagement/login_behandelaar.php` en overige `*.php` in de repo.
- JavaScript-bestanden met gebruikersberichten: `iam/js/*.js`, `IntegrativeAddictionManagement/skripts/*.js`, en inline scripts in HTML/PHP.

Afspraak voor deze uitbreiding:

- Alleen gebruikerszichtbare tekst wijzigen.
- Geen functionele refactor van JS/PHP.
- Geen wijziging van data-sleutels, parameternamen, opslagstructuren of endpoint-contracten.

Niet inbegrepen in deze stap:

- Inhoudelijke herziening van methodiek.
- Structurele UI-verbouwing.
- Datamodelwijzigingen.

## Mogelijke uitvoerstrategieën

### Optie A: Quick wins (laag risico)

- Alleen de actieve kernflow in `iam/htm` nalopen op zichtbare Engelstalige tekst.
- Geen hernoemen van variabelen of interne comments.
- Resultaat: snel consistentere beleving voor gebruikers.

### Optie B: Volledige productlaag (middel risico)

- Alles uit Optie A.
- Plus game-schermen, progress-overzichten, modals en minder gebruikte IAM-pagina's.
- Plus consistente terminologie-lijst (bijv. `trek`, `stemming`, `voortgang`, `eindcheck`).

### Optie C: Inclusief legacy-gebieden (hoger risico)

- Alles uit Optie B.
- Plus oudere mappen/varianten buiten de leidende kernflow.
- Plus PHP-rendered tekst en JS-gestuurde berichten in legacy en actieve delen.
- Vereist extra controle op dubbele versies en afwijkende UX-patronen.

## Aanbevolen volgorde

1. Kernflow-pagina's (leidende set uit `werkafspraken.md`).
2. Dashboard en samenvattingen (`index.htm`, voortgangscomponenten).
3. Game en ondersteunende interacties (check-ins, ronde-einde, meldingen).
4. Overige IAM-pagina's buiten kernflow.
5. Legacy HTML in `htm-version` en `IntegrativeAddictionManagement/htm`.
6. PHP-bestanden met UI-uitvoer (`*.php`).
7. JS-bestanden met gebruikersberichten (inline en losse `*.js`).

## Risico's en mitigaties

- Risico: tekstwijziging raakt selector of codepad.
  Mitigatie: nooit id/class/naam-attributen wijzigen als ze in JS gebruikt worden.

- Risico: inconsistent taalgebruik tussen pagina's.
  Mitigatie: centrale woordenlijst vastleggen en per fase toepassen.

- Risico: functioneel gedrag verandert ongemerkt.
  Mitigatie: per fase mini-regressietest op opslaan, laden, export, print, navigatie.

- Risico: PHP-tekst zit verweven met logica of escaping.
  Mitigatie: alleen string-literals met zichtbare UI-tekst aanpassen; geen wijziging in conditionele blokken of output-escaping.

- Risico: JS-tekst staat in codepaden met vergelijkingen op exacte tekst.
  Mitigatie: geen logica koppelen aan UI-teksten; bij twijfel eerst checken of string functioneel wordt vergeleken.

## Extra acceptatiecriteria voor PHP en JS

- Geen PHP parse errors na tekstwijzigingen.
- Geen nieuwe JavaScript fouten in console op kernroutes.
- Bestaande knoppen/dialogen tonen nog steeds op het juiste moment.
- Dynamische statuslabels updaten nog correct na acties.

## Voorstel woordenlijst (startversie)

- Craving -> Craving
- Trek -> Trek
- Mood -> Stemming
- Check-in -> Check-in
- End check -> Eindcheck
- Progress -> Voortgang
- Save -> Opslaan
- Reset -> Terugzetten naar standaard
- Round score -> Rondescore

## Terminologie-afspraak

- `Craving` is binnen IAM een fatsoenlijke en bruikbare term, ook in het Nederlands.
- We vertalen `craving` daarom niet automatisch naar `trek`.
- `Craving` en `trek` mogen naast elkaar bestaan wanneer dat inhoudelijk helpt, maar `craving` hoeft niet weggewerkt te worden om de app Nederlandstalig te maken.

## Acceptatiecriteria (zonder werking aan te tasten)

- Alle zichtbare gebruikers-tekst in scope is Nederlands.
- Geen wijzigingen in data-structuur of opgeslagen keys.
- Geen extra fouten in HTML/JS-validatie.
- Kernacties werken nog: invullen, opslaan, herladen, exporteren, printen, navigeren.

## Praktische keuze voor nu

Als veiligheid en snelheid het belangrijkst zijn: kies Optie A, en plan Optie B direct erna.
