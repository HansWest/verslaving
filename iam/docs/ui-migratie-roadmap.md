# UI Migratie Roadmap

Deze roadmap beschrijft de vervolgstappen om de leidende IAM-pagina's om te zetten naar een consistente, leesbare mobile-first interface met vergelijkbare cards-UI.

## Huidige situatie

De homepagina in `iam/htm/index.htm` heeft al een moderne cards-UI.

Veel kernformulieren in `iam/htm` zijn inhoudelijk bruikbaar, maar technisch en visueel nog grotendeels legacy. Typische kenmerken daarvan zijn:

- lange tekstblokken zonder duidelijke visuele opdeling
- oude wrappers zoals `shadow`, `content`, `praatmethansheader`
- inline JavaScript en oude hulpknoppen
- save/load-knoppen die nog verwijzen naar oude cookie-logica
- tabellen en vaste breedtes die niet ontworpen zijn voor telefoonscherm
- formulieren die nog niet gekoppeld zijn aan de centrale datastore

## Belangrijkste bevindingen

### 1. Visuele stijl is nog niet systematisch

Er is wel basis-CSS in `iam/css/mobile.css` en `iam/css/forms.css`, maar de meeste legacy pagina's gebruiken nog niet de nieuwe structuur met duidelijke secties, kaarten, samenvattingen en actieblokken.

### 2. Inhoud is bruikbaar, presentatie vaak niet

De inhoud van bijvoorbeeld `craving-gevoel.htm`, `lastige-gevoelens.htm`, `stimulus-respons.htm` en `plan-van-aanpak.htm` is inhoudelijk sterk, maar op mobiel te lang, te compact en te weinig gefaseerd.

### 3. Data-opslag is nog niet breed geïntegreerd

`iam/js/dataStore.js` ondersteunt nu vooral de moderne flow voor een beperkt aantal formulieren. De meeste gemigreerde pagina's slaan nog niet netjes op in de centrale datastructuur.

### 4. Legacy interactie moet vervangen worden

Oude functies zoals hulpvensters, cookie-save/load en popup-achtige navigatie moeten vervangen worden door expliciete mobiele componenten in de pagina zelf.

## Aanbevolen volgorde

### Fase 1: Basis-layout patroon vastzetten

Maak een herbruikbaar pagina-patroon voor alle leidende formulieren:

- hero of page-header
- korte introkaart
- inhoud opgesplitst in losse cards / secties
- actieblok onderaan
- teruglink naar de home of vorige stap
- expliciete save/export status

Doel: elke pagina voelt direct herkenbaar als onderdeel van dezelfde app.

### Fase 2: Kerncomponenten maken

Voeg in CSS en HTML een vaste set componenten toe:

- `page-shell`
- `page-header`
- `intro-card`
- `question-card`
- `note-card`
- `action-bar`
- `progress-card`
- `helper-text`

Doel: niet iedere pagina opnieuw "met de hand" vormgeven.

### Fase 3: Pagina's herschrijven per inhoudstype

Niet alles tegelijk. Migreer per type formulier:

1. reflectieformulieren
2. risicoinventarisaties
3. coping/noodplan formulieren
4. planning/voortgang formulieren

Per pagina geldt:

- inhoud behouden
- tekst opdelen in scanbare blokken
- lange instructies inkorten of in een uitklapbaar helpblok zetten
- vragen in cards plaatsen
- formulieren mobiel invulbaar maken zonder horizontaal scrollen

### Fase 4: Centrale opslag koppelen

Voor elke leidende pagina:

- een eigen sleutel in `iam/js/dataStore.js`
- laden bij openen
- autosave op input
- exporteerbaar binnen de algemene JSON-structuur

Doel: alle actieve formulieren gebruiken dezelfde datapool.

### Fase 5: Navigatie en samenhang verbeteren

Voeg per pagina toe:

- terug naar home
- vorige / volgende stap waar logisch
- zicht op waar deze pagina in de kernflow hoort
- eventueel samenvattende status op de homepagina

Doel: de app voelt als één route in plaats van losse formulieren.

### Fase 6: Opschonen

Zodra een leidende pagina echt modern en actief is:

- oude knoppen of scripts verwijderen
- dubbele versies vermijden
- documentatie bijwerken
- vastleggen dat de nieuwe variant leidend is

## Eerste concrete kandidaten

De beste volgende pagina's om om te zetten zijn:

1. `craving-gevoel.htm`
2. `lastige-gevoelens.htm`
3. `stimulus-respons.htm`
4. `plan-van-aanpak.htm`

Reden:

- ze liggen in de kernflow
- ze hebben inhoudelijk veel waarde
- ze laten samen goed zien hoe reflectie, risicoanalyse en planning eruit moeten zien

## Praktische ontwerpregels voor mobiel

- maximaal één duidelijke hoofdvraag per card
- tekstblokken inkorten tot scanbare paragrafen
- geen tabellen voor kerninteractie tenzij ze mobiel gestapeld worden
- knoppen minimaal touch-vriendelijk
- belangrijke uitleg bovenaan, verdiepende uitleg lager of optioneel
- velden moeten direct bruikbaar zijn zonder zoom of horizontaal scrollen

## Definitie van klaar

Een pagina is pas "klaar" als:

- ze leesbaar is op telefoonscherm
- ze visueel past bij de IAM-home
- ze geen legacy save/load cookie-afhankelijkheid meer heeft
- ze gekoppeld is aan de centrale datastore of daar bewust nog buiten is gehouden
- ze in documentatie als leidende variant herkenbaar is