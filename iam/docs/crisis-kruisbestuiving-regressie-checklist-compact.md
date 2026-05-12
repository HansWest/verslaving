# Compacte Testuitvoerversie: Crisis-Kruisbestuiving (Fase B)

**Versie:** v1.0.0-fase-b-ready  
**Datum:** 12 mei 2026  
**Doel:** In 15-20 minuten bepalen of release veilig is (GO/NO-GO).

---

## 0) Testgegevens

- [ ] Tester: __________________________
- [ ] Datum/tijd: __________________________
- [ ] Browser: Chrome / Firefox / Safari / Edge
- [ ] Viewport: Desktop / 768px / 375px

---

## 1) Snelle Smoke Test (5 min)

### Crisis-trio pagina's
- iam/htm/noodplan-forse-trek.htm
- iam/htm/plan-bij-uitglijden.htm
- iam/htm/noodplan-wegglijden.htm

Voer uit:
1. [ ] Vul op elke pagina minimaal 1 veld in.
2. [ ] Controleer: inline save-feedback zichtbaar, geen alert-popup.
3. [ ] Voeg op elke pagina 1 suggestie toe via "Ideeen en hulpjes uit andere crisispagina's".
4. [ ] Klap hulpkaarten in, refresh, controleer persistente state.
5. [ ] Klik "Zet herstelbasis klaar in agenda" en check agenda-overname.

Pass:
- [ ] Geen console errors
- [ ] Geen dataverlies na refresh
- [ ] Geen dubbele regels bij "Voeg toe"

Resultaat Smoke Test:
- [ ] GO
- [ ] NO-GO

---

## 2) Fase B Kerncheck (7-10 min)

### Fase B pagina's (10)
- iam/htm/risico-situaties.htm
- iam/htm/risico-mensen.htm
- iam/htm/risico-activiteiten.htm
- iam/htm/soorten-trek.htm
- iam/htm/risico-gevoelens.htm
- iam/htm/risico-denken.htm
- iam/htm/voor-nadelen-balansen.htm
- iam/htm/stimulus-respons.htm
- iam/htm/lastige-gevoelens.htm
- iam/htm/plan-van-aanpak.htm

Voer uit:
1. [ ] Voeg op minimaal 6 van de 10 pagina's 1 cross-suggestie toe.
2. [ ] Controleer op suggestiepagina's: max 5 suggesties, bronlabel zichtbaar, geen duplicaat.
3. [ ] Test nu-doen routekaart op pagina's met route (urgentie/focus wijzigen + routeknop klikken).
4. [ ] Controleer dat hinttekst direct wijzigt bij selectie.
5. [ ] Refresh 3 laatst gewijzigde pagina's en check persistentie.

Pass:
- [ ] Geen runtime errors
- [ ] Route opent bijpassende vervolgpagina
- [ ] Toegevoegde regels blijven bewaard

Resultaat Fase B Kerncheck:
- [ ] GO
- [ ] NO-GO

---

## 3) Mobiele regressie (3 min)

Voer uit op 375px en 768px:
1. [ ] Knoppen goed klikbaar
2. [ ] Geen horizontale scroll
3. [ ] Nieuwe cards blijven binnen viewport

Resultaat Mobiel:
- [ ] GO
- [ ] NO-GO

---

## 4) Eindbesluit (1 min)

**GO als ALLES waar is:**
- [ ] Smoke Test = GO
- [ ] Fase B Kerncheck = GO
- [ ] Mobiel = GO
- [ ] Console errors = geen

**NO-GO als EEN of meer waar is:**
- [ ] Data verdwijnt na refresh
- [ ] Runtime error in console
- [ ] Routeknop opent niet of foutief
- [ ] Duplicaatregels bij suggesties

Eindbesluit:
- [ ] GO - Veilig om verder uit te rollen
- [ ] NO-GO - Fix nodig voor uitrol

---

## 5) Issue-notatie (bij NO-GO)

Gebruik per issue 1 regel:

`[P0|P1|P2] Pagina - Stap - Verwacht vs Gezien - Repro (ja/nee) - Status (open/fixed)`

Voorbeeld:

`[P1] risico-activiteiten.htm - Routeklik - Verwacht: actiepagina opent, Gezien: geen navigatie - Repro: ja - Status: open`
