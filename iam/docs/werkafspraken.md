# Werkafspraken

Deze notitie bevat praktische afspraken over hoe we IAM ontwikkelen en hoe nieuwe inzichten worden vastgelegd.

## Documentatie eerst

- Lees bij werk aan IAM altijd eerst de documentatie in deze map.
- Behandel de documentatiemap als primaire bron voor theorie, taalkeuzes en conceptuele richting.
- Gebruik interne geheugensteun alleen aanvullend, niet als hoofdbron.

## Nieuwe inzichten expliciet vastleggen

- Nieuwe theoretische inzichten worden opgenomen in de documentatiemap.
- Nieuwe werkafspraken worden opgenomen in de documentatiemap.
- Houd kennis expliciet, zichtbaar en overdraagbaar in de repo zelf.

## One Truth Aanpak

- We werken met een single source of truth: per onderwerp is er steeds 1 leidende plek.
- Documentatie in gebruik staat in de map `iam/docs` en niet verspreid in meerdere varianten.
- Per functionaliteit is duidelijk wat de actieve versie is en in welke map die staat.

## Opruimen van oude varianten

- Als een nieuwe versie actief in gebruik is, verwijderen we oude of dubbele varianten die niet meer nodig zijn.
- We laten geen parallelle "bijna dezelfde" versies staan zonder expliciete reden.
- Bij twijfel: eerst in documentatie aangeven welke versie leidend is, daarna pas opruimen.

## Leidende Set (Kernflow)

De onderstaande pagina's vormen de actieve kernflow van IAM in `iam/htm`.

- `index.htm`
- `waarom-wel-gebruiken.htm`
- `wat-is-mijn-ik.htm`
- `persoonlijke-waarden.htm`
- `lastige-gevoelens.htm`
- `craving-1-10.htm`
- `craving-gevoel.htm`
- `voor-nadelen-balansen.htm`
- `stimulus-respons.htm`
- `risico-situaties.htm`
- `risico-mensen.htm`
- `risico-activiteiten.htm`
- `soorten-trek.htm`
- `noodplan-forse-trek.htm`
- `trek-opvangen.htm`
- `trek-opvangen-2.htm`
- `plan-van-aanpak.htm`
- `motiverende-mensen.htm`
- `genieten-belonen.htm`
- `agenda.htm`

Alles buiten deze set is voorlopig niet leidend in de kernflow, tenzij expliciet toegevoegd in dit document.

## Scheiding van soorten kennis

- Theorie en inhoudelijke visie horen in bestanden zoals `achterliggende-theorie.md`.
- Werkwijze, proces en ontwikkelafspraken horen in `werkafspraken.md`.
- Gebruikersteksten blijven eenvoudiger dan interne theorie.

## Taal en benadering

- Vroege schermen nodigen uit tot zelfonderzoek en vermijden te snelle etiketten.
- Formuleringen als `wat is er aantrekkelijk aan?`, `wat levert het op?` en `wat kost het je?` passen beter dan direct pathologiserende taal.

## Werkcontext voor Copilot

Deze sectie bevat alles wat nodig is om consistent en goed aan IAM te werken.

### Doel en richting

- IAM is mobile-first: de app moet goed werken op telefoonscherm.
- Privacy-first: data blijft lokaal op het apparaat van de gebruiker.
- Offline-first: geen serverafhankelijkheid voor kernfunctionaliteit.
- Onderzoekende benadering: eerst begrijpen wat gebruik oplevert/kost, pas later verdieping.

### Bronnen en structuur

- Leidende documentatie staat in `iam/docs`.
- Leidende app-bestanden staan in `iam/htm`, `iam/css`, `iam/js`.
- De kernflow in deze notitie is de primaire bron voor actieve pagina's.
- Legacy mappen (`htm-version`, `IntegrativeAddictionManagement/htm`) zijn referentiebron, niet leidend voor nieuwe wijzigingen.

### Single Source of Truth

- Per onderwerp is er 1 leidende plek.
- Nieuwe inzichten direct vastleggen in `iam/docs`.
- Als nieuwe versie actief is: oude/dubbele versies verwijderen (na expliciete markering van leidende versie).

### Inhoudelijke ankers

- Theorie: zie `achterliggende-theorie.md`.
- Werkwijze: zie `werkafspraken.md`.
- Gebruikerstekst blijft eenvoudiger en minder labelend dan interne theorie.

### Standaard werkwijze bij wijzigingen

- Lees eerst `iam/docs/werkafspraken.md` en `iam/docs/achterliggende-theorie.md`.
- Wijzig eerst de leidende variant in `iam/*`.
- Controleer of verwijzingen en paden kloppen binnen `iam`.
- Werk documentatie bij als er nieuwe keuzes of inzichten zijn.
- Ruim achterblijvende dubbele varianten op wanneer ze niet meer nodig zijn.

### Technische basisafspraken

- HTML met viewport voor mobiel gebruik.
- CSS via `../css/mobile.css` en `../css/forms.css`.
- Centrale lokale data-opslag via `iam/js/dataStore.js`.
- Exportmogelijkheden (JSON/CSV) behouden of uitbreiden waar relevant.

### UX-interactieafspraak: tegelklik opent doelgebied

- Als een tegel/link in dezelfde pagina verwijst naar een tekstgebied of sectie, dan opent het doelgebied automatisch.
- Concreet: bij links naar een `details`-sectie (of een element binnen zo'n sectie) wordt die sectie eerst geopend en daarna gescrold.
- De gebruiker kan de sectie daarna handmatig weer dichtklikken.
- Dit gedrag is een vaste designafspraak voor IAM-pagina's met tegelnavigatie.

### Veilig en beheersbaar werken

- Geen onnodige destructieve acties op bestaande user-content.
- Bij onverwachte grote afwijkingen: eerst expliciet vastleggen wat leidend is, daarna opschonen.
- Bij twijfel over inhoudelijke richting: documentatie en kernflow zijn beslissend.
- Niet gokken: liever eerst nakijken in code, documentatie of gitgeschiedenis. Als iets daarna nog onduidelijk is, gericht navragen.
