# Regressiechecklist crisis-kruisbestuiving

Doel: snel valideren dat de drie crisispagina's onderling goed samenwerken (1+1=3), zonder dat bestaand gedrag of opgeslagen data breekt.

Scope:
- iam/htm/noodplan-forse-trek.htm
- iam/htm/plan-bij-uitglijden.htm
- iam/htm/noodplan-wegglijden.htm
- iam/js/crisisCrossflow.js

## Voorbereiding

1. Open elke pagina ten minste eenmaal in dezelfde browser-sessie.
2. Zorg dat localStorage beschikbaar is (geen private mode met blokkades).
3. Vul op elke pagina minimaal 2 velden in zodat kruisbestuiving zichtbaar kan worden.

## Kernflow A: Laden en opslaan

1. Open noodplan forse trek.
2. Vul in: direct doen, steunnetwerk, SOS-signaal.
3. Controleer dat opslaan feedback toont (inline message, geen alert-popup).
4. Herlaad de pagina.
5. Verwacht resultaat: ingevulde waarden blijven staan.

Herhaal voor:
- plan bij uitglijden
- noodplan wegglijden

Pass criteria:
- Data blijft behouden na refresh.
- Geen JavaScript-fouten in console.

## Kernflow B: Kruisbestuiving kaart

1. Open op elke pagina de card "Ideeen en hulpjes uit andere crisispagina's".
2. Controleer dat suggesties bronlabel hebben (bijv. plan bij uitglijden / noodplan wegglijden / noodplan forse trek).
3. Klik op "Voeg toe" bij minstens 1 suggestie.
4. Controleer dat tekst in het doelveld terechtkomt.
5. Herlaad de pagina.

Pass criteria:
- Toegevoegde regels blijven staan na refresh.
- Geen dubbele regel als dezelfde suggestie opnieuw wordt toegevoegd.

## Kernflow C: Inklappen / uitklappen persistentie

1. Klap "Voorbeeldbericht aan steun" in.
2. Klap "Ideeen en hulpjes uit andere crisispagina's" in.
3. Herlaad de pagina.

Pass criteria:
- Beide componenten onthouden hun collapse-state.
- Gedrag werkt identiek op alle drie de pagina's.

## Kernflow D: Supportsuggesties en scripts

1. Voeg op een pagina een steunnaam toe via supportsuggestie-knop.
2. Controleer dat de naam in het steunveld komt.
3. Controleer dat voorbeeldberichten direct herberekend worden.
4. Gebruik knop "Kopieer" op een voorbeeldbericht.

Pass criteria:
- Kopieeractie geeft inline feedback.
- Geen blocking alert-popups in de drie crisispagina's.

## Kernflow E: Zachte afhankelijkheidswaarschuwing

noodplan wegglijden:
1. Zet "steunnetwerk kent dit plan" op ja.
2. Laat contactvelden leeg.
3. Controleer dat zachte waarschuwing verschijnt.
4. Vul een contact in.
5. Controleer dat waarschuwing verdwijnt.

plan bij uitglijden:
1. Zet route-support op ja.
2. Laat steunveld leeg.
3. Controleer dat waarschuwing verschijnt.

noodplan forse trek:
1. Vul "direct doen" in.
2. Laat steunnetwerk leeg.
3. Controleer dat waarschuwing verschijnt.

Pass criteria:
- Waarschuwing is informerend (niet blokkerend).
- Waarschuwing verdwijnt zodra afhankelijkheid logisch is opgelost.

## Kernflow F: Agenda-overdracht

1. Klik op "Zet herstelbasis klaar in agenda".
2. Open agenda-pagina.
3. Controleer dat kernvelden gevuld zijn (moeten/gunnen/niet doen, etc.).

Pass criteria:
- Agenda wordt bijgewerkt zonder foutmelding.
- Bestaande agenda-data wordt niet onnodig overschreven.

## Mobiele regressie (375px en 768px)

1. Open elke pagina in responsive mode op 375px.
2. Controleer dat supportknoppen en mini-knoppen goed klikbaar zijn.
3. Controleer dat er geen horizontale scroll ontstaat door de nieuwe cards.
4. Herhaal op 768px.

Pass criteria:
- Actieknoppen blijven leesbaar en klikbaar.
- Cards blijven binnen viewport.

## Console controle

Tijdens alle flows:
1. Open DevTools Console.
2. Controleer op errors/warnings bij load, save, suggestieklik, collapse en agenda-sync.

Pass criteria:
- Geen runtime errors in de drie crisispagina's.

## Aftekenen

- Datum test:
- Tester:
- Browser(s):
- Resultaat per kernflow A-F: PASS/FAIL
- Openstaande issues:
- Prioriteit:

## Snelle smoke test (5 minuten)

Doel: snel bepalen of de release veilig genoeg is voor verder gebruik.

1. Open alle drie de crisispagina's en vul op elke pagina 1 veld in.
2. Controleer op elke pagina:
- inline save-feedback zichtbaar
- geen alert-popup
3. Open op elke pagina de kaart "Ideeen en hulpjes uit andere crisispagina's" en voeg 1 suggestie toe.
4. Klap op een pagina beide hulpkaarten in, refresh, controleer dat de states bewaard zijn.
5. Klik op "Zet herstelbasis klaar in agenda" en controleer in agenda dat er velden zijn overgenomen.

Snelle go/no-go:
- GO als alle 5 stappen werken zonder console errors.
- NO-GO als een van deze kernstappen faalt.

## Aanvullende smoke test Fase B (7 minuten)

Doel: valideren dat kruisbestuiving en nu-doen routing buiten de crisis-trio blijven werken.

Scope:
- iam/htm/risico-denken.htm
- iam/htm/risico-gevoelens.htm
- iam/htm/voor-nadelen-balansen.htm
- iam/htm/plan-van-aanpak.htm
- iam/htm/stimulus-respons.htm
- iam/htm/lastige-gevoelens.htm

1. Open de 6 pagina's in dezelfde sessie en vul op minstens 3 pagina's elk 1 veld in.
2. Controleer op elke pagina met suggestiekaart:
- max 5 suggesties zichtbaar
- bronlabel zichtbaar
- knop "Voeg toe" werkt zonder dubbele regel
3. Controleer de nu-doen routekaart op:
- risico-denken
- voor-nadelen-balansen
- risico-gevoelens
- plan-van-aanpak
4. Wijzig urgentie/focus op elke routekaart en controleer dat de hinttekst mee verandert.
5. Klik op "Open aanbevolen actiepagina" en controleer dat de juiste vervolgpagina opent.
6. Refresh op 1 pagina na suggestie-toevoeging en controleer dat de toegevoegde regel behouden blijft.

Pass criteria:
- Geen runtime errors bij suggestieklik of route-openen.
- Hints en routeknop reageren direct op selectie.
- Toegevoegde regels blijven bewaard na reload.

## Handmatige klikscript per pagina (15-20 minuten)

Doel: per pagina exact dezelfde klikvolgorde uitvoeren, met expliciete expected outcomes.

### 1) risico-denken.htm

1. Open pagina en vul 1 regel in bij "hoogRisicoDenken".
2. Klik 1 keer op "Voeg toe" in de suggestiekaart.
3. Verander nu-doen selecties (urgentie + focus) en check hintwijziging.
4. Klik "Open aanbevolen actiepagina".

Expected:
- Suggestie komt in doelveld zonder duplicaat.
- Hinttekst verandert direct bij selectie.
- Routeknop opent bijpassende pagina.

### 2) risico-gevoelens.htm

1. Voeg 1 suggestie toe aan "cat1Plan" of "cat2Plan".
2. Wijzig routekeuze en klik op aanbevolen actiepagina.

Expected:
- Suggestie wordt opgeslagen.
- Route volgt geselecteerde urgentie/focus.

### 3) voor-nadelen-balansen.htm

1. Vul 2 gewichtsvelden in en controleer score/visual update.
2. Voeg 1 cross-suggestie toe.
3. Gebruik nu-doen kaart en open aanbevolen actiepagina.

Expected:
- Balansvisual reageert op scores.
- Suggestie vult correct doelveld.
- Route werkt op basis van selectie.

### 4) plan-van-aanpak.htm

1. Voeg 1 suggestie toe vanuit planCrossSuggestList.
2. Wijzig nu-doen route-instellingen en klik routeknop.

Expected:
- Feedbackmelding toont bron + doelveld.
- Route gaat naar analyse/herstel/nood of agenda volgens keuze.

### 5) stimulus-respons.htm en lastige-gevoelens.htm

1. Voeg op beide pagina's 1 suggestie toe.
2. Refresh beide pagina's.

Expected:
- Toegevoegde regels blijven bewaard.
- Geen dubbele regels bij herhaald toevoegen.

### 6) risico-situaties.htm en soorten-trek.htm

1. Voeg op beide pagina's 1 suggestie toe uit de nieuwe kaart.
2. Controleer dat bronlabel zichtbaar is.
3. Refresh en controleer persistentie.

Expected:
- Maximaal 5 suggesties zichtbaar.
- Bronlabel + doelveldvulling werkt.
- Waarden blijven staan na refresh.

### 7) risico-mensen.htm en risico-activiteiten.htm

1. Open op beide pagina's de nieuwe nu-doen routekaart.
2. Verander urgentie/focus en controleer of hinttekst direct wijzigt.
3. Klik op "Open aanbevolen actiepagina".
4. Voeg op beide pagina's 1 suggestie toe via de suggestiekaart.

Expected:
- Routehint reageert direct op selectie.
- Routeknop opent bijpassende vervolgpagina.
- Suggesties voegen toe zonder duplicate regels.

## E2E GO/NO-GO Integratietest (10 minuten)

Doel: in 1 doorlopende test bepalen of de volledige kruisbestuivingsketen stabiel is.

Volgorde pagina's:
1. risico-situaties.htm
2. risico-mensen.htm
3. risico-activiteiten.htm
4. soorten-trek.htm
5. risico-gevoelens.htm
6. risico-denken.htm
7. voor-nadelen-balansen.htm
8. stimulus-respons.htm
9. lastige-gevoelens.htm
10. plan-van-aanpak.htm

Teststappen:
1. Open de 10 pagina's in dezelfde sessie (tabbladen of één-voor-één).
2. Voeg op minimaal 6 van de 10 pagina's 1 cross-suggestie toe.
3. Gebruik op elke pagina met nu-doen routekaart 1 routewijziging en klik 1 keer op "Open aanbevolen actiepagina".
4. Keer terug naar plan-van-aanpak en voeg daar 1 extra suggestie toe.
5. Refresh de laatst gewijzigde 3 pagina's.

Pass criteria:
- Geen runtime errors bij suggestieklik of routeklik.
- Geen dubbele regels na herhaald "Voeg toe".
- Routehint en routeknop blijven consistent met de gekozen urgentie/focus.
- Toegevoegde regels blijven bewaard na refresh.

Eindbeslissing:
- GO: alle pass criteria zijn waar.
- NO-GO: minimaal 1 criterium faalt.
