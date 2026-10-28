# Wat is Verslaving? — IAM-perspectief & AI-richtlijn
*(Kennisbasis voor ontwikkeling en optionele AI-ondersteuning)*

---

## 1. Doel van dit document
Dit document beschrijft een respectvol IAM-perspectief op verslaving en richtlijnen voor de optionele AI-ondersteuning. Het is een denkkader, geen diagnostisch instrument, behandelprotocol of volledige weergave van wetenschappelijke consensus. De gebruiker bepaalt zelf welke verklaringen en doelen herkenbaar en bruikbaar zijn.

---

## 2. Een niet-veroordelend perspectief op patronen

Middelengebruik en andere hardnekkige patronen kunnen samenhangen met onder meer beloning en gewoontevorming, stress, lichamelijke afhankelijkheid, emoties, sociale omgeving en de functie die het gedrag voor iemand heeft. Welke factoren meespelen verschilt per persoon en situatie. IAM gebruikt dit perspectief om nieuwsgierig en zonder moreel oordeel te onderzoeken wat iemand ervaart en nodig heeft.

Schaamte of zelfverwijt kan voor sommige mensen extra belasting geven. Dat betekent niet dat elke ervaring op dezelfde manier verklaard kan worden, of dat andere herstelbenaderingen voor iedereen ongeschikt zijn. Een gebruiker kan bijvoorbeeld baat hebben bij professionele zorg, lotgenotencontact, een 12-stappenprogramma, minderen, stoppen of een andere eigen route.

### Een mogelijke metafoor: het overlevingsalarm

Sommige mensen vinden het helpend om sterke trek te zien als een aangeleerd alarmsignaal dat heel belangrijk of urgent voelt. “Gekaapt denkend brein” kan als beeldspraak helpen om afstand te nemen van een impuls. Het is geen letterlijke scheiding van hersendelen, geen vastgestelde verklaring voor iemands ervaring en geen reden om gedachten “smoezen” te noemen.

Trek is een echte ervaring, maar niet automatisch een opdracht of bewijs van wat iemand moet doen. De gebruiker kan onderzoeken welke behoeften, gevoelens, lichamelijke signalen en omstandigheden meespelen, zonder dat de app of AI daar alvast een oorzaak voor invult.

---

## 3. Mogelijke steun: zelfregulatie en steun van anderen

Afhankelijk van wat iemand zelf helpend vindt, kunnen onder meer deze opties verkend worden:

1. **Zelfregulatie:** vertragen, een gevoel of lichamelijk signaal opmerken, aarden of een kleine activiteit kiezen. Geen enkele techniek past bij iedereen; de gebruiker mag stoppen of iets anders proberen.
2. **Steun van anderen:** contact zoeken met iemand die de gebruiker zelf als veilig en behulpzaam ervaart, een behandelaar of een andere steunbron. Vraag niet automatisch om contactgegevens en dring contact niet op.

AI kan opties helpen verkennen, maar kan niet vaststellen wat de oorzaak van klachten is en vervangt geen medische of professionele beoordeling. Ontwenning kan bij sommige middelen medisch riskant zijn. Raadpleeg bij ernstige, verontrustende of moeilijk vol te houden klachten een zorgprofessional; bij direct gevaar de lokale hulpdiensten.

---

## 4. Instructies voor optionele AI-ondersteuning

Deze instructies zijn een startpunt voor de AI die de gebruiker zelf kiest. De gebruiker kan ze aanpassen of niet gebruiken. Ze zijn geen garantie voor het gedrag, de privacy of de juistheid van een AI-aanbieder.

```markdown
Je bent een optionele reflectiehulp, geen behandelaar of beslisser.

- Reageer rustig, gelijkwaardig en zonder moreel oordeel. Gebruik geen labels die de gebruiker niet zelf kiest.
- Laat de doelen, waarden en gewenste uitkomst van de gebruiker leidend zijn. Neem niet aan dat die wil stoppen, minderen of een andere specifieke route wil volgen.
- Vraag bij onduidelijkheid eerst wat de gebruiker wil: gehoord worden, iets onderzoeken of mogelijke vervolgstappen verkennen. Stel hooguit één open vraag tegelijk.
- Behandel gevoelens en ervaringen als echt. Presenteer verklaringen als mogelijkheden, niet als feiten of diagnoses. Het “gekaapte brein” is een mogelijke metafoor, geen universele neurobiologische uitleg.
- Noem gedachten geen smoezen en dring geen ademhalingsoefening, plan, contact of andere techniek op.
- Bied kleine, concrete opties aan als voorstellen die de gebruiker mag weigeren of aanpassen. Laat ruimte voor onzekerheid, verandering van inzicht en een andere herstelroute.
- Vraag niet om identificerende persoonsgegevens. Herhaal of verspreid gevoelige details niet onnodig.
- Wees eerlijk dat AI fouten kan maken en geen professionele zorg vervangt. Bij direct gevaar of mogelijk medisch riskante ontwenning: adviseer passende menselijke, professionele of urgente hulp.
```

---

## 5. Technische Implementatierichtlijnen voor IAM
* **Opt-in en overzicht:** AI is optioneel. Toon precies welke tekst wordt voorbereid en laat de gebruiker die aanpassen vóór kopiëren. Voeg geen opgeslagen context ongemerkt toe.
* **Gegevensminimalisatie:** Neem alleen context op die nodig is voor de concrete vraag. Voeg geen naam, telefoonnummer of ander steuncontact automatisch toe.
* **Geen automatische verzending:** De IAM AI-bridge bereidt tekst lokaal voor en kopieert pas na een afzonderlijke handeling van de gebruiker. De gebruiker kiest zelf of die tekst in een externe AI-dienst wordt geplakt en verzonden.
* **Eerlijke privacy-uitleg:** Lokale browseropslag betekent niet dat gegevens op het apparaat risicoloos zijn. Na delen gelden de voorwaarden en instellingen van de gekozen AI-aanbieder; beloof geen absolute vertrouwelijkheid.
* **Consistente implementatie:** Houd de prompt in [aiBridge.js](../js/aiBridge.js), deze richtlijn, [alignment.md](alignment.md) en [privacy-en-ai-faq.md](privacy-en-ai-faq.md) op één lijn.
