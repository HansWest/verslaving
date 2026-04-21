# Taalharmonisatie Inventaris En Prioriteit

Deze inventaris maakt de uitbreiding uitvoerbaar: actieve IAM, legacy HTML, PHP en JS.

## Samenvatting aantallen

| Gebied | Type | Aantal | Prioriteit | Reden |
|---|---:|---:|---|---|
| iam/htm | HTML/HTM | 54 | Hoog | Actieve gebruikersflow en dashboard |
| iam/js | JS | 2 | Hoog | Dynamische labels, meldingen, integratie |
| htm-version | HTML/HTM | 25 | Midden | Legacy referentie, mogelijk nog handmatig gebruikt |
| IntegrativeAddictionManagement/htm | HTML/HTM | 48 | Midden | Oudere parallelle variant, veel overlap |
| IntegrativeAddictionManagement/htm | JS | 1 | Midden | In-page formulierlogica (zichtbare tekst mogelijk) |
| IntegrativeAddictionManagement/login_behandelaar.php | PHP | 1 | Midden | Server-side UI-uitvoer |
| IntegrativeAddictionManagement/skripts | JS | 2 | Laag-Midden | Ondersteunend/legacy scripts |

## In scope per bestandstype

- HTML/HTM: titels, knoppen, labels, placeholders, helpteksten, meldingen in inline script.
- PHP: alle zichtbare output-strings, validatiemeldingen, knoplabels.
- JS: alerts, confirms, statusberichten, dynamische knop- en labelteksten.

Niet in scope:

- Hernoemen van variabelen, functies, form keys, routes of API-parameters.
- Structurele refactor van JS/PHP.

## Wave-plan (uitvoerbaar)

1. Wave 1 (Hoog): iam/htm + iam/js
2. Wave 2 (Midden): IntegrativeAddictionManagement/htm + login_behandelaar.php
3. Wave 3 (Midden): htm-version
4. Wave 4 (Laag-Midden): IntegrativeAddictionManagement/skripts en restpunten

## Controle per wave

1. Tekstcontrole: geen zichtbare Engels meer in scope-bestanden.
2. Functioneel: opslaan, laden, export, print, navigatie blijven werken.
3. Technisch: geen nieuwe JS-errors; geen PHP parse errors.
4. Consistentie: termenlijst overal hetzelfde gebruikt.

## Voorstel termenset (kort)

- Craving -> Craving
- Trek -> Trek
- Mood -> Stemming
- Progress -> Voortgang
- Save -> Opslaan
- End check -> Eindcheck
- Round score -> Rondescore

## Terminologie-opmerking

- `Craving` blijft een geldige term in de Nederlandstalige IAM-tekstlaag.
- Bij taalharmonisatie geldt dus niet: alles wat Engels oogt moet vertaald worden.
- Voor `craving` kiezen we bewust voor inhoudelijke precisie boven geforceerde vernederlandsing.

## Praktische startlijst (Hoogste impact)

- iam/htm/index.htm
- iam/htm/trek-opvangen.htm
- iam/htm/trek-opvangen-2.htm
- iam/htm/noodplan-forse-trek.htm
- iam/htm/to_self_manage_game.htm
- iam/js/dataStore.js

## Opmerking over overlap

Er is duidelijke overlap tussen iam/htm en IntegrativeAddictionManagement/htm. Om dubbel werk te beperken eerst de leidende set afronden, daarna legacy alleen waar nog actief gebruikt of expliciet gewenst.
