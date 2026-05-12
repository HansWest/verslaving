# Fase B - Kruisbestuiving Matrix

Doel: kruisbestuiving buiten de crisis-trio uitrollen met kleine, veilige patches.

Scope doelpagina's:
- risico-denken.htm
- risico-gevoelens.htm
- voor-nadelen-balansen.htm
- plan-van-aanpak.htm

## Ontwerpregels voor Fase B

1. Maximaal 3-5 suggesties per doelveld (overload voorkomen).
2. Elke suggestie toont bronlabel.
3. Voeg suggestie toe met appendUniqueLine-principe (geen dubbele regels).
4. Geen hernoemen van bestaande form keys of velden.
5. Elke doelpagina eindigt met een directe nu-doen actie.

## Prioriteitsoverzicht

### Hoog (nu uitvoeren)
1. plan-van-aanpak.htm als centrale samenvatting blijft primaire ontvanger.
2. voor-nadelen-balansen.htm koppelen aan waarom-wel-gebruiken + behoefte/alternatief.
3. risico-denken.htm en risico-gevoelens.htm tweerichtingskoppeling voor cognitie-emotie.

### Midden (volgende iteratie)
1. Koppelingen naar stimulus-respons en lastige-gevoelens uitbreiden.
2. Koppelingen naar steunvelden (via supportNetwork) consistent maken.

### Laag (later)
1. Fine-grained contextfilters op urgentie of fase.
2. Extra dedupe-logica voor semantisch vergelijkbare regels.

## Matrix A - Doelpagina risico-denken.htm

Doelvelden:
- voorbeeldGedachten
- hoogRisicoDenken
- onderzoekAntwoorden
- alternatiefDenken
- interneRisicosDenken

Bron -> Doel koppelingen:
1. risico-gevoelens.psGedachten -> hoogRisicoDenken (Hoog)
2. risico-gevoelens.interneRisicos -> interneRisicosDenken (Hoog)
3. smoezenboek.* kernregels -> hoogRisicoDenken (Midden)
4. stimulus-respons.cognitive -> alternatiefDenken (Hoog)
5. voor-nadelen-balansen.decisionNote -> onderzoekAntwoorden (Midden)

Nu-doen CTA op pagina:
- "Kies 1 gedachte die je vandaag actief vervangt" en stuur naar stimulus-respons of trek-opvangen.

## Matrix B - Doelpagina risico-gevoelens.htm

Doelvelden:
- voorbeeldGevoel
- cat1A/cat1B/cat1C
- cat1Plan
- cat2A/cat2B/cat2C
- cat2Plan
- psGedachten
- interneRisicos

Bron -> Doel koppelingen:
1. risico-denken.hoogRisicoDenken -> psGedachten (Hoog)
2. risico-denken.alternatiefDenken -> cat1Plan (Hoog)
3. lastige-gevoelens.acceptancePractice -> cat1Plan (Midden)
4. lastige-gevoelens.talkPeople -> cat2Plan (Hoog)
5. sociaal-netwerk.reachableSupport -> cat2Plan (Midden)

Nu-doen CTA op pagina:
- "Kies 1 gevoel + 1 regulatiestap voor de komende 24 uur" met route naar stimulus-respons of noodplan-forse-trek.

## Matrix C - Doelpagina voor-nadelen-balansen.htm

Doelvelden:
- usageAdvantagesText
- usageDisadvantagesText
- changeAdvantagesText
- changeDisadvantagesText
- decisionNote
- alle wegingvelden (short/long)

Bron -> Doel koppelingen:
1. waarom-wel-gebruiken.functionSummary -> usageAdvantagesText (Hoog)
2. waarom-wel-gebruiken.notFeeling/notThinking -> usageAdvantagesText (Hoog)
3. trek-opvangen.behoefte -> changeAdvantagesText (Hoog)
4. trek-opvangen.alternatief -> changeAdvantagesText (Hoog)
5. plan-van-aanpak.mainGoal -> decisionNote (Midden)

Nu-doen CTA op pagina:
- "Kies 1 balanspunt dat je deze week extra gewicht geeft" en voeg toe aan plan-van-aanpak.planA.

## Matrix D - Doelpagina plan-van-aanpak.htm

Doelvelden:
- startPoint
- mainGoal
- usageGoal
- planA
- planB
- fallbackGoal
- supportPeople
- rewards

Bron -> Doel koppelingen (reeds deels aanwezig, nu formaliseren):
1. voor-nadelen-balansen.decisionNote -> mainGoal / planA (Hoog)
2. risico-situaties.responsePlan -> planA (Hoog)
3. risico-activiteiten.preparationPlan/exitStrategy -> planA (Hoog)
4. risico-activiteiten.afterRisks -> planB (Hoog)
5. risico-mensen.personName + sociaal-netwerk.reachableSupport -> supportPeople (Hoog)
6. stimulus-respons.contingencyReward -> rewards (Midden)
7. soorten-trek.noGoSignals -> fallbackGoal (Midden)

Nu-doen CTA op pagina:
- "Plan A mini-stap binnen 24 uur" en "Evaluatiemoment" verplicht zichtbaar.

## Implementatievolgorde (kleine patches)

Patch 1 (laag risico):
1. Voeg op risico-denken en risico-gevoelens een compacte suggestiebox toe (3 suggesties max).
2. Alleen read + add-to-field, geen routeringswijziging.

Patch 2:
1. Breid voor-nadelen-balansen suggestielaag uit met expliciete bronlabels.
2. Koppel gekozen suggestie direct aan decisionNote of changeAdvantagesText.

Patch 3:
1. Verfijn plan-van-aanpak applySuggestionFromPreviousSteps met prioriteit op 1 regel per bron.
2. Voeg feedbacktekst toe per toegepaste broncategorie.

Patch 4:
1. Voeg contextafhankelijke nu-doen CTA's toe op alle vier pagina's.
2. Beperk CTA-keuzes op urgentie (laag/middel/hoog).

## Verificatie (Fase B)

1. Elke doelpagina toont max 5 suggesties.
2. Suggesties hebben bronlabel en veroorzaken geen dubbele regels.
3. Save/reload behoudt toegevoegde regels.
4. Geen console errors tijdens suggestieklik en route-CTA.
5. Gebruiker kan vanaf elke pagina binnen 1 klik naar een uitvoerbare vervolgactie.
