# Pagina Review Checklist (kort)

Gebruik deze checklist bij elke IAM-pagina die je aanpast.

## 1) Slider-check (numeriek waar mogelijk)

- Is er minimaal 1 invoerveld dat beter als numerieke schaal kan (bijv. 0-100)?
- Als ja: is een slider toegevoegd of is kort vastgelegd waarom dit niet past?
- Is de schaal helder uitgelegd (wat betekent laag/hoog)?

## 2) Opslag en data

- Wordt de sliderwaarde opgeslagen in `dailyEntries` of de juiste form-data?
- Werkt laden/heropenen van de pagina met dezelfde waarde?
- Is de default-waarde bewust gekozen (niet toevallig)?

## 3) Zichtbaarheid en gebruik

- Ziet de gebruiker de actuele numerieke waarde naast de slider?
- Is de tekstlabel concreet en begrijpelijk (geen vaag jargon)?
- Werkt de slider goed op mobiel (duidelijk, niet te klein)?

## 4) Historie en export

- Komt de waarde terug in historie-overzicht waar relevant?
- Zit de waarde in CSV/JSON-export als het dagdata betreft?
- Blijft bestaande data backward-compatible (oude entries breken niet)?

## 5) Pedagogische check

- Helpt de slider de gebruiker sneller kiezen of reflecteren?
- Leidt de slider naar concrete actie (niet alleen meten om te meten)?
- Sluit de schaal aan op IAM-taal: kort, praktisch, richting gedrag.

## Beslisregel

Bij twijfel: eerst klein implementeren op 1 pagina, 7 dagen gebruiken, daarna opschalen naar andere IAM-pagina's.
